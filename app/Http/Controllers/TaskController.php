<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
  
    public function index($listID)
    {
         $list = ToDo::where('user_id', Auth::id())->todoLists()->with('tasks')->findOrFail($listID);

         return response()->json($list->tasks);

    }

   
    public function create()
    {
        //
    }


    public function store(Request $request, $listID)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $list = ToDo::where('user_id', Auth::id())->todoLists()->findOrFail($listID);

        $task = $list->tasks()->create([
            'title' => $request->title,
            'is_done' => false
        ]);

        return response()->json($task, 201);
    }

    
    public function show(Task $task)
    {
        
    }

    
    public function edit(Task $task)
    {
        //
    }

    
    public function update(Request $request, Task $task, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->todoList->user_id !== auth()->id()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $task->update([
            'is_done' => !$task->is_done
        ]);

        return response()->json($task);
    }

    
    public function destroy(Task $task, $id)
    {
         $task = Task::findOrFail($id);

        if ($task->todoList->user_id !== auth()->id()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa removida']);
    }
}
