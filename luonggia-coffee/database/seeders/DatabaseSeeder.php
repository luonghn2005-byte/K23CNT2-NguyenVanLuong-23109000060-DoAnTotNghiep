<?php
namespace Database\Seeders;
use App\Models\{User, Branch, Category, Product};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // 1. Tạo 11 chi nhánh mẫu
        $branchesData = [
            ['name' => 'LuongGia - Quận 1', 'address' => '123 Nguyễn Huệ, Q1, TP.HCM', 'phone' => '0909000111'],
            ['name' => 'LuongGia - Quận 3', 'address' => '456 Võ Văn Tần, Q3, TP.HCM', 'phone' => '0909000222'],
            ['name' => 'LuongGia - Quận 7', 'address' => '789 Nguyễn Thị Thập, Q7, TP.HCM', 'phone' => '0909000333'],
            ['name' => 'LuongGia - Thủ Đức', 'address' => 'Số 1 Võ Văn Ngân, TP. Thủ Đức', 'phone' => '0909000444'],
            ['name' => 'LuongGia - Bình Thạnh', 'address' => '123 Xô Viết Nghệ Tĩnh, Q. Bình Thạnh', 'phone' => '0909000555'],
            ['name' => 'LuongGia - Phú Nhuận', 'address' => '45 Phan Xích Long, Q. Phú Nhuận', 'phone' => '0909000666'],
            ['name' => 'LuongGia - Tân Bình', 'address' => '200 Cộng Hòa, Q. Tân Bình', 'phone' => '0909000777'],
            ['name' => 'LuongGia - Gò Vấp', 'address' => '50 Quang Trung, Q. Gò Vấp', 'phone' => '0909000888'],
            ['name' => 'LuongGia - Bình Tân', 'address' => '12 Kinh Dương Vương, Q. Bình Tân', 'phone' => '0909000999'],
            ['name' => 'LuongGia - Nhà Bè', 'address' => 'Nguyễn Hữu Thọ, H. Nhà Bè', 'phone' => '0909000101'],
            ['name' => 'LuongGia - Cần Thơ', 'address' => '30 Hòa Bình, Ninh Kiều, Cần Thơ', 'phone' => '0909000202'],
        ];

        foreach ($branchesData as $b) {
            Branch::create([
                'name' => $b['name'],
                'address' => $b['address'],
                'phone' => $b['phone'],
                'is_active' => true,
            ]);
        }

        // 2. Tạo tài khoản Admin (Gán vào chi nhánh đầu tiên)
        $adminBranch = Branch::first();
        User::create([
            'name' => 'Admin LuongGia',
            'email' => 'admin@luonggia.vn',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'branch_id' => $adminBranch->id,
        ]);

        // 3. Tạo 55 nhân viên ngẫu nhiên
        $branches = Branch::all();
        for ($i = 1; $i <= 55; $i++) {
            User::create([
                'name' => 'Nhân viên ' . $i,
                'email' => 'staff' . $i . '@luonggia.vn',
                'password' => Hash::make('12345678'),
                // Ngẫu nhiên chọn vai trò Manager hoặc Staff
                'role' => $i % 10 == 0 ? 'manager' : 'staff', 
                // Ngẫu nhiên gán vào 1 trong 11 chi nhánh
                'branch_id' => $branches->random()->id,
            ]);
        }

        // 4. Tạo danh mục
        $c1 = Category::create(['name'=>'Cà phê', 'slug'=>'ca-phe']);
        $c2 = Category::create(['name'=>'Trà sữa', 'slug'=>'tra-sua']);
        $c3 = Category::create(['name'=>'Bánh ngọt', 'slug'=>'banh-ngot']);
        $c4 = Category::create(['name'=>'Đá xay', 'slug'=>'da-xay']);

        // 5. Tạo 16 sản phẩm (Có kèm link ảnh)
        Product::insert([
            // --- CÀ PHÊ ---
            [
                'category_id' => $c1->id, 'name' => 'Cà phê đen', 
                'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=500&auto=format&fit=crop', 
                'price' => 25000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c1->id, 'name' => 'Cà phê sữa', 
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?q=80&w=500&auto=format&fit=crop', 
                'price' => 30000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c1->id, 'name' => 'Bạc xỉu', 
                'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=500&auto=format&fit=crop', 
                'price' => 35000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c1->id, 'name' => 'Espresso', 
                'image' => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?q=80&w=500&auto=format&fit=crop', 
                'price' => 30000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c1->id, 'name' => 'Cappuccino', 
                'image' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?q=80&w=500&auto=format&fit=crop', 
                'price' => 45000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],

            // --- TRÀ SỮA ---
            [
                'category_id' => $c2->id, 'name' => 'Trà sữa trân châu', 
                'image' => 'https://images.unsplash.com/photo-1558857563-b371033873b8?q=80&w=500&auto=format&fit=crop', 
                'price' => 40000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c2->id, 'name' => 'Trà sữa thái xanh', 
                'image' => 'https://images.unsplash.com/photo-1576092762791-dd9e22204421?q=80&w=500&auto=format&fit=crop', 
                'price' => 40000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c2->id, 'name' => 'Trà đào cam sả', 
                'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?q=80&w=500&auto=format&fit=crop', 
                'price' => 45000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c2->id, 'name' => 'Trà sữa matcha', 
                'image' => 'https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?q=80&w=500&auto=format&fit=crop', 
                'price' => 45000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],

            // --- BÁNH NGỌT ---
            [
                'category_id' => $c3->id, 'name' => 'Bánh Croissant', 
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=500&auto=format&fit=crop', 
                'price' => 35000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c3->id, 'name' => 'Bánh Tiramisu', 
                'image' => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?q=80&w=500&auto=format&fit=crop', 
                'price' => 45000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c3->id, 'name' => 'Bánh Macaron', 
                'image' => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?q=80&w=500&auto=format&fit=crop', 
                'price' => 50000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c3->id, 'name' => 'Bánh Mousse Chanh Dây', 
                'image' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=500&auto=format&fit=crop', 
                'price' => 40000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],

            // --- ĐÁ XAY ---
            [
                'category_id' => $c4->id, 'name' => 'Đá xay Cookie', 
                'image' => 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=500&auto=format&fit=crop', 
                'price' => 55000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c4->id, 'name' => 'Đá xay Matcha', 
                'image' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?q=80&w=500&auto=format&fit=crop', 
                'price' => 50000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'category_id' => $c4->id, 'name' => 'Đá xay Chocolate', 
                'image' => 'https://images.unsplash.com/photo-1541658016709-82535e94bc69?q=80&w=500&auto=format&fit=crop', 
                'price' => 50000, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }
}