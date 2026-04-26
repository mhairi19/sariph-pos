<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    protected $fillable = [
        'type', 'cashier_id', 'transaction_id', 'product_name',
        'receipt_no', 'reason', 'approved_by', 'items'
    ];
    protected $casts = ['items' => 'array'];
    public function cashier() {
        return $this->belongsTo(User::class, 'cashier_id');
    }
    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
