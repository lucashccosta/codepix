<?php

namespace Database\Factories;

use App\Enums\WalletTypeEnum;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bankAccountNumber,
            'type' => (
                rand(0,1)  
                ? WalletTypeEnum::BUSINESS
                : WalletTypeEnum::PERSONAL
            )
        ];
    }
}
