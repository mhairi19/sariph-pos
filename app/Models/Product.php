<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['name', 'barcode', 'price', 'stock', 'category', 'active'];
    protected $casts = ['active' => 'boolean', 'price' => 'float', 'stock' => 'integer'];
}
