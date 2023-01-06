<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employee.index'));

        $response->assertOk();
        $response->assertViewIs('employee.index');
        $response->assertViewHas('employees');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('employee.create'));

        $response->assertOk();
        $response->assertViewIs('employee.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $mail = $this->faker->word;
        $tel = $this->faker->word;

        $response = $this->post(route('employee.store'), [
            'name' => $name,
            'mail' => $mail,
            'tel' => $tel,
        ]);

        $employees = Employee::query()
            ->where('name', $name)
            ->where('mail', $mail)
            ->where('tel', $tel)
            ->get();
        $this->assertCount(1, $employees);
        $employee = $employees->first();

        $response->assertRedirect(route('employee.index'));
        $response->assertSessionHas('employee.id', $employee->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employee.show', $employee));

        $response->assertOk();
        $response->assertViewIs('employee.show');
        $response->assertViewHas('employee');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employee.edit', $employee));

        $response->assertOk();
        $response->assertViewIs('employee.edit');
        $response->assertViewHas('employee');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $employee = Employee::factory()->create();
        $name = $this->faker->name;
        $mail = $this->faker->word;
        $tel = $this->faker->word;

        $response = $this->put(route('employee.update', $employee), [
            'name' => $name,
            'mail' => $mail,
            'tel' => $tel,
        ]);

        $employee->refresh();

        $response->assertRedirect(route('employee.index'));
        $response->assertSessionHas('employee.id', $employee->id);

        $this->assertEquals($name, $employee->name);
        $this->assertEquals($mail, $employee->mail);
        $this->assertEquals($tel, $employee->tel);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employee.destroy', $employee));

        $response->assertRedirect(route('employee.index'));

        $this->assertModelMissing($employee);
    }
}
