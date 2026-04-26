<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = [
        'receipt_no', 'cashier_id', 'subtotal', 'discount_amount',
        'discount_type', 'total', 'cash', 'change_amount', 'voided',
        'void_reason', 'approved_by'
    ];
    protected $casts = [
        'voided' => 'boolean',
        'subtotal' => 'float',
        'discount_amount' => 'float',
        'total' => 'float',
        'cash' => 'float',
        'change_amount' => 'float',
    ];
    public function cashier() {
        return $this->belongsTo(User::class, 'cashier_id');
    }
    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function items() {
        return $this->hasMany(TransactionItem::class);
    }
}
