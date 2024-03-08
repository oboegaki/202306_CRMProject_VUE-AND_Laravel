<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\Purchase;
use Database\Seeders\RankSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //新しく作ったシーダークラスを登録
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            RankSeeder::class
        ]);

        //factory(自動生成)はこちらに記述: Customer
        Customer::factory(1000)->create(); //1000件


        // \App\Models\Purchase::factory(100)->create(); //中間テーブル用につくりかえる↓　↓
        $items = \App\Models\Item::all();
        Purchase::factory(30000)->create() //大量データ投入
            ->each(function (Purchase $purchase) use ($items) { //useで$itemsを渡す
                $purchase->items()->attach(
                    $items->random(rand(1, 3))->pluck('id')->toArray(),
                    // 1～3個のitemをpurchaseにランダムに紐づけ
                    ['quantity' => rand(1, 5)]
                );
            });

        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
