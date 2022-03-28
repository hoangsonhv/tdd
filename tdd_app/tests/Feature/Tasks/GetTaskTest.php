<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetTaskTest extends TestCase
{
    /** @test */
    public function authenticated_user_can_get_task_if_task_exits()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $response = $this->get($this->getTaskRoute($task->id));
//        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('tasks.show');
    }

    public function getTaskRoute($id)
    {
        return route('tasks.show', $id);
    }
}
