<?php

namespace Tests\Feature\Tasks;

use App\Models\Staff;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    use WithFaker;
    /** @test */
    public function authenticated_user_can_delete_task_if_task_exits()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $taskCountBeforeDelete = Task::count();
        $response = $this->delete($this->getTaskDeleteRoute($task->id));
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseCount('tasks',$taskCountBeforeDelete -1);

    }

    /** @test */
    public function authenticated_user_can_not_delete_task_if_task_not_exits()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $response = $this->delete($this->getTaskDeleteRoute($taskId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function unauthenticated_user_can_not_delete_task_if_task_not_exits()
    {
        $taskId = -1;
        $response = $this->delete($this->getTaskDeleteRoute($taskId));
        $response->assertStatus(Response::HTTP_FOUND);
    }


    public function getTaskDeleteRoute($id)
    {
        return route('tasks.destroy', $id);
    }
}
