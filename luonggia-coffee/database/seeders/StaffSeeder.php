<?php
namespace Database\Seeders;
use App\Models\{User, Branch};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder {
    public function run(): void {
        $branches = Branch::all();
        if ($branches->isEmpty()) {
            return; // Nếu chưa có chi nhánh thì dừng
        }

        for ($i = 1; $i <= 55; $i++) {
            // Kiểm tra xem email đã tồn tại chưa để tránh lỗi trùng
            $email = 'staff' . $i . '@luonggia.vn';
            if (User::where('email', $email)->exists()) continue;

            User::create([
                'name' => 'Nhân viên ' . $i,
                'email' => $email,
                'password' => Hash::make('12345678'),
                'role' => $i % 10 == 0 ? 'manager' : 'staff', 
                'branch_id' => $branches->random()->id,
            ]);
        }
    }
}