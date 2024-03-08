<?php

namespace Database\Factories;

use App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 大量のダミーデータ投入
        $decade = $this->faker->dateTimeThisDecade;
        //過去10年分のデータを8年分に変更(タイムアウト防止用などのため)
        $created_at = $decade->modify('+2 years');

        return [
            // 中間テーブル用に、1から customersテーブル のrandom値を customer_id とする
            'customer_id' => rand(1, Customer::count()),
            'status' => $this->faker->boolean,
            'created_at' => $created_at,
        ];
    }
}
