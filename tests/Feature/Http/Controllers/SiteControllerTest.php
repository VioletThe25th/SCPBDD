<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SiteController
 */
class SiteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $sites = Site::factory()->count(3)->create();

        $response = $this->get(route('site.index'));

        $response->assertOk();
        $response->assertViewIs('site.index');
        $response->assertViewHas('sites');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('site.create'));

        $response->assertOk();
        $response->assertViewIs('site.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SiteController::class,
            'store',
            \App\Http\Requests\SiteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;
        $address = $this->faker->word;

        $response = $this->post(route('site.store'), [
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
        ]);

        $sites = Site::query()
            ->where('name', $name)
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->where('address', $address)
            ->get();
        $this->assertCount(1, $sites);
        $site = $sites->first();

        $response->assertRedirect(route('site.index'));
        $response->assertSessionHas('site.id', $site->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('site.show', $site));

        $response->assertOk();
        $response->assertViewIs('site.show');
        $response->assertViewHas('site');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('site.edit', $site));

        $response->assertOk();
        $response->assertViewIs('site.edit');
        $response->assertViewHas('site');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SiteController::class,
            'update',
            \App\Http\Requests\SiteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $site = Site::factory()->create();
        $name = $this->faker->name;
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;
        $address = $this->faker->word;

        $response = $this->put(route('site.update', $site), [
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
        ]);

        $site->refresh();

        $response->assertRedirect(route('site.index'));
        $response->assertSessionHas('site.id', $site->id);

        $this->assertEquals($name, $site->name);
        $this->assertEquals($latitude, $site->latitude);
        $this->assertEquals($longitude, $site->longitude);
        $this->assertEquals($address, $site->address);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $site = Site::factory()->create();

        $response = $this->delete(route('site.destroy', $site));

        $response->assertRedirect(route('site.index'));

        $this->assertModelMissing($site);
    }
}
