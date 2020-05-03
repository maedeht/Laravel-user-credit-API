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

        factory(\App\Models\Config::class, 1)->create([
            'name' => 'article-cost',
            'value' => '5000'
        ]);

        factory(\App\Models\Config::class, 1)->create([
            'name' => 'comment-cost',
            'value' => '5000'
        ]);

        factory(\App\Models\Config::class, 1)->create([
            'name' => 'user-credit-recharge',
            'value' => '20000'
        ]);
    }
}
