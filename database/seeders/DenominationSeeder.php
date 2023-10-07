<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Denomination::create([
            'type' => 'Bill',
            'value' => 1000,
            'image' => 'denominations/1000.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 500,
            'image' => 'denominations/500.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 200,
            'image' => 'denominations/200.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 100,
            'image' => 'denominations/100.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 50,
            'image' => 'denominations/50.jpg'
        ]);
        Denomination::create([
            'type' => 'Bill',
            'value' => 20,
            'image' => 'denominations/20.jpg'
        ]);
        Denomination::create([
            'type' => 'Coin',
            'value' => 10,
            'image' => 'denominations/10.jpg'
        ]);
        Denomination::create([
            'type' => 'Coin',
            'value' => 5,
            'image' => 'denominations/5.jpg'
        ]);
        Denomination::create([
            'type' => 'Coin',
            'value' => 2,
            'image' => 'denominations/2.jpg'
        ]);
        Denomination::create([
            'type' => 'Coin',
            'value' => 1,
            'image' => 'denominations/1.jpg'
        ]);
        Denomination::create([
            'type' => 'Coin',
            'value' => 0.5,
            'image' => 'denominations/0.5.jpg'
        ]);
        Denomination::create([
            'type' => 'Other',
            'value' => 0,
            'image' => 'denominations/0.jpg'
        ]);
        Denomination::create([
            'type' => 'Other',
            'value' => 500000,
            'image' => 'denominations/bitcoin.jpg'
        ]);
    }
}
