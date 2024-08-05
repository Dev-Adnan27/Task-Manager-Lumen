<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::where('is_deleted', 0)->get());
    }
    public function trashed()
    {
        $tasks = Task::where('is_deleted', 1)->get();
        return response()->json($tasks);
    }
    public function completed()
    {
        $tasks = Task::where('completed', 1)->where('is_deleted', 0)->get();
        return response()->json($tasks);
    }
    public function uncomplete()
    {
        $tasks = Task::where('completed', 0)->where('is_deleted', 0)->get();
        return response()->json($tasks);
    }

    public function show($id)
    {
        // Fetch a single non-deleted task
        $task = Task::where('id', $id)->where('is_deleted', 0)->first();
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new task
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Use Validator facade instead of $request->validate()
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update($request->all());
        return response()->json($task);
    }


    public function destroy($id)
    {
        // Find the task
        $task = Task::where('id', $id)->where('is_deleted', 0)->first();
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Mark the task as deleted
        $task->is_deleted = 1;
        $task->save();

        return response()->json(['message' => 'Task marked as deleted']);
    }
}
