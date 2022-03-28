<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    public function getCreateRouteTask()
    {
        return route('tasks.store');
    }

    /** @test */
    public function authenticated_user_can_new_task()
    {
        $response = $this->post($this->getCreateRouteTask());

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
