<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;

class SimpleAISuggester
{
    // 🤖 GỢI Ý NGƯỜI PHÙ HỢP
    public static function suggest($customerId)
    {
        $users = User::where('role', 'staff')
            ->where('is_active', 1)
            ->get();

        if ($users->isEmpty()) {
            return null;
        }

        // 📊 preload workload
        $taskCounts = Task::selectRaw('assignee_id, COUNT(*) as total')
            ->where('status', '!=', Task::STATUS_DONE)
            ->groupBy('assignee_id')
            ->pluck('total', 'assignee_id');

        // 📊 lịch sử theo customer
        $historyCounts = Task::selectRaw('assignee_id, COUNT(*) as total')
            ->where('customer_id', $customerId)
            ->groupBy('assignee_id')
            ->pluck('total', 'assignee_id');

        $bestUser = null;
        $bestScore = -INF;

        foreach ($users as $user) {

            $taskCount = $taskCounts[$user->id] ?? 0;
            $history   = $historyCounts[$user->id] ?? 0;

            // 🎯 scoring: ưu tiên kinh nghiệm + ít việc
            $score = ($history * 3) - ($taskCount * 2);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestUser = $user;
            }
        }

        return $bestUser;
    }

    // 🤖 GỢI Ý DEADLINE THÔNG MINH
    public static function suggestDeadline($userId)
    {
        if (!$userId) {
            return null;
        }

        $taskCount = Task::where('assignee_id', $userId)
            ->where('status', '!=', Task::STATUS_DONE)
            ->count();

        // 🎯 workload → số ngày
        $days = match (true) {
            $taskCount <= 2 => 1,
            $taskCount <= 5 => 3,
            default => 5,
        };

        $date = now()
            ->addDays($days)
            ->setTime(17, 30, 0);

        // 🚫 tránh cuối tuần
        while ($date->isWeekend()) {
            $date->addDay();
        }

        // 🚫 tránh quá khứ (phòng lỗi timezone)
        if ($date->isPast()) {
            $date = now()->addDay()->setTime(17, 30, 0);
        }

        return $date->startOfMinute(); // chuẩn format
    }
}

