<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Models\Task;
use App\Models\User;
use App\Models\Customer;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Livewire\Attributes\On;

class TaskKanban extends Page
{
    protected static string $resource = \App\Filament\Resources\Tasks\TaskResource::class;
    protected string $view = 'filament.resources.tasks.pages.task-kanban';

    public ?int $filterAssignee = null;
    public ?int $filterCustomer = null;
    public ?int $filterPriority = null;

    public function getStatuses(): array
    {
        return [
            Task::STATUS_TODO        => ['label' => '📋 To Do',       'color' => 'gray'],
            Task::STATUS_IN_PROGRESS => ['label' => '🔄 In Progress', 'color' => 'amber'],
            Task::STATUS_REVIEW      => ['label' => '👀 Review',      'color' => 'blue'],
            Task::STATUS_DONE        => ['label' => '✅ Done',         'color' => 'green'],
        ];
    }

    public function getTasks(): \Illuminate\Support\Collection
    {
        return Task::query()
            ->with(['assignee', 'customer'])
            ->when($this->filterAssignee, fn($q) => $q->where('assignee_id', $this->filterAssignee))
            ->when($this->filterCustomer, fn($q) => $q->where('customer_id', $this->filterCustomer))
            ->when($this->filterPriority, fn($q) => $q->where('priority', $this->filterPriority))
          
            ->orderBy('sort')
            ->get()
            ->groupBy('status');
    }

    public function moveTask(int $taskId, int $newStatus): void
    {
        $task = Task::findOrFail($taskId);
        $updates = ['status' => $newStatus];

        if ($newStatus === Task::STATUS_IN_PROGRESS && !$task->started_at) {
            $updates['started_at'] = now();
        }

        if ($newStatus === Task::STATUS_DONE && !$task->completed_at) {
            $updates['completed_at'] = now();
        }

        $task->update($updates);
    }

    public function reorderTasks(array $orderedIds, int $status): void
    {
        foreach ($orderedIds as $index => $id) {
            Task::where('id', $id)->update([
                'sort'     => $index + 1,
                'position' => $index,
                'status'   => $status,
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('list_view')
                ->label('Danh sách')
                ->icon('heroicon-o-list-bullet')
                ->url(static::$resource::getUrl('index')),

            Action::make('create')
                ->label('Tạo Task')
                ->icon('heroicon-o-plus')
                ->url(static::$resource::getUrl('create')),
        ];
    }

    public function getUsers()
    {
        return User::orderBy('name')->get();
    }

    public function getCustomers()
    {
        return Customer::orderBy('name')->get();
    }
}