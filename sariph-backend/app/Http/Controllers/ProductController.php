<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller {
    public function index() {
        return response()->json(Product::all());
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'barcode' => 'required|string|unique:products,barcode',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:Groceries,School Supplies,Household,Others',
        ]);
        $product = Product::create([
            'name' => $request->name,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'active' => true,
        ]);
        return response()->json($product, 201);
    }
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'barcode' => 'required|string|unique:products,barcode,'.$id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:Groceries,School Supplies,Household,Others',
        ]);
        $product->update($request->only('name','barcode','price','stock','category'));
        return response()->json($product);
    }
    public function toggleActive($id) {
        $product = Product::findOrFail($id);
        $product->active = !$product->active;
        $product->save();
        return response()->json($product);
    }
}
