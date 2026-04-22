<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;

class SimpleAISuggester
{
    public static function suggest($customerId)
    {
        $users = User::where('role', 'staff')
            ->where('is_active', 1)
            ->get();

        $bestUser = null;
        $bestScore = -999;

        foreach ($users as $user) {

            $score = 0;

            // 🔹 workload (ít task hơn → tốt hơn)
            $taskCount = Task::where('assignee_id', $user->id)
                ->where('status', '!=', Task::STATUS_DONE)
                ->count();

            $score -= $taskCount * 2;

            // 🔹 đã làm customer này
            $history = Task::where('assignee_id', $user->id)
                ->where('customer_id', $customerId)
                ->count();

            $score += $history * 3;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestUser = $user;
            }
        }

        return $bestUser;
    }

    // 🤖 GỢI Ý DEADLINE
    public static function suggestDeadline($userId)
    {
        $taskCount = Task::where('assignee_id', $userId)
            ->where('status', '!=', Task::STATUS_DONE)
            ->count();

        if ($taskCount <= 2) {
            $days = 1;
        } elseif ($taskCount <= 5) {
            $days = 3;
        } else {
            $days = 5;
        }

        return Carbon::now()->addDays($days);
    }
}