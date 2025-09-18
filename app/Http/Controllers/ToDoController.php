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
        $lists = ToDo::where('user_id', Auth::id())->get();
        return response()->json($lists);
    }


    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $list = ToDo::create([
            'title' => $request->title,
            'user_id' => Auth::id()
        ]);

        return response()->json($list, 201);
    }

    
    public function show(ToDo $toDo)
    {
        $list = ToDo::with('tasks')->findOrFail($toDo->id);

        return response()->json($list);
    }

    
    public function edit(ToDo $toDo)
    {
        
    }

   
    public function update(Request $request, ToDo $toDo)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $list = ToDo::where('user_id', Auth::id())->findOrFail($toDo->id);
        $list->update(['title' => $request->title]);

        return response()->json($list);
    }

    public function destroy(ToDo $toDo)
    {
        $list = ToDo::where('user_id', Auth::id())->findOrFail($toDo->id);
        $list->delete();

        return response()->json(['message' => 'Lista excluída com sucesso']);
    }
}
