@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Detail task</h2>
                <div class="card">
                    <div class="form-control">
                        <span style="font-weight: 600;color: black">Name : </span>&emsp;<span>{{ $task->name }}</span>
                    </div>
                    <div class="form-control">
                        <span style="font-weight: 600;color: black">Content : </span>&emsp;<span>{{ $task->content }}</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 20px"><a href="{{ route('tasks.index') }}" style="color: black;text-decoration: none;">Back</a></button>
            </div>
        </div>
    </div>
@endsection

