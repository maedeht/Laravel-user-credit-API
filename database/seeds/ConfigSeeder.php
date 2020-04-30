<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Config::class, 1)->create([
            'name' => 'registration-credit',
            'value' => '100000'
        ]);
    }
}
