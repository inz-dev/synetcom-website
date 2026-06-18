<?php

namespace Database\Seeders;

use App\Models\Telephones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TelephoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Telephones::create(['telephone'=>'88888811']);
        Telephones::create(['telephone'=>'88623669']);//LAWALI
        Telephones::create(['telephone'=>'98241842']);//ISMAEIL
        Telephones::create(['telephone'=>'87897887']);//ABOU
        Telephones::create(['telephone'=>'74276607 ']);// ABDUL
        Telephones::create(['telephone'=>'96952213']); //ZAKARI

    }
}
