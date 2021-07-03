<?php

namespace Database\Factories;

use App\Enums\KeyTypeEnum;
use App\Helpers\FakerBR;
use App\Models\Key;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Key::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $definitions = [
            0 => [
                'type' => KeyTypeEnum::DOC,
                'key' => (
                    rand(0,1) 
                    ? $this->faker->unique()->numerify('###########')
                    : $this->faker->unique()->numerify('##############')
                )
            ],
            1 => [
                'type' => KeyTypeEnum::EMAIL,
                'key' => $this->faker->unique()->safeEmail
            ],
            2 => [
                'type' => KeyTypeEnum::PHONE,
                'key' => $this->faker->unique()->e164PhoneNumber
            ]
        ];

        return $definitions[rand(0,2)];
    }
}
