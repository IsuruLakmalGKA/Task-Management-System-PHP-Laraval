<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Mail\TaskCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class MailController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|string',
            'is_completed' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
        ]);

        // Create a new task
        $task = Task::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'is_completed' => $validated['is_completed'] ?? false,
            'is_paid' => $validated['is_paid'] ?? false,
        ]);

        // Send email notification
        try {
            Mail::to($task->user->email)->send(new TaskCreated($task));
        } catch (\Exception $e) {
            // Log the error if email sending fails
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        // Respond to the AJAX request
        return response()->json([
            'status' => 200,
            'message' => 'Task created successfully!',
            'task' => $task
        ]);
    }

}
