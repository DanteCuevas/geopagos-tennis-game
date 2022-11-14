<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Player::truncate();
        Schema::enableForeignKeyConstraints();

        $number = pow(2, 6);
        Player::factory($number)->male()->create();
        Player::factory($number)->female()->create();
    }
}
