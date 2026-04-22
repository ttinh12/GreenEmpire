<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TaskOverdueNotification extends Notification
{
    use Queueable;

    public function __construct(public $task, public $type = 'overdue') {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title'   => $this->task->title,
            'type'    => $this->type,
            'message' => match ($this->type) {
                'due_soon' => 'Task sắp tới hạn!',
                'overdue'  => 'Task đã quá hạn!',
                'escalate' => 'Task bị trễ nghiêm trọng!',
            },
        ];
    }
}