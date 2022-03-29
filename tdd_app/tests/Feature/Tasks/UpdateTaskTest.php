<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use WithFaker;
    /** @test */
    public function authenticated_user_can_update_task()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->put($this->getUpdateTaskRoute($task->id), $dataUpdate);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('tasks', $dataUpdate);
        $response->assertRedirect('tasks');
    }

    /** @test */
    public function autenticated_user_can_view_update_task_form()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $response = $this->get($this->getEditTaskRoute($task->id));
        $response->assertViewIs('tasks.edit');
    }


    /** @test */

    public function autenticated_user_can_see_name_required_text_if_validated_errors()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $dataUpdate = [
            'name' => null,
            'content' => $this->faker->text,
        ];
        $response = $this->from($this->getEditTaskRoute($task->id))->put(route('tasks.update', $task->id), $dataUpdate);
        $response->assertRedirect($this->getEditViewRedirect($task->id));
    }

    /** @test */
    public function authenticated_user_can_not_see_task_form_if_task_not_exits_and_data_is_valid()
    {
        $this->actingAs(User::factory()->create());
        $taskId = -1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'content' => $this->faker->text,
        ];
        $response = $this->put($this->getUpdateTaskRoute($taskId), $dataUpdate);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function authenticated_user_can_not_update_task_if_name_is_null()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $dataUpdate = [
            'name' => null,
            'content' => $this->faker->text,
        ];

        $response = $this->put($this->getUpdateTaskRoute($task->id), $dataUpdate);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function unauthenticated_user_can_not_update_task()
    {
        $task = Task::factory()->create();
        $respone = $this->put($this->getUpdateTaskRoute($task->id));
        $respone->assertRedirect('/login');
    }

    /** @test */
    public function unauthenticated_user_can_not_see_update_task_form_view()
    {
        $task = Task::factory()->create();
        $response = $this->get($this->getEditTaskRoute($task->id));
        $response->assertRedirect('/login');
    }


    public function getEditTaskRoute($id)
    {
        return route('tasks.edit', $id);
    }

    public function getUpdateTaskRoute($id)
    {
        return route('tasks.update', $id);
    }

    public function getEditViewRedirect($id)
    {
        return route('tasks.edit', $id);
    }
}
