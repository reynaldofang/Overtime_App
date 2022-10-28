<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'overtime_method',
                'value' => '1',
            ]
        ];
        \DB::table('settings')->insert($settings);
    }
}
