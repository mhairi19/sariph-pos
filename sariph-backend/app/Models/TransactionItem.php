<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model {
    protected $fillable = [
        'transaction_id', 'product_id', 'product_name', 'price', 'qty', 'subtotal'
    ];
    protected $casts = ['price' => 'float', 'qty' => 'integer', 'subtotal' => 'float'];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
