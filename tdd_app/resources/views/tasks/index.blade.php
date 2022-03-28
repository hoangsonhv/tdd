@extends('layouts.app')
@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@section('content')
    <div class="container">
        <h2 style="text-align: center">List Task</h2>
        <button class="btn btn-primary" style="margin-bottom: 20px"><a href="{{ route('tasks.create') }}" style="color: whitesmoke;text-decoration: none">Add Task</a></button>
            <table class="table table-bordered table-task">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <th>{{ $task->id }}</th>
                    <th>{{ $task->name }}</th>
                    <th>{{ $task->content }}</th>
                    <th>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary" style="margin-bottom: 10px;width: 100%">Edit</a>
                            <a href="{{ route('tasks.show', $task->id) }}" style="width: 100%;margin-bottom: 10px" class="btn btn-success">Detail</a>
                            <button style="width: 100%" type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </th>
                    <th></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="container justify-content-center" style="margin: 0 auto">
        {{ $tasks->links() }}
    </div>
@endsection
