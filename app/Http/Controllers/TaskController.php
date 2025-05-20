<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('subtasks')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json($task);
    }
}
