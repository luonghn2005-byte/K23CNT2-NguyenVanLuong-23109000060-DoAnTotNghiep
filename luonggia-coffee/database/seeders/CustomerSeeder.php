<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder {
    public function run(): void {
        // 1. Xóa những khách hàng cũ
        User::where('role', 'customer')->delete();

        // 2. Tìm ID lớn nhất của Nhân viên/Admin hiện tại (để khách hàng bắt đầu ngay sau đó)
        $maxStaffId = User::whereIn('role', ['admin', 'manager', 'staff'])->max('id') ?? 0;
        
        // 3. Ép MySQL đặt lại bộ đếm ID
        DB::statement('ALTER TABLE users AUTO_INCREMENT = ' . ($maxStaffId + 1));

        // 4. Tạo 20 khách hàng mới
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Khách hàng ' . $i,
                'email' => 'customer' . $i . '@gmail.com',
                'password' => Hash::make('pass' . $i), 
                'role' => 'customer', 
                'branch_id' => null,
            ]);
        }
    }
}       