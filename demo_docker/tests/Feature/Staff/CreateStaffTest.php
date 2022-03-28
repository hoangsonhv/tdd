<?php

namespace Tests\Feature\Staff;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateStaffTest extends TestCase
{

    use WithFaker;

    /** @test */

    public function user_can_create_staff_if_data_is_valid()
    {
        $dataCreate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];

        $respone = $this->json('POST', route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_OK);

        $respone->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->where('name', $dataCreate['name'])->etc()
        )->etc()
        );

        $this->assertDatabaseHas('staffs', [
            'name' => $dataCreate['name'],
            'email' => $dataCreate['email'],
            'address' => $dataCreate['address'],
            'phone' => $dataCreate['phone']
        ]);
    }

    /** @test */

    public function user_can_not_create_staff_if_name_is_null()
    {
        $dataCreate = [
            'name' => '',
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];

        $respone = $this->postJson(route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) => $json->has('errors',
            fn(AssertableJson $json) => $json->has('name')
                ->etc()
        )->etc()
        );
    }

    /** @test */

    public function user_can_not_create_staff_if_email_is_null()
    {
        $dataCreate = [
            'name' => $this->faker->name,
            'email' => '',
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];

        $respone = $this->postJson(route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) => $json->has('errors',
            fn(AssertableJson $json) => $json->has('email')
                ->etc()
        )->etc()
        );
    }

    /** @test */

    public function user_can_not_create_staff_if_address_is_null()
    {
        $dataCreate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => '',
            'phone' => $this->faker->phoneNumber,
        ];

        $respone = $this->postJson(route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) => $json->has('errors',
            fn(AssertableJson $json) => $json->has('address')
                ->etc()
        )->etc()
        );
    }

    /** @test */

    public function user_can_not_create_staff_if_phone_is_null()
    {
        $dataCreate = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => ''
        ];

        $respone = $this->postJson(route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) => $json->has('errors',
            fn(AssertableJson $json) => $json->has('phone')
                ->etc()
        )->etc()
        );
    }

    /** @test */

    public function user_can_not_create_staff_if_data_is_not_valid()
    {
        $dataCreate = [
            'name' => '',
            'email' => '',
            'address' => '',
            'phone' => ''
        ];

        $respone = $this->postJson(route('staffs.store'), $dataCreate);
        $respone->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $respone->assertJson(fn(AssertableJson $json) => $json->has('errors',
            fn(AssertableJson $json) => $json->has('phone')
                ->has('email')
                ->has('address')
                ->has('phone')
                ->etc()
        )->etc()
        );
    }
}
