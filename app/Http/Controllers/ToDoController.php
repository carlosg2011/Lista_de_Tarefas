<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{

public function index()
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Não autenticado.'], 401);
    }

    $todos = ToDo::where('user_id', Auth::id())->get();

    return response()->json($todos);
}

    public function create() {}


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('Você precisa estar logado.');
        }

        $request->validate(['title' => 'required|string|max:255']);

        $todo = ToDo::create([
            'title' => $request->title,
            'user_id' => Auth::id()
        ]);

        return response()->json($todo, 201);
    }


    public function show(ToDo $toDo)
    {
        $todos = ToDo::with('tasks')->findOrFail($toDo->id);

        return response()->json($todos);
    }


    public function update(Request $request, $id)
{
    $request->validate(['title' => 'required|string|max:255']);

    $todo = ToDo::where('user_id', Auth::id())->findOrFail($id);
    $todo->update(['title' => $request->title]);

    return response()->json($todo);
}

    public function destroy($id)
    {
        $todo = ToDo::where('user_id', Auth::id())->findOrFail($id);
        $todo->delete();

        return response()->json(['message' => 'Lista excluída com sucesso']);
    }
}
