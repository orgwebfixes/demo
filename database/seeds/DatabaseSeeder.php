<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //insert default settings if not inserted
        if (DB::table('settings')->get()->count() == 0) {
            DB::table('settings')->insert([
                [
                    'name'       => 'project_title',
                    'title'      => 'ORG WebTech.',
                    'value' => 'ORG WebTech.',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ],
                [
                    'name'       => 'site_copyright',
                    'title'      => 'orgwebtech.com. All rights reserved.',
                    'value' => 'orgwebtech.com. All rights reserved.',
                    'created_at' => NOW(),
                    'updated_at' => NOW(),
                ]
            ]);
        } else {
            echo 'Setting table is not empty' . PHP_EOL;
        }
    }
}
