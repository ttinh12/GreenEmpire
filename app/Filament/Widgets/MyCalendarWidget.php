<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Guava\Calendar\Filament\CalendarWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Guava\Calendar\ValueObjects\FetchInfo;
use Guava\Calendar\ValueObjects\CalendarEvent;


class MyCalendarWidget extends CalendarWidget
{
    protected function getEvents(FetchInfo $info): Collection | array | Builder
    {
        return Task::query()
            ->where('assignee_id', auth()->id())
            ->whereNotNull('started_at')
            ->whereDate('started_at', '<=', $info->end)
            ->where(function ($query) use ($info) {
                $query->whereDate('due_date', '>=', $info->start)
                      ->orWhereNull('due_date');
            })
            ->get()
            ->map(function ($task) {
                return CalendarEvent::make()
                    ->title($task->title . ' (' . $task->priority_label . ')')
                    ->start($task->started_at)
                    ->end($task->due_date ?? $task->started_at)
                    ->backgroundColor(match($task->status) {
                        Task::STATUS_TODO        => '#6B7280',
                        Task::STATUS_IN_PROGRESS => '#3B82F6',
                        Task::STATUS_REVIEW      => '#F59E0B',
                        Task::STATUS_DONE        => '#10B981',
                        default => '#6B7280',
                    });
            });
    }
}