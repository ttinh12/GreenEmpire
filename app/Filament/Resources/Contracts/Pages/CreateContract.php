<?php

namespace App\Filament\Resources\Contracts\Pages;

use App\Filament\Resources\Contracts\ContractResource;
use App\Models\Task;
use Filament\Resources\Pages\CreateRecord;

class CreateContract extends CreateRecord
{
    protected static string $resource = ContractResource::class;

    // Xóa field task_assignee_id trước khi lưu vào DB
    // (vì bảng contracts không có cột này)
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Lưu tạm vào property để dùng ở afterCreate()
        $this->taskAssigneeId = $data['task_assignee_id'] ?? null;

        // Xóa khỏi data trước khi INSERT vào bảng contracts
        unset($data['task_assignee_id']);

        return $data;
    }

    public ?int $taskAssigneeId = null;

    protected function afterCreate(): void
    {
        $contract = $this->getRecord();

        $templateTasks = [
            [
                'title'       => 'Kickoff meeting với khách hàng',
                'description' => 'Tổ chức buổi họp khởi động dự án với khách hàng, giới thiệu team và thống nhất kế hoạch triển khai.',
                'priority'    => Task::PRIORITY_HIGH,
                'due_date'    => now()->addDays(7),
                'position'    => 1,
                'sort'        => 1,
            ],
            [
                'title'       => 'Lập kế hoạch triển khai',
                'description' => 'Xây dựng kế hoạch chi tiết, phân công công việc và xác định các mốc thời gian quan trọng.',
                'priority'    => Task::PRIORITY_HIGH,
                'due_date'    => now()->addDays(14),
                'position'    => 2,
                'sort'        => 2,
            ],
            [
                'title'       => 'Thực hiện hợp đồng',
                'description' => 'Triển khai các hạng mục công việc theo hợp đồng đã ký kết.',
                'priority'    => Task::PRIORITY_MEDIUM,
                'due_date'    => $contract->end_date
                    ? \Carbon\Carbon::parse($contract->end_date)->subDays(30)
                    : now()->addDays(60),
                'position'    => 3,
                'sort'        => 3,
            ],
            [
                'title'       => 'Nghiệm thu & bàn giao',
                'description' => 'Tổ chức nghiệm thu sản phẩm/dịch vụ với khách hàng và hoàn tất thủ tục bàn giao.',
                'priority'    => Task::PRIORITY_HIGH,
                'due_date'    => $contract->end_date
                    ? \Carbon\Carbon::parse($contract->end_date)->subDays(7)
                    : now()->addDays(80),
                'position'    => 4,
                'sort'        => 4,
            ],
            [
                'title'       => 'Thanh lý hợp đồng',
                'description' => 'Hoàn tất các thủ tục thanh lý hợp đồng, thu hồi công nợ và lưu trữ hồ sơ.',
                'priority'    => Task::PRIORITY_MEDIUM,
                'due_date'    => $contract->end_date
                    ? \Carbon\Carbon::parse($contract->end_date)
                    : now()->addDays(90),
                'position'    => 5,
                'sort'        => 5,
            ],
        ];

        $maxSort = Task::max('sort') ?? 0;

        foreach ($templateTasks as $index => $taskData) {
            Task::create([
                'contract_id' => $contract->id,
                'customer_id' => $contract->customer_id,
                'creator_id'  => auth()->id(),
                'assignee_id' => $this->taskAssigneeId, // ← Người được chọn
                'title'       => $taskData['title'],
                'description' => $taskData['description'],
                'priority'    => $taskData['priority'],
                'status'      => Task::STATUS_TODO,
                'due_date'    => $taskData['due_date'],
                'position'    => $taskData['position'],
                'sort'        => $maxSort + $index + 1,
            ]);
        }

        \Filament\Notifications\Notification::make()
            ->title('✅ Đã tạo ' . count($templateTasks) . ' tasks tự động!')
            ->body('Người thực hiện: ' . (
                $this->taskAssigneeId
                    ? \App\Models\User::find($this->taskAssigneeId)?->name
                    : 'Chưa assign'
            ))
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}