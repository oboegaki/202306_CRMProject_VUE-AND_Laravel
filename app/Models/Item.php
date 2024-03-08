<?php

namespace App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // コントローラ側 Item::create() で保存できるようにモデル側に追記
    protected $fillable = [
        'name',
        'memo',
        'price',
        'is_selling'
    ];

    // メソッド名は複数形にしておく
    public function purchases()
    {
        //中間テーブルの中身を取得するには withPivot を使う
        return $this->belongsToMany(Purchase::class)->withPivot('quantity');
    }
}
