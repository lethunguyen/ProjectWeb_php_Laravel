<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin sample
        if (!DB::table('Admin')->exists()) {
            DB::table('Admin')->insert([
                ['userName'=>'admin1','password'=>'123456','email'=>'admin1@email.com','role'=>'superadmin','createdDate'=>now()],
                ['userName'=>'staff1','password'=>'123456','email'=>'staff1@email.com','role'=>'staff','createdDate'=>now()],
            ]);
        }

        // Users
        if (!DB::table('User')->exists()) {
            DB::table('User')->insert([
                ['userName'=>'Nguyen Van A','password'=>'123456','email'=>'a@gmail.com','phoneNumber'=>'0901234567','gender'=>'Male','status'=>'Active','createdDate'=>now(),'updatedDate'=>now()],
                ['userName'=>'Tran Thi B','password'=>'123456','email'=>'b@gmail.com','phoneNumber'=>'0909876543','gender'=>'Female','status'=>'Active','createdDate'=>now(),'updatedDate'=>now()],
            ]);
        }

        // Category
        if (!DB::table('Category')->exists()) {
            DB::table('Category')->insert([
                ['categoryName'=>'Tour Biển','description'=>'Các tour nghỉ dưỡng và khám phá bãi biển'],
                ['categoryName'=>'Tour Núi','description'=>'Các tour leo núi, khám phá thiên nhiên rừng núi'],
                ['categoryName'=>'Tour Văn Hóa','description'=>'Khám phá văn hóa và di sản địa phương'],
            ]);
        }

        // Tour
        if (!DB::table('Tour')->exists()) {
            DB::table('Tour')->insert([
                ['categoryID'=>1,'title'=>'Du lịch Nha Trang 3N2Đ','description'=>'Khám phá biển đảo Nha Trang tuyệt đẹp','quantity'=>30,'priceAdult'=>3000000,'priceChild'=>1500000,'availability'=>true,'startDate'=>'2025-09-01','endDate'=>'2025-09-03'],
                ['categoryID'=>2,'title'=>'Leo Fansipan 2N1Đ','description'=>'Trải nghiệm chinh phục đỉnh núi cao nhất Việt Nam','quantity'=>20,'priceAdult'=>2500000,'priceChild'=>1200000,'availability'=>true,'startDate'=>'2025-09-10','endDate'=>'2025-09-11'],
            ]);
        }

        // Images
        if (!DB::table('Images')->exists()) {
            DB::table('Images')->insert([
                ['tourID'=>1,'imageURL'=>'https://example.com/nha-trang1.jpg','description'=>'Bãi biển Nha Trang','uploadDate'=>now()],
                ['tourID'=>1,'imageURL'=>'https://example.com/nha-trang2.jpg','description'=>'Lặn ngắm san hô','uploadDate'=>now()],
                ['tourID'=>2,'imageURL'=>'https://example.com/fansipan1.jpg','description'=>'Đỉnh Fansipan','uploadDate'=>now()],
            ]);
        }

        // Promotion
        if (!DB::table('Promotion')->exists()) {
            DB::table('Promotion')->insert([
                ['code'=>'SUMMER2025','description'=>'Giảm 20% cho tour mùa hè','discountType'=>'Percentage','discountValue'=>20,'startDate'=>'2025-06-01','endDate'=>'2025-08-31','isActive'=>true],
                ['code'=>'FANSIPAN50K','description'=>'Giảm 50,000đ cho tour Fansipan','discountType'=>'Fixed','discountValue'=>50000,'startDate'=>'2025-09-01','endDate'=>'2025-09-30','isActive'=>true],
            ]);
        }
    }
}
