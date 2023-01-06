<?php

namespace Database\Seeders;

use App\Models\Scp;
use Illuminate\Database\Seeder;

class ScpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scp::factory()->count(5)->create();
    }
}
