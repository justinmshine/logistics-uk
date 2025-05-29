<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TasksModel;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    // Display a listing of all tasks
    public function index()
    {
        return response()->json(TasksModel::all());
    }

    // Store a newly created task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:5000',
        ]);

        $task = TasksModel::create($validated);


        return response()->json([
            'task' => $task,
            'edit_url' => route('tasks.edit', ['task' => $task->id]),
            'delete_url' => route('tasks.destroy', ['task' => $task->id]),
        ], 201);
    }

    // Show a single task
    public function show($id)
    {
        $task = TasksModel::findOrFail($id);
        return response()->json($task);
    }

    // Update the specified task (secured)
    public function update(Request $request, $id)
    {
        $task = TasksModel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|min:3|max:100',
            'description' => 'sometimes|required|string|min:10|max:5000',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    // Remove the specified task (secured)
    public function destroy(Request $request, $id)
    {
        $task = TasksModel::findOrFail($id);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
