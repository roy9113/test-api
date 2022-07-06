<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }
}
