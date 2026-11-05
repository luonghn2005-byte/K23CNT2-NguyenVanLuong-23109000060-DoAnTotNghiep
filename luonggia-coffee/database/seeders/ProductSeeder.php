<?php
namespace Database\Seeders;
use App\Models\{Category, Product};
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    public function run(): void {
        // 1. Tạo danh mục (nếu chưa có)
        $c1 = Category::firstOrCreate(['slug'=>'ca-phe'], ['name'=>'Cà phê']);
        $c2 = Category::firstOrCreate(['slug'=>'tra-sua'], ['name'=>'Trà sữa']);
        $c3 = Category::firstOrCreate(['slug'=>'banh-ngot'], ['name'=>'Bánh ngọt']);
        $c4 = Category::firstOrCreate(['slug'=>'da-xay'], ['name'=>'Đá xay']);

        // 2. Chỉ nạp sản phẩm nếu bảng products đang trống (tránh bị trùng lặp)
        if (Product::count() > 0) {
            return;
        }

        Product::insert([
            // --- CÀ PHÊ ---
            ['category_id'=>$c1->id,'name'=>'Cà phê đen','image'=>'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=500&auto=format&fit=crop','price'=>25000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c1->id,'name'=>'Cà phê sữa','image'=>'https://images.unsplash.com/photo-1572442388796-11668a67e53d?q=80&w=500&auto=format&fit=crop','price'=>30000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c1->id,'name'=>'Bạc xỉu','image'=>'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=500&auto=format&fit=crop','price'=>35000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c1->id,'name'=>'Espresso','image'=>'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?q=80&w=500&auto=format&fit=crop','price'=>30000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c1->id,'name'=>'Cappuccino','image'=>'https://images.unsplash.com/photo-1534778101976-62847782c213?q=80&w=500&auto=format&fit=crop','price'=>45000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],

            // --- TRÀ SỮA ---
            ['category_id'=>$c2->id,'name'=>'Trà sữa trân châu','image'=>'https://images.unsplash.com/photo-1558857563-b371033873b8?q=80&w=500&auto=format&fit=crop','price'=>40000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c2->id,'name'=>'Trà sữa thái xanh','image'=>'https://images.unsplash.com/photo-1576092762791-dd9e22204421?q=80&w=500&auto=format&fit=crop','price'=>40000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c2->id,'name'=>'Trà đào cam sả','image'=>'https://images.unsplash.com/photo-1556881286-fc6915169721?q=80&w=500&auto=format&fit=crop','price'=>45000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c2->id,'name'=>'Trà sữa matcha','image'=>'https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?q=80&w=500&auto=format&fit=crop','price'=>45000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],

            // --- BÁNH NGỌT ---
            ['category_id'=>$c3->id,'name'=>'Bánh Croissant','image'=>'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=500&auto=format&fit=crop','price'=>35000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c3->id,'name'=>'Bánh Tiramisu','image'=>'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?q=80&w=500&auto=format&fit=crop','price'=>45000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c3->id,'name'=>'Bánh Macaron','image'=>'https://images.unsplash.com/photo-1569864358642-9d1684040f43?q=80&w=500&auto=format&fit=crop','price'=>50000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c3->id,'name'=>'Bánh Mousse Chanh Dây','image'=>'https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=500&auto=format&fit=crop','price'=>40000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],

            // --- ĐÁ XAY ---
            ['category_id'=>$c4->id,'name'=>'Đá xay Cookie','image'=>'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=500&auto=format&fit=crop','price'=>55000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c4->id,'name'=>'Đá xay Matcha','image'=>'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?q=80&w=500&auto=format&fit=crop','price'=>50000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['category_id'=>$c4->id,'name'=>'Đá xay Chocolate','image'=>'https://images.unsplash.com/photo-1541658016709-82535e94bc69?q=80&w=500&auto=format&fit=crop','price'=>50000,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}