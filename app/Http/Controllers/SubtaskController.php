<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubtaskController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $task = Task::find($taskId);
        $subtask = $task->subtasks()->create($request->all());
        return response()->json($subtask);
    }

    public function update(Subtask $subtask)
    {
        if ($subtask->status == Status::Done) {
            $subtask->update(['status' => Status::Active]);
        } else {
            $subtask->update(['status' => Status::Done]);
        }
        return response()->json($subtask);
    }
}
