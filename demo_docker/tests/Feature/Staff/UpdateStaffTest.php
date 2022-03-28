<?php

namespace Tests\Feature\Staff;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateStaffTest extends TestCase
{
    use WithFaker;

    /** @test */

    public function user_can_update_staff_if_staff_exits_and_data_is_valid()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];

        $respone = $this->json('PUT',route('staffs.update',$staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_OK);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('data',fn(AssertableJson $json) =>
                $json->where('name',$dataUpdate['name'])
                    ->where('email',$dataUpdate['email'])
                    ->where('address',$dataUpdate['address'])
                    ->where('phone',$dataUpdate['phone'])
                ->etc()
            )->etc()
        );

        $this->assertDatabaseHas('staffs',[
            'name' => $dataUpdate['name'],
            'email' => $dataUpdate['email'],
            'address' => $dataUpdate['address'],
            'phone' => $dataUpdate['phone']
        ]);
    }

    /** @test */

    public function user_can_not_update_staff_if_staff_exits_and_name_is_null()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => '',
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];

        $respone = $this->json('PUT',route('staffs.update',$staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('errors',fn(AssertableJson $json) =>
                $json->has('name')
                    ->etc()
            )->etc()
        );
    }

    /** @test */

    public function user_can_not_update_staff_if_staff_exits_and_email_is_null()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'email' => '',
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];

        $respone = $this->json('PUT',route('staffs.update', $staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('errors',fn(AssertableJson $json) =>
                $json->has('email')
                    ->etc()
            )->etc()
        );
    }

    /** @test */

    public function user_can_not_update_staff_if_staff_exits_and_address_is_null()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => '',
            'phone' => $this->faker->phoneNumber
        ];

        $respone = $this->json('PUT',route('staffs.update', $staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('errors',fn(AssertableJson $json) =>
                $json->has('address')
                    ->etc()
            )->etc()
        );
    }

    /** @test */

    public function user_can_not_update_staff_if_staff_exits_and_phone_is_null()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => ''
        ];

        $respone = $this->json('PUT',route('staffs.update', $staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('errors',fn(AssertableJson $json) =>
                $json->has('phone')
                    ->etc()
            )->etc()
        );
    }

    /** @test */

    // staff exit and data not valid

    public function user_can_not_update_staff_if_staff_exits_and_data_is_not_valid()
    {
        $staff = Staff::factory()->create();
        $dataUpdate = [
            'name' => '',
            'email' => '',
            'address' => '',
            'phone' => ''
        ];

        $respone = $this->json('PUT',route('staffs.update', $staff->id),$dataUpdate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) =>
            $json->has('errors',fn(AssertableJson $json) =>
            $json->has('phone')
                ->has('email')
                ->has('address')
                ->has('phone')
                ->etc()
            )->etc()
        );
    }

    /** @test */

    // staff not exits and data valid

    public function user_can_not_update_staff_if_staff_not_exits_and_data_is_valid()
    {
        $staffId = -1;
        $dataUpdate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];
        $respone = $this->json('PUT',route('staffs.update', $staffId), $dataUpdate);
        $respone->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
