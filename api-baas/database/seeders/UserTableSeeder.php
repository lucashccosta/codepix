<?php

namespace Database\Seeders;

use App\Models\Key;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(2)
            ->has(Wallet::factory()->count(1)
                ->has(Key::factory()
                    ->count(2)
                )
            )
            ->create();
    }
}
