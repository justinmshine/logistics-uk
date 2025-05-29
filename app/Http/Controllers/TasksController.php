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

        // Generate a secured URL token for edit/delete
        $task->secure_token = Str::random(32);
        $task->save();

        return response()->json([
            'task' => $task,
            'edit_url' => route('tasks.edit', ['task' => $task->id, 'token' => $task->secure_token]),
            'delete_url' => route('tasks.destroy', ['task' => $task->id, 'token' => $task->secure_token]),
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

        // Check secure token
        if ($request->query('token') !== $task->secure_token) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

        // Check secure token
        if ($request->query('token') !== $task->secure_token) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
