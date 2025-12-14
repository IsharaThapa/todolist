<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function index()
    {
        $response = Http::get(
            'https://g7mogen1hg.execute-api.us-east-2.amazonaws.com/dev/notes'
        );

        $data = $response->json();

        $tasks = collect(json_decode($data['body'], true));

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $payload = [
            'description' => $request->description,
            'status' => 'open'
        ];

        Http::post(
            'https://g7mogen1hg.execute-api.us-east-2.amazonaws.com/dev/notes',
            $payload
        );

        return redirect()->back();
    }


   public function update(Request $request, $taskId)
    {
        $status = ($request->status=='done') ? 'open' : 'done';
        $payload = [
            'taskId' => $taskId,
            'description' => $request->input('description'),
            'status' => $status
        ];

        $response = Http::put(
            'https://g7mogen1hg.execute-api.us-east-2.amazonaws.com/dev/notes',
            $payload
        );
        
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Task updated successfully!');
        }

    }


  
    public function destroy($taskId)
    {
        $payload = [
            'taskId' => $taskId
        ];

        $response = Http::delete(
            'https://g7mogen1hg.execute-api.us-east-2.amazonaws.com/dev/notes',
            $payload
        );
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Task deleted successfully!');
        }

        return redirect()->back()->with('error', 'Failed to delete task.');
    }

}
