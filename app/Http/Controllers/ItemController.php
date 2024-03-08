<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Item::all()でもすべて取得できるが、パフォーマンスの為 Item::select->()->get() を使用
        return Inertia::render('Items/Index', [
            'items' => Item::select('id', 'name', 'price', 'is_selling')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     *
     */
    public function create()
    {
        return Inertia::render('Items/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreItemRequest $request)
    {
        // 商品登録処理
        Item::create([
            'name' => $request->name,
            'memo' => $request->memo,
            'price' => $request->price,
        ]);

        // リダイレクト&フラッシュメッセージ
        return to_route('items.index')
            ->with([
                'message' => '登録しました。',
                'status' => 'success' // 追記
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Inertia\Response
     */
    public function show(Item $item)
    {
        // 一つのレコードだけ返す(Object)
        return Inertia::render(
            'Items/Show',
            [
                'item' => $item
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Inertia\Response
     */
    public function edit(Item $item)
    {
        // 一つのレコードだけ返す(Object)
        return Inertia::render('Items/Edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        // 「$item->name」は変更前、「$request->name」は変更後
        // dd($item->name, $request->name);

        // 更新処理
        $item->name = $request->name;
        $item->memo = $request->memo;
        $item->price = $request->price;
        $item->is_selling = $request->is_selling;
        $item->save();
        return to_route('items.index')
            ->with([
                'message' => '更新しました。',
                'status' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Item $item)
    {
        // TODO ソフトデリート実装予定
        $item->delete();

        return to_route('items.index')
            ->with([
                'message' => '削除しました。',
                'status' => 'danger'
            ]);
    }
}
