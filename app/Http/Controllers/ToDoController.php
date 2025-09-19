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
        $todos = ToDo::where('user_id', Auth::id())->get();
        return view('tasklist.index', compact('todos'));
    }


    public function create()
    {
        
    }

    
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

    return redirect()->route('tasklist.index')->with('success', 'Lista criada com sucesso!');
    }

    
    public function show(ToDo $toDo)
    {
        $todos = ToDo::with('tasks')->findOrFail($toDo->id);

        return response()->json($todos);
    }

    
    public function edit(ToDo $toDo)
    {
        
    }

   
    public function update(Request $request, ToDo $toDo)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $todos = ToDo::where('user_id', Auth::id())->findOrFail($toDo->id);
        $todos->update(['title' => $request->title]);

        return response()->json($todos);
    }

    public function destroy(ToDo $toDo)
    {
        $todos = ToDo::where('user_id', Auth::id())->findOrFail($toDo->id);
        $todos->delete();

        return response()->json(['message' => 'Lista excluída com sucesso']);
    }
}
