<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $upcoming = Task::where('user_id', $userId)
            ->whereNotNull('due_at')
            ->where('status', '!=', 'done')
            ->orderBy('due_at')
            ->limit(6)
            ->get();

        $overdue = Task::where('user_id', $userId)
            ->whereNotNull('due_at')
            ->where('status', '!=', 'done')
            ->where('due_at', '<', now())
            ->orderBy('due_at')
            ->limit(6)
            ->get();

        $stats = [
            'todo' => Task::where('user_id', $userId)->where('status', 'todo')->count(),
            'doing' => Task::where('user_id', $userId)->where('status', 'doing')->count(),
            'done' => Task::where('user_id', $userId)->where('status', 'done')->count(),
        ];

        return view('dashboard', compact('upcoming', 'overdue', 'stats'));
    }
}
