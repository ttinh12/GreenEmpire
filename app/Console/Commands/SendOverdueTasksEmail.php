<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendOverdueTasksEmail extends Command
{
    protected $signature   = 'tasks:send-overdue-email';
    protected $description = 'Send overdue tasks email warning';

    public function handle(): void
    {
        $overdueTasks = Task::query()
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->whereNotIn('status', [Task::STATUS_DONE])
            ->whereNull('deleted_at')
            ->with(['assignee', 'customer', 'contract'])
            ->get();

        if ($overdueTasks->isEmpty()) {
            $this->info('Khong co task qua han!');
            return;
        }

        // ← Chỉ gửi 1 email tổng hợp cho admin để test
        $adminEmail = 'cuongdinhso01@gmail.com';
        $adminName  = 'Quan Tri Vien';

        Mail::send([], [], function ($message) use ($adminName, $adminEmail, $overdueTasks) {
            $message->to($adminEmail, $adminName)
                ->subject('Canh bao: Co ' . $overdueTasks->count() . ' task qua han!')
                ->html($this->buildEmailHtml((object)['name' => $adminName], $overdueTasks));
        });

        $this->info("Da gui email tong hop cho admin: {$adminEmail} ({$overdueTasks->count()} tasks)");
        $this->info("Hoan thanh!");
    }

    private function buildEmailHtml($assignee, $tasks): string
    {
        $taskRows = '';
        foreach ($tasks as $task) {
            $daysOverdue  = now()->diffInDays($task->due_date);
            $dueDate      = $task->due_date->format('d/m/Y');
            $customerName = $task->customer ? $task->customer->name : '-';

            $taskRows .= "
        <tr>
            <td style='padding:10px; border-bottom:1px solid #eee;'>{$task->title}</td>
            <td style='padding:10px; border-bottom:1px solid #eee; color:#e74c3c;'>
                {$dueDate} (tre {$daysOverdue} ngay)
            </td>
            <td style='padding:10px; border-bottom:1px solid #eee;'>
                {$customerName}
            </td>
        </tr>
    ";
        }

        return "
        <div style='font-family:Arial,sans-serif; max-width:600px; margin:0 auto;'>
            <div style='background:#e74c3c; padding:20px; border-radius:8px 8px 0 0;'>
                <h2 style='color:white; margin:0;'>Canh Bao Task Qua Han</h2>
            </div>
            <div style='background:#f9f9f9; padding:20px;'>
                <p>Xin chao <strong>{$assignee->name}</strong>,</p>
                <p>Ban co <strong style='color:#e74c3c;'>{$tasks->count()} task</strong> da qua han:</p>
                <table style='width:100%; border-collapse:collapse; background:white; border-radius:8px;'>
                    <thead>
                        <tr style='background:#e74c3c; color:white;'>
                            <th style='padding:12px; text-align:left;'>Ten Task</th>
                            <th style='padding:12px; text-align:left;'>Han hoan thanh</th>
                            <th style='padding:12px; text-align:left;'>Khach hang</th>
                        </tr>
                    </thead>
                    <tbody>{$taskRows}</tbody>
                </table>
                <p style='margin-top:20px;'>Vui long xu ly ngay!</p>
                <a href='http://localhost:8000/admin/tasks'
                   style='background:#e74c3c; color:white; padding:10px 20px;
                          border-radius:5px; text-decoration:none; display:inline-block;'>
                    Xem Tasks
                </a>
            </div>
            <div style='background:#eee; padding:10px; text-align:center; font-size:12px; color:#999;'>
                GreenEmpire CRM
            </div>
        </div>
        ";
    }
}
