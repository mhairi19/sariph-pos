<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class TransactionController extends Controller {
    public function index() {
        $transactions = Transaction::with(['cashier','approver','items'])->orderBy('created_at','desc')->get();
        return response()->json($transactions);
    }
    public function store(Request $request) {
        $request->validate([
            'items' => 'required|array|min:1',
            'subtotal' => 'required|numeric',
            'discount_amount' => 'numeric',
            'discount_type' => 'nullable|string',
            'total' => 'required|numeric',
            'cash' => 'required|numeric',
            'change_amount' => 'required|numeric',
        ]);
        $receipt_no = 'OR-' . strtoupper(uniqid());
        $transaction = Transaction::create([
            'receipt_no' => $receipt_no,
            'cashier_id' => $request->user()->id,
            'subtotal' => $request->subtotal,
            'discount_amount' => $request->discount_amount ?? 0,
            'discount_type' => $request->discount_type,
            'total' => $request->total,
            'cash' => $request->cash,
            'change_amount' => $request->change_amount,
            'voided' => false,
        ]);
        foreach ($request->items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
            Product::where('id', $item['id'])->decrement('stock', $item['qty']);
        }
        return response()->json($transaction->load(['cashier','items']), 201);
    }
    public function postVoid(Request $request, $id) {
        $request->validate([
            'supervisor_username' => 'required|string',
            'supervisor_password' => 'required|string',
            'reason' => 'required|string',
        ]);
        $supervisor = User::where('username', $request->supervisor_username)
            ->where('role', 'Supervisor')
            ->where('active', true)
            ->first();
        if (!$supervisor || !Hash::check($request->supervisor_password, $supervisor->password)) {
            return response()->json(['message' => 'Invalid supervisor credentials.'], 401);
        }
        $transaction = Transaction::with('items')->findOrFail($id);
        if ($transaction->voided) {
            return response()->json(['message' => 'Transaction already voided.'], 400);
        }
        $transaction->voided = true;
        $transaction->void_reason = $request->reason;
        $transaction->approved_by = $supervisor->id;
        $transaction->save();
        foreach ($transaction->items as $item) {
            Product::where('id', $item->product_id)->increment('stock', $item->qty);
        }
        AuditLog::create([
            'type' => 'post_void',
            'cashier_id' => $transaction->cashier_id,
            'transaction_id' => $transaction->id,
            'receipt_no' => $transaction->receipt_no,
            'reason' => $request->reason,
            'approved_by' => $supervisor->id,
        ]);
        return response()->json($transaction->load(['cashier','approver','items']));
    }
    public function cancelSale(Request $request) {
        $request->validate(['items' => 'required|array']);
        AuditLog::create([
            'type' => 'cancel_sale',
            'cashier_id' => $request->user()->id,
            'items' => $request->items,
        ]);
        return response()->json(['message' => 'Sale cancelled and logged.']);
    }
    public function voidItem(Request $request) {
        $request->validate(['product_name' => 'required|string']);
        AuditLog::create([
            'type' => 'void_item',
            'cashier_id' => $request->user()->id,
            'product_name' => $request->product_name,
        ]);
        return response()->json(['message' => 'Item void logged.']);
    }
}
