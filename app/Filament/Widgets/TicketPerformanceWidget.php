<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\User;
use App\Enums\TicketStatus;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TicketPerformanceWidget extends ChartWidget
{
    protected ?string $heading = 'Hiệu suất xử lý vé';

    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get all staff/admin users
        $staffUsers = User::whereIn('role', ['admin', 'staff'])->get();

        $labels = [];
        $completedData = [];
        $assignedData = [];

        foreach ($staffUsers as $user) {
            $labels[] = $user->name;

            // Count completed tickets (status = BANNED)
            $completedCount = Ticket::where('assign_id', $user->id)
                ->where('status', TicketStatus::BANNED->value)
                ->count();

            // Count assigned tickets (status = INACTIVE or BANNED)
            $assignedCount = Ticket::where('assign_id', $user->id)
                ->whereIn('status', [TicketStatus::INACTIVE->value, TicketStatus::BANNED->value])
                ->count();

            $completedData[] = $completedCount;
            $assignedData[] = $assignedCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Đã hoàn thành',
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)', // green
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // Xoay ngang biểu đồ
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                // ĐỔI TỪ 'y' SANG 'x' VÌ BIỂU ĐỒ ĐANG XOAY NGANG
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                        'stepSize' => 1,
                    ],
                ],
                // Trục y bây giờ chứa tên nhân viên, không cần ép số nguyên
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}