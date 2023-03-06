<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todos = $user->todos;

        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id'
        ]);

        $user = Auth::user();
        $user->todos()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully.');
    }

    public function edit(Todo $todo)
    {
        // Verificar se o Todo pertence ao usuário autenticado
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        // Retornar a view de edição de Todo com o Todo a ser editado
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Verificar se o Todo pertence ao usuário autenticado
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        // Validar os dados do formulário
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id'
        ]);

        // Atualizar os dados do Todo
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();

        // Redirecionar de volta para a página anterior com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Todo atualizado com sucesso!');
    }

    public function destroy(Todo $todo)
    {
        // Verificar se o Todo pertence ao usuário autenticado
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        // Excluir o Todo
        $todo->delete();

        // Redirecionar de volta para a página anterior com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Todo excluído com sucesso!');
    }
}
