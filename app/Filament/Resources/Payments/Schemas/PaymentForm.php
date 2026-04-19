<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Invoice;
use App\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Chọn hóa đơn ──────────────────────────────
            Section::make('Hóa đơn thanh toán')
                ->description('Chọn hóa đơn cần ghi nhận thanh toán')
                ->icon('heroicon-o-receipt-percent')
                ->schema([
                    Select::make('invoice_id')
                        ->label('Hóa đơn')
                        ->options(
                            Invoice::with('customer')
                                ->get()
                                ->mapWithKeys(fn ($inv) => [
                                    $inv->id => $inv->code . ' — ' . ($inv->customer?->name ?? '—'),
                                ])
                        )
                        ->required()
                        ->searchable()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            if (!$state) return;
                            $invoice = Invoice::find($state);
                            if (!$invoice) return;
                            $remaining = $invoice->total_amount - $invoice->paid_amount;
                            if ($remaining > 0) {
                                $set('amount', $remaining);
                            }
                        })
                        ->columnSpanFull(),

                    Placeholder::make('invoice_info')
                        ->label('Tình trạng hóa đơn')
                        ->content(function ($get) {
                            $id = $get('invoice_id');
                            if (!$id) return '— Chưa chọn hóa đơn —';
                            $invoice = Invoice::with('customer')->find($id);
                            if (!$invoice) return '—';
                            $total     = number_format($invoice->total_amount, 0, ',', '.') . ' ₫';
                            $paid      = number_format($invoice->paid_amount, 0, ',', '.') . ' ₫';
                            $remaining = number_format(max(0, $invoice->total_amount - $invoice->paid_amount), 0, ',', '.') . ' ₫';
                            return "Tổng: {$total}   |   Đã thanh toán: {$paid}   |   Còn lại: {$remaining}";
                        })
                        ->columnSpanFull(),
                ]),

            // ── SECTION 2: Chi tiết + chứng từ (gộp chung) ───────────
            Section::make('Chi tiết thanh toán')
                ->description('Số tiền, phương thức và chứng từ đính kèm')
                ->icon('heroicon-o-banknotes')
                ->columns(2)
                ->schema([
                    TextInput::make('amount')
                        ->label('Số tiền thanh toán (₫)')
                        ->numeric()
                        ->prefix('₫')
                        ->required()
                        ->minValue(1),

                    DatePicker::make('payment_date')
                        ->label('Ngày thanh toán')
                        ->required()
                        ->default(now()),

                    Select::make('method')
                        ->label('Phương thức thanh toán')
                        ->options([
                            Payment::METHOD_BANK_TRANSFER => 'Chuyển khoản ngân hàng',
                            Payment::METHOD_CASH          => 'Tiền mặt',
                            Payment::METHOD_CHECK         => 'Séc',
                            Payment::METHOD_OTHER         => 'Khác',
                        ])
                        ->required()
                        ->default(Payment::METHOD_BANK_TRANSFER)
                        ->native(false),

                    TextInput::make('reference')
                        ->label('Số tham chiếu')
                        ->placeholder('Mã giao dịch ngân hàng, số biên lai...')
                        ->maxLength(100),

                    Textarea::make('notes')
                        ->label('Ghi chú')
                        ->placeholder('Ghi chú thêm nếu cần...')
                        ->rows(2)
                        ->columnSpanFull(),

                    FileUpload::make('attachment')
                        ->label('Chứng từ đính kèm')
                        ->directory('payments/attachments')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(5120)
                        ->imagePreviewHeight(80)
                        ->helperText('PDF, JPG, PNG – tối đa 5MB')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}