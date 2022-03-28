@extends('layouts.app')
@push("head")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@section('content')
    <div class="container">
        <h2>Edit task form</h2>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="pwd">Name:</label>
                <input type="text" value="{{ $task->name }}" class="form-control" id="pwd" name="name">
                @error('name')
                <div class="danger">
                    <p style="color: red">{{ $message }}</p>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="cnt">Content:</label>
                <input type="text"  value="{{ $task->content }}" class="form-control" id="cnt" name="content">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

