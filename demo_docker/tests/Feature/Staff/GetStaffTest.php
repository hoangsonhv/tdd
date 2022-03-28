<?php

namespace Tests\Feature\Staff;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetStaffTest extends TestCase
{
    /** @test */
    public function user_can_get_staff_if_staff_exits()
    {
        $staff = Staff::factory()->create();

        $respone = $this->getJson(route('staffs.show', $staff->id));

        $respone->assertStatus(Response::HTTP_OK);

        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('status')
            ->has('message')
            ->has('data', fn(AssertableJson $json) =>
                $json->where('id',$staff->id)->etc()
            )
        );
    }

    /** @test */

    // test co bao loi 404 khong
    public function user_can_not_get_staff_if_staff_not_exits()
    {
        $staffId = -1;

        $respone = $this->getJson(route('staffs.show', $staffId));

        $respone->assertStatus(Response::HTTP_NOT_FOUND);

    }
}
