<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = ['product_id', 'nama_item', 'qty'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
