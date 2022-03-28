<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $tasks = $this->task->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = $this->task->findOrFail($id);
        return view('tasks.show',[
            'task' => $task
        ]);
    }

    public function store(CreateTaskRequest $request)
    {
        $this->task->create($request->all());
        return redirect()->route('tasks.index');
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function edit($id)
    {
        $task = $this->task->findOrFail($id);
        return view('tasks.edit',[
            'task' => $task,
        ]);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->task->findOrFail($id);
        $task->update($request->all());
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $tasks = $this->task->findOrFail($id);
        $tasks->delete();
        return redirect('tasks');
    }
}
