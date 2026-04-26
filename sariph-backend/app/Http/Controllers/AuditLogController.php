<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
class AuditLogController extends Controller {
    public function index() {
        $logs = AuditLog::with(['cashier','approver'])->orderBy('created_at','desc')->get();
        return response()->json($logs);
    }
}
