<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    protected  $states = [
        "تونس",
        "أريانة",
        "منوبة",
        "بن عروس",
        "نابل",
        "بنزرت",
        "زغوان",
        "سوسة",
        "المنستير",
        "المهدية",
        "صفاقس",
        "باجة",
        "جندوبة",
        "الكاف",
        "سليانة",
        "القيروان",
        "سيدي بوزيد",
        "القصرين",
        "قابس",
        "مدنين",
        "قفصة",
        "توزر",
        "تطاوين",
        "قبلي"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
