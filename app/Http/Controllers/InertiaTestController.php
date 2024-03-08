<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertiaTest;

class InertiaTestController extends Controller
{
    public function index()
    {
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()  // Laravelでモデル経由でデータ取得する場合、配列を拡張したコレクション型になる
        ]);
    }


    public function create()
    {
        return Inertia::render('Inertia/Create');
    }


    public function show($id)
    {
        // dd($id);
        return Inertia::render(
            'Inertia/Show',
            [
                'id' => $id,
                'blog' => InertiaTest::findOrFail($id)
            ]
        );
    }





    public function store(Request $request)
    {

        //バリデーション
        //View側に errors というオブジェクトが渡る
        $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required'],
        ]);

        //データを保存
        $inertiaTest = new InertiaTest;
        $inertiaTest->title = $request->title;
        $inertiaTest->content = $request->content;
        $inertiaTest->save();

        //フラッシュメッセージ付きでリダイレクト(with)
        // return to_route('inertia.index');
        return to_route('inertia.index')->with([
            'message' => '登録しました。'
        ]);
    }


    public function delete($id)
    {
        // 削除処理
        $blog = InertiaTest::findOrFail($id);
        $blog->delete();
        return to_route('inertia.index')
            ->with(['message' => '削除しました。']);
    }
}
