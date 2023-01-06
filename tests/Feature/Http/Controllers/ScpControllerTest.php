<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Scp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ScpController
 */
class ScpControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $scps = Scp::factory()->count(3)->create();

        $response = $this->get(route('scp.index'));

        $response->assertOk();
        $response->assertViewIs('scp.index');
        $response->assertViewHas('scps');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('scp.create'));

        $response->assertOk();
        $response->assertViewIs('scp.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ScpController::class,
            'store',
            \App\Http\Requests\ScpStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $description = $this->faker->text;

        $response = $this->post(route('scp.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $scps = Scp::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $scps);
        $scp = $scps->first();

        $response->assertRedirect(route('scp.index'));
        $response->assertSessionHas('scp.id', $scp->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $scp = Scp::factory()->create();

        $response = $this->get(route('scp.show', $scp));

        $response->assertOk();
        $response->assertViewIs('scp.show');
        $response->assertViewHas('scp');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $scp = Scp::factory()->create();

        $response = $this->get(route('scp.edit', $scp));

        $response->assertOk();
        $response->assertViewIs('scp.edit');
        $response->assertViewHas('scp');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ScpController::class,
            'update',
            \App\Http\Requests\ScpUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $scp = Scp::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;

        $response = $this->put(route('scp.update', $scp), [
            'name' => $name,
            'description' => $description,
        ]);

        $scp->refresh();

        $response->assertRedirect(route('scp.index'));
        $response->assertSessionHas('scp.id', $scp->id);

        $this->assertEquals($name, $scp->name);
        $this->assertEquals($description, $scp->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $scp = Scp::factory()->create();

        $response = $this->delete(route('scp.destroy', $scp));

        $response->assertRedirect(route('scp.index'));

        $this->assertModelMissing($scp);
    }
}
