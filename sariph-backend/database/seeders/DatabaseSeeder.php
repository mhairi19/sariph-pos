<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Users
        User::create(['name' => 'Maria Santos', 'username' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'Administrator', 'active' => true]);
        User::create(['name' => 'Juan dela Cruz', 'username' => 'cashier1', 'password' => Hash::make('cash123'), 'role' => 'Cashier', 'active' => true]);
        User::create(['name' => 'Ana Reyes', 'username' => 'super1', 'password' => Hash::make('super123'), 'role' => 'Supervisor', 'active' => true]);

        // Products
        Product::create(['name' => 'Lucky Me Pancit Canton', 'barcode' => '001', 'price' => 14.00, 'stock' => 50, 'category' => 'Groceries', 'active' => true]);
        Product::create(['name' => 'San Miguel Beer', 'barcode' => '002', 'price' => 55.00, 'stock' => 30, 'category' => 'Groceries', 'active' => true]);
        Product::create(['name' => 'Monggo Seeds 500g', 'barcode' => '003', 'price' => 38.00, 'stock' => 40, 'category' => 'Groceries', 'active' => true]);
        Product::create(['name' => 'Ballpen Blue (Pcs)', 'barcode' => '004', 'price' => 7.00, 'stock' => 100, 'category' => 'School Supplies', 'active' => true]);
        Product::create(['name' => 'Intermediate Pad', 'barcode' => '005', 'price' => 25.00, 'stock' => 60, 'category' => 'School Supplies', 'active' => true]);
        Product::create(['name' => 'Tide Powder 500g', 'barcode' => '006', 'price' => 42.00, 'stock' => 35, 'category' => 'Household', 'active' => true]);
        Product::create(['name' => 'Colgate Toothpaste', 'barcode' => '007', 'price' => 59.00, 'stock' => 25, 'category' => 'Household', 'active' => true]);
        Product::create(['name' => 'Globe Prepaid Load 50', 'barcode' => '008', 'price' => 50.00, 'stock' => 200, 'category' => 'Others', 'active' => true]);
    }
}
