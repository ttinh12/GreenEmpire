<?php

namespace App\Filament\Resources\Contracts\Pages;

use App\Filament\Resources\Contracts\ContractResource;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs as Tabs;
use Filament\Schemas\Components\Tabs\Tab as Tab;
use Filament\Schemas\Components\Section as Section;
use Filament\Schemas\Components\Grid as Grid;
use Filament\Infolists\Components\TextEntry as TextEntry;
use Filament\Support\Enums\TextSize;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewContract extends ViewRecord
{
    protected static string $resource = ContractResource::class;


    public function getTitle(): string | Htmlable
    {
        return "Xem Hợp Đồng: " . ($this->record->title ?? "N/A");
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label("Chỉnh sửa hợp đồng"),
            \Filament\Actions\Action::make("downloadPdf")
                ->label("Tải PDF")
                ->icon("heroicon-o-document-arrow-down")
                ->color("success")
                ->url(fn($record) => route("contracts.pdf", ["id" => $record->id]))
                ->openUrlInNewTab(),
        ];
    }

    public function infolist(Schema $infolist): Schema
    {
        return $infolist
            ->schema([
                Section::make("THÔNG TIN HỢP ĐỒNG")
                    ->icon("heroicon-o-document-text")
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make("code")
                                    ->label("Mã hợp đồng")
                                    ->badge()
                                    ->color("primary"),
                                TextEntry::make("customer.name")
                                    ->label("Khách hàng")
                                    ->icon("heroicon-o-user"),
                                TextEntry::make("department.name")
                                    ->label("Phòng ban")
                                    ->placeholder("Không xác định")
                                    ->icon("heroicon-o-building-office"),
                            ]),
                        TextEntry::make("title")
                            ->label("Tên hợp đồng")
                            ->size(TextSize::Large)
                            ->weight("bold"),
                        TextEntry::make("description")
                            ->label("Mô tả")
                            ->placeholder("Không có")
                            ->columnSpanFull(),
                    ]),

                Tabs::make("Chi tiết hợp đồng")
                    ->tabs([
                        Tab::make("Giá trị")
                            ->icon("heroicon-o-currency-dollar")
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make("value")
                                            ->label("Giá trị trước thuế")
                                            ->numeric(decimalPlaces: 2, decimalSeparator: ",", thousandsSeparator: ".")
                                            ->money("VND")
                                            ->badge()
                                            ->color("info"),
                                        TextEntry::make("vat_rate")
                                            ->label("Thuế VAT")
                                            ->numeric(decimalPlaces: 0)
                                            ->suffix("%"),
                                        TextEntry::make("vat_amount")
                                            ->label("Tiền thuế VAT")
                                            ->numeric(decimalPlaces: 2, decimalSeparator: ",", thousandsSeparator: ".")
                                            ->money("VND"),
                                        TextEntry::make("total_value")
                                            ->label("Tổng giá trị")
                                            ->numeric(decimalPlaces: 2, decimalSeparator: ",", thousandsSeparator: ".")
                                            ->money("VND")
                                            ->badge()
                                            ->color("success")
                                            ->weight("bold"),
                                    ]),
                                TextEntry::make("payment_terms")
                                    ->label("Điều khoản thanh toán")
                                    ->placeholder("Thanh toán theo thỏa thuận")
                                    ->columnSpanFull(),
                            ]),

                        Tab::make("Thời hạn")
                            ->icon("heroicon-o-calendar")
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make("start_date")
                                            ->label("Ngày bắt đầu")
                                            ->date("d/m/Y"),
                                        TextEntry::make("end_date")
                                            ->label("Ngày kết thúc")
                                            ->date("d/m/Y"),
                                        TextEntry::make("signed_date")
                                            ->label("Ngày ký")
                                            ->date("d/m/Y"),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make("warranty_months")
                                            ->label("Bảo hành")
                                            ->suffix(" tháng"),
                                        TextEntry::make("status_label")
                                            ->label("Trạng thái")
                                            ->badge()
                                            ->color(fn(string $state): string => match ($state) {
                                                "Đang hoạt động" => "success",
                                                "Đã hoàn thành" => "info",
                                                "Quá hạn" => "danger",
                                                "Đã hủy" => "gray",
                                                default => "warning",
                                            }),
                                    ]),
                            ]),


                        Tab::make("Hàng mục")
                            ->icon("heroicon-o-list-bullet")
                            ->schema([
                                TextEntry::make("items.description")
                                    ->label("Danh sách hạng mục")
                                    ->bulleted(),
                            ]),

                        Tab::make("Tệp đính kèm")
                            ->icon("heroicon-o-paper-clip")
                            ->schema([
                                TextEntry::make("file_url")
                                    ->label("Tệp đính kèm")
                                    ->placeholder("Không có tệp đính kèm")
                                    ->url(fn($state) => $state ?: null),
                            ]),

                        Tab::make("Nhật ký")
                            ->icon("heroicon-o-clock")
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make("creator.name")
                                            ->label("Người tạo")
                                            ->icon("heroicon-o-user-circle"),
                                        TextEntry::make("created_at")
                                            ->label("Ngày tạo")
                                            ->dateTime("d/m/Y H:i:s"),
                                        TextEntry::make("updated_by")
                                            ->label("Người cập nhật cuối")
                                            ->icon("heroicon-o-user-circle"),
                                        TextEntry::make("updated_at")
                                            ->label("Lần cập nhật cuối")
                                            ->dateTime("d/m/Y H:i:s"),
                                    ]),
                            ]),
                        Tab::make('Tasks')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                \Filament\Infolists\Components\RepeatableEntry::make('tasks')
                                    ->label('')
                                    ->schema([
                                        TextEntry::make('title')
                                            ->label('Tiêu đề')
                                            ->weight('bold'),
                                        TextEntry::make('status')
                                            ->label('Trạng thái')
                                            ->badge()
                                            ->formatStateUsing(fn($state) => \App\Models\Task::statusLabels()[$state] ?? $state)
                                            ->color(fn($state) => match ((int)$state) {
                                                1 => 'gray',
                                                2 => 'warning',
                                                3 => 'info',
                                                4 => 'success',
                                                default => 'gray',
                                            }),
                                        TextEntry::make('assignee.name')
                                            ->label('Người thực hiện')
                                            ->default('Chưa assign'),
                                        TextEntry::make('due_date')
                                            ->label('Hạn xong')
                                            ->date('d/m/Y')
                                            ->default('—'),
                                    ])
                                    ->columns(4),
                            ]),
                    ]),
            ])->columns(1);
    }
}
