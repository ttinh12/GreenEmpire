<?php
namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function generateFromContract($contract)
    {
        // ❗ tránh tạo trùng task
        if ($contract->tasks()->exists()) {
            return;
        }

        $templates = DB::table('task_templates')
            ->where('contract_type', strtolower($contract->title))
            ->orderBy('sort')
            ->get();

        foreach ($templates as $index => $template) {

            // ✅ xử lý date an toàn
            $dueDate = null;

            if (!empty($contract->start_date) && $contract->start_date !== '—') {
                $dueDate = $contract->start_date;
            }

            Task::create([
                'contract_id' => $contract->id,
                'title'       => $template->title,
                'status'      => Task::STATUS_TODO,
                'sort'        => $index + 1,
                'priority'    => $template->priority,

                // ✅ thêm dòng này (quan trọng)
                'due_date'    => $dueDate,
            ]);
        }
    }
}