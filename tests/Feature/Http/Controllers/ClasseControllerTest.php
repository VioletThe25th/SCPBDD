<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Classe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ClasseController
 */
class ClasseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $classes = Classe::factory()->count(3)->create();

        $response = $this->get(route('classe.index'));

        $response->assertOk();
        $response->assertViewIs('classe.index');
        $response->assertViewHas('classes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('classe.create'));

        $response->assertOk();
        $response->assertViewIs('classe.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClasseController::class,
            'store',
            \App\Http\Requests\ClasseStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;

        $response = $this->post(route('classe.store'), [
            'name' => $name,
        ]);

        $classes = Classe::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $classes);
        $classe = $classes->first();

        $response->assertRedirect(route('classe.index'));
        $response->assertSessionHas('classe.id', $classe->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $classe = Classe::factory()->create();

        $response = $this->get(route('classe.show', $classe));

        $response->assertOk();
        $response->assertViewIs('classe.show');
        $response->assertViewHas('classe');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $classe = Classe::factory()->create();

        $response = $this->get(route('classe.edit', $classe));

        $response->assertOk();
        $response->assertViewIs('classe.edit');
        $response->assertViewHas('classe');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClasseController::class,
            'update',
            \App\Http\Requests\ClasseUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $classe = Classe::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('classe.update', $classe), [
            'name' => $name,
        ]);

        $classe->refresh();

        $response->assertRedirect(route('classe.index'));
        $response->assertSessionHas('classe.id', $classe->id);

        $this->assertEquals($name, $classe->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $classe = Classe::factory()->create();

        $response = $this->delete(route('classe.destroy', $classe));

        $response->assertRedirect(route('classe.index'));

        $this->assertModelMissing($classe);
    }
}
