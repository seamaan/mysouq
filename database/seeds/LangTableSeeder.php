<?php

use Illuminate\Database\Seeder;

class LangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Lang::create([
            'name'=>'العربية',
            'code'=>'ar',
            'flag'=>'ps.png',
            'direction'=>'rtl',
            'admin_id'=>1,
            'default'=>1,

        ]);
    }
}
