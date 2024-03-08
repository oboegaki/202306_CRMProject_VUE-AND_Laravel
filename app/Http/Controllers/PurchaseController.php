<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
// use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // グローバルスコープにより、小計を取得するサブクエリが　Order　だけで自動的に走る
        // 大量データを get() 　all() で取得しようとするとメモリ不足で表示できなくなるので注意
        // dd(Order::paginate(50));

        // 合計金額を計算
        $orders = Order::groupBy('id')
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
            ->paginate(50);

        return Inertia::render('Purchases/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // ApIで取得する仕様に変更した為、 $customers はカット
        // $customers = Customer::select('id', 'name', 'kana')->get();
        $items = Item::select('id', 'name', 'price')->where(
            'is_selling',
            true
        )->get();
        return Inertia::render('Purchases/Create', [
            // 'customers' => $customers,
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePurchaseRequest $request)
    {
        // まずはddで内容確認
        // dd($request);

        DB::beginTransaction();
        try {
            //保存の流れ
            //1. purchasesテーブルに customer_id status を保存
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);
            //2. リレーション先の Items とあわせて、 中間テーブル(item_puchase)に attache する
            //   attacheの引数は purchasesのid ⇒ attach($purchase->id　として
            //   中間テーブル(item_puchase)の item_id, quantity カラムに保存
            foreach ($request->items as $item) {
                $purchase->items()->attach($purchase->id, [
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            }
            DB::commit();
            return to_route('dashboard');
        } catch (\Exception $e) {
            DB::rollback();
            return to_route('dashboard');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Inertia\Response
     */
    public function show(Purchase $purchase)
    {

        // 小計
        $items = Order::where('id', $purchase->id)->get();

        // 合計
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')->get();

        //dd($subtotals, $order);

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Inertia\Response
     */
    public function edit(Purchase $purchase)
    {
        /**
         * 中間テーブルの数量を確認し数が入っていれば反映させたい
         * Vue.js側で「v-if」と「v-for」の組み合わせは 非推奨 なのでPHP側で配列をつくっておく
         */

        $purchase = Purchase::find($purchase->id);               // 購買Idで指定
        $allItems = Item::select('id', 'name', 'price')->get(); // 全商品を取得
        $items = [];                                            // 空の配列を用意

        // 販売中の商品と中間テーブルを比較し、中間テーブルに数量があれば数量を取得、なければ0で設定
        foreach ($allItems as $allItem) {
            $quantity = 0; // 数量初期値 0
            foreach ($purchase->items as $item) { // 中間テーブルを1件ずつチェック
                if ($allItem->id === $item->id) { // 同じidがあれば
                    $quantity = $item->pivot->quantity; // 中間テーブルの数量を設定
                }
            }
            array_push($items, [
                'id' => $allItem->id,
                'name' => $allItem->name,
                'price' => $allItem->price,
                'quantity' => $quantity
            ]);
        }
        // dd($items);

        //Vue側に顧客ID, 顧客名も渡す
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')
            ->get();

        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        /**
         * 中間テーブルの情報を更新するにはsync()が便利
         * 引数に配列が必要なので事前に作成しておく
         *
         * テーブルは二つなのでトランザクション推奨
         */
        DB::beginTransaction();
        try {

            // 保存
            $purchase->status = $request->status;
            $purchase->save();

            //配列作成
            $items = [];
            foreach ($request->items as $item) {
                $items = $items + [
                    // item_id => [ 中間テーブルの列名 => 値 ]
                    $item['id'] => [
                        'quantity' => $item['quantity']
                    ]
                ];
            }
            $purchase->items()->sync($items); //sync() でまとめて更新
            DB::commit();
            return to_route('dashboard');
        } catch (\Exception $e) {
            DB::rollback();
            return to_route('dashboard');
        }
    }

    //TODO　購入履歴に削除処理ははいらない？
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Purchase $purchase)
    // {
    // }
}
