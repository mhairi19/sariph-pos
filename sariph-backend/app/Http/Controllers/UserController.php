<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller {
    public function index() {
        return response()->json(User::all()->makeHidden(['password','remember_token']));
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:4',
            'role' => 'required|in:Administrator,Supervisor,Cashier',
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'active' => true,
        ]);
        return response()->json($user->makeHidden(['password','remember_token']), 201);
    }
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$id,
            'role' => 'required|in:Administrator,Supervisor,Cashier',
        ]);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json($user->makeHidden(['password','remember_token']));
    }
    public function toggleActive($id) {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
        return response()->json($user->makeHidden(['password','remember_token']));
    }
}
