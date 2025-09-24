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
        $todo = ToDo::where('user_id', Auth::id())->find($listID);

        $tasks = $todo->tasks;

        return response()->json($tasks);
    }

    public function store(Request $request, ToDo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $task = $todo->tasks()->create([
            'title' => $request->title,
            'is_done' => false
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, ToDo $todo, Task $task)
    {
        if ($task->todo_id !== $todo->id || $todo->user_id !== auth()->id()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'is_done' => 'nullable|boolean',
        ]);

        $task->update($request->only(['title', 'is_done']));

        return response()->json($task);
    }


    public function destroy($todo_id, $id)
    {
        $task = Task::where('id', $id)
            ->where('todo_id', $todo_id)
            ->firstOrFail();

        if ($task->todo->user_id !== auth()->id()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa removida']);
    }
}
