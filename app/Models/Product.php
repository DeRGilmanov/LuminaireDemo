<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    // В модели Product
    public function getStockStatusTextAttribute()
    {
        return [
            'instock' => 'В наличии',
            'outofstock' => 'Нет в наличии'
        ][$this->stock_status];
    }
    
}
