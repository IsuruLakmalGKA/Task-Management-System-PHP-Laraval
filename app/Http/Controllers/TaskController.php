<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskController extends Controller
{
    //
    public function index()
    {
        // Returning index view
        return view('index');
    }

    // Store a new task
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Validate user selection
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today', // Ensure due date is today or later
            'priority' => 'required|in:High,Medium,Low',
            'is_completed' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
        ]);

        // Add task data
        $taskData = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => Carbon::parse($request->due_date)->format('Y-m-d'),
            'priority' => $request->priority,
            'is_completed' => $request->is_completed ? true: false,
            'is_paid' => $request->is_paid ? true : false,
        ];



        Task::create($taskData);

        return response()->json([
            'status' => 200,
            'message' => 'Task added successfully',
        ]);

    }

    // Fetch all tasks
    // public function fetchAll()
    // {
    //     $tasks = Task::with('user')->get(); // Include user data for each task
    //     $output = '';

    //     if ($tasks->count() > 0) {
    //         $output .= '<table class="table table-striped table-sm text-center align-middle">
    //         <thead>
    //           <tr>
    //             <th>ID</th>
    //             <th>Title</th>
    //             <th>Description</th>
    //             <th>Due Date</th>
    //             <th>Priority</th>
    //             <th>User</th>
    //             <th>Completed</th>
    //             <th>Paid</th>
    //             <th>Action</th>
    //           </tr>
    //         </thead>
    //         <tbody>';

    //         foreach ($tasks as $task) {
    //             $output .= '<tr>
    //             <td>' . $task->id . '</td>
    //             <td>' . $task->title . '</td>
    //             <td>' . $task->description . '</td>
    //             <td>' . $task->due_date . '</td>
    //             <td>' . $task->priority . '</td>
    //             <td>' . $task->user->name . '</td>
    //             <td>' . ($task->is_completed ? 'Yes' : 'No') . '</td>
    //             <td>' . ($task->is_paid ? 'Yes' : 'No') . '</td>
    //             <td>
    //               <a href="#" id="' . $task->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editTaskModal"><i class="bi-pencil-square h4"></i></a>
    //               <a href="#" id="' . $task->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
    //             </td>
    //           </tr>';
    //         }
    //         $output .= '</tbody></table>';
    //         echo $output;
    //     } else {
    //         echo '<h1 class="text-center text-secondary my-5">No tasks available!</h1>';
    //     }
    // }

    public function fetchAll()
    {
        // Eager load the user relationship
        $tasks = Task::with('user')->get();
        $output = '';

        if ($tasks->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Priority</th>
            <th>User</th>
            <th>Completed</th>
            <th>Paid</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>';

            foreach ($tasks as $task) {
                $output .= '<tr>
            <td>' . $task->id . '</td>
            <td>' . $task->title . '</td>
            <td>' . $task->description . '</td>
            <td>' . $task->due_date . '</td>
            <td>' . $task->priority . '</td>
            <td>' . optional($task->user)->name . '</td> <!-- Access user name safely --> 
            <td>' . ($task->is_completed ? 'Yes' : 'No') . '</td>
            <td>' . ($task->is_paid ? 'Yes' : 'No') . '</td>
            <td>
              <a href="#" id="' . $task->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editTaskModal"><i class="bi-pencil-square h4"></i></a>
              <a href="#" id="' . $task->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
            </td>
          </tr>';
            }
            $output .= '</tbody></table>';
            return response()->json(['status' => 200, 'html' => $output]); // Return the output as JSON
        } else {
            return response()->json(['status' => 404, 'message' => 'No tasks available!']);
        }
    }


    // Fetch a specific task for editing
    public function edit(Request $request)
    {
        $task = Task::findOrFail($request->id);
        //return response()->json($task);
        return response()->json([
            'status' => 200,
            'id' => $task->id,
            'user_id' => $task->user->id,  //Send user name to frontend
            'title' => $task->title,
            'description' => $task->description,
            'due_date' => $task->due_date,
            'priority' => $task->priority,
            'is_completed' => $task->is_completed,
            'is_paid' => $task->is_paid,
        ]);
    }

    // public function edit($id)
    // {
    //     $task = Task::with('user')->findOrFail($id); // Assuming 'user' is the relationship name
    //     return response()->json([
    //         'status' => 200,
    //         'id' => $task->id,
    //         'user_name' => $task->user->name, // Send user name to frontend
    //         'title' => $task->title,
    //         'description' => $task->description,
    //         'due_date' => $task->due_date,
    //         'priority' => $task->priority,
    //         'is_completed' => $task->is_completed,
    //         'is_paid' => $task->is_paid,
    //     ]);
    // }


    // Update a task
    public function update(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:High,Medium,Low',
            'is_completed' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
        ]);

        $task = Task::findOrFail($request->task_id);
        $taskData = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => Carbon::parse($request->due_date)->format('Y-m-d'),
            'priority' => $request->priority,
            'is_completed' => $request->is_completed ? true : false,
            'is_paid' => $request->is_paid ? true : false,
            
        ];

        $task->update($taskData);

        return response()->json([
            'status' => 200,
            'message' => 'Task updated successfully',
        ]);
    }

    // Delete a task
    public function delete(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Task deleted successfully',
        ]);
    }

    // Fetch all users for dropdown
    public function fetchUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}
