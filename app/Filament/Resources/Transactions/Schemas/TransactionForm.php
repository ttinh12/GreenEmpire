<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Contract;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── Section 1: Thông tin giao dịch ────────────────────────
            Section::make('Thông tin giao dịch')
                ->icon('heroicon-o-arrows-right-left')
                ->columns(2)
                ->schema([
                    TextInput::make('reference_code')
                        ->label('Mã giao dịch')
                        ->placeholder('VD: TXN-2024-001')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(50)
                        ->default(fn () => 'TXN-' . now()->format('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)),

                    DatePicker::make('transaction_date')
                        ->label('Ngày giao dịch')
                        ->required()
                        ->default(now()),

                    Select::make('type')
                        ->label('Loại giao dịch')
                        ->options([1 => 'Thu nhập', 2 => 'Chi phí'])
                        ->required()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(fn ($set) => $set('category_id', null)),

                    Select::make('category_id')
                        ->label('Danh mục')
                        ->options(function ($get) {
                            $type = $get('type');
                            if (!$type) return TransactionCategory::where('is_active', true)->pluck('name', 'id');
                            return TransactionCategory::where('type', $type)->where('is_active', true)->pluck('name', 'id');
                        })
                        ->required()
                        ->searchable()
                        ->native(false),

                    TextInput::make('amount')
                        ->label('Số tiền (₫)')
                        ->numeric()
                        ->prefix('₫')
                        ->required()
                        ->minValue(0),

                    Select::make('department_id')
                        ->label('Phòng ban')
                        ->options(Department::where('is_active', true)->pluck('name', 'id'))
                        ->nullable()
                        ->searchable()
                        ->native(false),

                    Textarea::make('description')
                        ->label('Mô tả giao dịch')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            // ── Section 2: Liên kết nghiệp vụ ─────────────────────────
            Section::make('Liên kết nghiệp vụ')
                ->icon('heroicon-o-link')
                ->description('Gắn giao dịch với hợp đồng hoặc hóa đơn (tùy chọn)')
                ->columns(2)
                ->schema([
                    Select::make('contract_id')
                        ->label('Hợp đồng liên quan')
                        ->options(Contract::orderBy('code')->pluck('title', 'id'))
                        ->nullable()
                        ->searchable()
                        ->native(false),

                    Select::make('invoice_id')
                        ->label('Hóa đơn liên quan')
                        ->options(Invoice::orderBy('code')->pluck('code', 'id'))
                        ->nullable()
                        ->searchable()
                        ->native(false),

                    TextInput::make('reference_doc')
                        ->label('Số chứng từ')
                        ->placeholder('VD: PC-001, BC-045')
                        ->maxLength(200),

                    FileUpload::make('attachment')
                        ->label('Đính kèm chứng từ')
                        ->directory('transactions/attachments')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->maxSize(5120)
                        ->helperText('PDF, JPG, PNG – tối đa 5MB'),
                ]),

            // ── Section 3: Phê duyệt ───────────────────────────────────
            Section::make('Phê duyệt')
                ->icon('heroicon-o-check-badge')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Select::make('approved_by')
                        ->label('Người phê duyệt')
                        ->relationship('approver', 'name')
                        ->searchable()
                        ->nullable()
                        ->native(false),

                    DatePicker::make('approved_at')
                        ->label('Ngày phê duyệt')
                        ->nullable(),
                ]),
        ]);
    }
}