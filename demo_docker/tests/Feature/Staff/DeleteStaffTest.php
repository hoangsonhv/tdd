<?php

namespace Tests\Feature\Staff;

use App\Models\Staff;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteStaffTest extends TestCase
{
    /** @test */

    public function user_can_delete_staff_if_staff_exits()
    {
        $staff = Staff::factory()->create();
        $staffCountBeforeDelete = Staff::count();
        $respone = $this->json('DELETE', route('staffs.destroy', $staff->id));
        $respone->assertStatus(\Illuminate\Http\Response::HTTP_OK);

        $respone->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->where('name', $staff->name)->etc()
        )->etc()
        );

        $staffCountAfterDelete = Staff::count();

        $this->assertEquals($staffCountBeforeDelete - 1, $staffCountAfterDelete);
    }

    /** @test */

    public function user_can_not_delete_staff_if_staff_not_exits()
    {
        $staffId = -1;
        $respone = $this->json('DELETE', route('staffs.destroy', $staffId));
        $respone->assertStatus(\Illuminate\Http\Response::HTTP_NOT_FOUND);
    }
}
