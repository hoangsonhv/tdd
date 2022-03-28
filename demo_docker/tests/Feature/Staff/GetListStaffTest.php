<?php

namespace Tests\Feature\Staff;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\AssertableJsonString;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetListStaffTest extends TestCase
{
    /** @test */

    public function user_can_get_list_staffs()
    {
        $count = Staff::count();
        $respone = $this->getJson(route('staffs.index'));
        $respone->assertStatus(Response::HTTP_CREATED);

        $respone->assertJson(fn (AssertableJson $json) =>
            $json->has('status')
            ->has('message')
            ->has('data', fn(AssertableJson $json) =>
                $json->has('data')
                ->has('meta',fn(AssertableJson $json) =>
                    $json->where('total',$count)->etc()
                )->etc()
            )
        );
    }
}
