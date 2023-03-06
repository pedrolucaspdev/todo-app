<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo</title>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <div class="container-fluid text-center">
        <form action="{{ route('todos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        



    @if ($todos)
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Options</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($todos as $todo)
          <tr>
            <td>{{$todo->title}}</td>
            <td>{{$todo->description}}</td>
            <td>
                <a class="view" title="" data-toggle="tooltip" data-original-title="View"><i class="m-2">View</i></a>
                <a class="edit" title="" data-toggle="tooltip" data-original-title="Edit"><i class="m-2">Edit</i></a>
                
                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>                
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <p>Todo list empty</p>
      @endif
    </div>
    @endsection
</body>
</html>