<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalysisService
{
    public static function perDay($subQuery)
    {
        $query = $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, sum(subtotal) as totalPerPurchase,
      DATE_FORMAT(created_at, "%Y%m%d") as date');

        $data = DB::table($query) //コレクション型
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        // ■ 日別データをグラフ表示
        //   vue用に配列を作成
        //   $data・・日別集計 コレクション型
        $labels = $data->pluck('date');  //pluck('date') = keyが date のものを取得
        $totals = $data->pluck('total');

        return [$data, $labels, $totals]; //複数の変数を渡すので一旦配列に入れる

    }

    public static function perMonth($subQuery)
    {
        $query = $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, sum(subtotal) as totalPerPurchase,
      DATE_FORMAT(created_at, "%Y%m") as date');

        $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return [$data, $labels, $totals];
    }

    public static function perYear($subQuery)
    {
        $query = $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, sum(subtotal) as totalPerPurchase,
      DATE_FORMAT(created_at, "%Y") as date');

        $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return [$data, $labels, $totals];
    }
}
