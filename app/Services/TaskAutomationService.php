<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskOverdueNotification;
use Filament\Notifications\Notification; // ✅ thêm dòng này

class TaskAutomationService
{
    public static function run()
    {
        $tasks = Task::with('assignee')->get();
        $now = now();

        foreach ($tasks as $task) {

            if (!$task->due_date || !$task->assignee) continue;

            // ================= QUÁ HẠN =================
            if ($task->due_date < $now && $task->status != Task::STATUS_DONE) {

                $alreadyNotified = $task->assignee
                    ->notifications()
                    ->where('type', TaskOverdueNotification::class)
                    ->where('data->task_id', $task->id)
                    ->where('data->type', 'overdue')
                    ->exists();

                if (!$alreadyNotified) {

                    // 🔔 lưu DB
                    $task->assignee->notify(
                        new TaskOverdueNotification($task, 'overdue')
                    );

                    // 🔴 HIỆN TRÊN FILAMENT
                    Notification::make()
                        ->title('❗ Task quá hạn')
                        ->body($task->title)
                        ->danger()
                        ->sendToDatabase($task->assignee);
                }

                // ================= ESCALATE =================
                if ($task->due_date->diffInDays($now) >= 2) {

                    $managers = User::where('role', 'admin')->get();

                    foreach ($managers as $manager) {

                        $alreadyEscalated = $manager
                            ->notifications()
                            ->where('type', TaskOverdueNotification::class)
                            ->where('data->task_id', $task->id)
                            ->where('data->type', 'escalate')
                            ->exists();

                        if (!$alreadyEscalated) {

                            $manager->notify(
                                new TaskOverdueNotification($task, 'escalate')
                            );

                            // 🚨 popup cho admin
                            Notification::make()
                                ->title('🚨 Task trễ nghiêm trọng')
                                ->body($task->title)
                                ->danger()
                                ->sendToDatabase($manager);
                        }
                    }
                }

                continue;
            }

            // ================= SẮP TỚI HẠN =================
            if ($task->due_date->diffInHours($now) <= 24 && $task->status != Task::STATUS_DONE) {

                $alreadyNotified = $task->assignee
                    ->notifications()
                    ->where('type', TaskOverdueNotification::class)
                    ->where('data->task_id', $task->id)
                    ->where('data->type', 'due_soon')
                    ->exists();

                if (!$alreadyNotified) {

                    $task->assignee->notify(
                        new TaskOverdueNotification($task, 'due_soon')
                    );

                    // 🟡 popup nhẹ
                    Notification::make()
                        ->title('⏰ Sắp tới hạn')
                        ->body($task->title)
                        ->warning()
                        ->sendToDatabase($task->assignee);
                }
            }
        }
    }
}