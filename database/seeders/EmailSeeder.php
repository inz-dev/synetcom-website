<?php

namespace Database\Seeders;

use App\Models\Emails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Emails::create(['email'=>'chaibou.abdou@synetcom.dev']);
        Emails::create(['email'=>'laouali@gmail.com']);
        Emails::create(['email'=>'ismaeilnouri@yahoo.com']);
        Emails::create(['email'=>'izeinabou18@yahoo.com']);
        Emails::create(['email'=>'aboulaziz@gmail.com']);
        Emails::create(['email'=>'zakari@yahoo.com']);
    }
}
