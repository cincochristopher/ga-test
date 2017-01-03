<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('programs')->insert([
            [
                'name' => 'Semester in Florence',
                'alias' => 'semester-in-florence',
                'description' => 'Spend a summer studying abroad in the Florence.'
            ],
            [
                'name' => 'Adventure in Africa',
                'alias' => 'adventure-in-africa',
                'description' => 'Africa is an amazing place to call home during your summer abroad!'
            ]
        ]);
    }
}
