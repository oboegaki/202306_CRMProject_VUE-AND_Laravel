<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //電話番号のハイフンを削除(09011112222)
        $tel = str_replace('-', '', $this->faker->phoneNumber);

        // 住所から郵便番号と半角スペースをカット
        $address = mb_substr($this->faker->address, 9);

        return [
            'name' => $this->faker->name,
            'kana' => $this->faker->kanaName,
            'tel' => $tel,
            'email' => $this->faker->email,
            'postcode' => $this->faker->postcode,
            'address' => $address,
            'birthday' => $this->faker->dateTime,
            'gender' => $this->faker->numberBetween(0, 2),
            'memo' => $this->faker->realText(50),  //日本語文字数(50)
        ];
    }
}
