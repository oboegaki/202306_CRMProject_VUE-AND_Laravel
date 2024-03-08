<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //メソッド名は複数形にしておく
    public function items()
    {
        //中間テーブルの中身を取得するには withPivot を使う
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
