<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitiesSeeder extends Seeder
{

    protected $data = [
        [
            "state" =>  "تونس",
            "cities" =>  [
                "قرطاج", "المدينة", "باب البحر", "باب سويقة", "العمران", "العمران الأعلى", "التحرير", "المنزه", "حي الخضراء", "باردو", "السيجومي", "الزهور", "الحرائرية", "سيدي حسين", "الوردية", "الكبارية", "سيدي البشير", "جبل الجلود", "حلق الوادي", "الكرم", "المرسى"
            ]
        ],
        [
            "state" =>  "أريانة",
            "cities" =>  [
                "أريانة المدينة", "سكرة", "رواد", "قلعة الأندلس", "سيدي ثابت", "حي التضامن", "المنيهلة"
            ]
        ],
        [
            "state" =>  "منوبة",
            "cities" =>  [
                "منوبة", "وادي الليل", "طبربة", "البطان", "الجديدة", "المرناقية", "برج العامري", "دوار هيشر"
            ]
        ],
        [
            "state" =>  "بن عروس",
            "cities" =>  [
                "بن عروس", "المدينة الجديدة", "المروج", "حمام الأنف", "حمام الشط", "بومهل البساتين", "الزهراء", "رادس", "مقرين", "المحمدية", "فوشانة", "مرناق"
            ]
        ],
        [
            "state" =>  "نابل",
            "cities" =>  [
                "نابل", "دار شعبان الفهري", "بني خيار", "قربة", "منزل تميم", "الميدة", "قليبية", "حمام الأغزاز", "الهوارية", "تاكلسة", "سليمان", "منزل بوزلفة", "بني خلاد", "قرمبالية", "بوعرقوب", "الحمامات"
            ]
        ],
        [
            "state" =>  "بنزرت",
            "cities" =>  [
                "بنزرت الشمالية", "جرزونة", "بنزرت الجنوبية", "سجنان", "جومين", "ماطر", "غزالة", "منزل بورقيبة", "تينجة", "أوتيك", "غار الملح ", "منزل جميل", "العالية ", "رأس الجبل"
            ]
        ],
        [
            "state" =>  "زغوان",
            "cities" =>  [
                "زغوان", "الزريبة", "بئر مشارقة", "الفحص", "الناظور", "صواف"
            ]
        ],
        [
            "state" =>  "سوسة",
            "cities" =>  [
                "سوسة المدينة", "الزاوية القصيبة الثريات ", "سوسة الرياض", "سوسة جوهرة", "سوسة سيدي عبد الحميد", "حمام سوسة", "أكودة", "القلعة الكبرى", "سيدي بوعلي", "هرقلة", "النفيضة", "بوفيشة", "كندار", "سيدي الهاني", "مساكن", "القلعة الصغرى"
            ]
        ],
        [
            "state" =>  "المنستير",
            "cities" =>  [
                "المنستيـر", "الوردانيـن", "الساحليـن", "زرمديـن", "بنـي حسان", "جمـال", "بنبلة", "المكنين", "البقالطة", "طبلبة", "قصر هلال", "قصيبة المديوني", "صيادة لمطة بوحجر"
            ]
        ],
        [
            "state" =>  "المهدية",
            "cities" =>  [
                "المهدية", "بومرداس", "أولاد الشامخ", "شربان", "هبيرة", "السواسي", "الجم", "الشابة", "ملولش", "سيدي علوان", "قصور الساف"
            ]
        ],
        [
            "state" =>  "صفاقس",
            "cities" =>  [
                "صفاقـس المدينة", "صفاقـس الغربية", "ساقية الزيت", "ساقية الداير", "صفاقس الجنوبية ", "طينة", "عقارب", "جبنيانة", "العامرة", "الحنشة", "منزل شاكر", "الغريبة", "بئر علي بن خليفة", "الصخيرة", "المحرس", "قـرقنـة"
            ]
        ],
        [
            "state" =>  "باجة",
            "cities" =>  [
                "باجة الشمالية", "باجة الجنوبية", "عمدون", "نفزة", "تبرسق", "تيبار", "تستور", "قبلاط", "مجاز الباب"
            ]
        ],
        [
            "state" =>  "جندوبة",
            "cities" =>  [
                "جنـدوبة", "جنـدوبة الشمالية", "بوسالم", "طبرقـة", "عين دراهم", "فرنانة", "غار الدماء", "وادي مليز", "بلطة بوعوان"
            ]
        ],
        [
            "state" =>  "الكاف",
            "cities" =>  [
                "الكاف الغربية", "الكاف الشرقية", "نبـر", "ساقية سيدي يوسف", "تاجروين", "قلعة سنان", "القلعة الخصبة", "الجريصة", "القصور", "الدهماني", "السرس"
            ]
        ],
        [
            "state" =>  "سليانة",
            "cities" =>  [
                "سليانة الشمالية", "سليانة الجنوبية", "بوعرادة", "قعفور", "العروسة", "الكريب", "بورويس", "مكثر", "الروحية", "كسرى", "برقو"
            ]
        ],
        [
            "state" =>  "القيروان",
            "cities" =>  [
                "القيروان الشمالية", "القيروان الجنوبية", "الشبيكة", "السبيخة", "الوسلاتية", "حفوز", "العلا", "حاجب العيون", "نصر الله", "الشراردة", "بوحجلة"
            ]
        ],
        [
            "state" =>  "سيدي بوزيد",
            "cities" =>  [
                "سيدي بوزيد الغربية", "سيدي بوزيد الشرقية", "جلمة", "سبالة أولاد عسكر", "بئر الحفي", "سيدي علي بن عون", "منزل بوزيان", "المكناسي", "سوق الجديد", "المزونة", "الرقاب", "أولاد حفوز"
            ]
        ],
        [
            "state" =>  "القصرين",
            "cities" =>  [
                "القصرين الشمالية", "القصرين الجنوبية", "الزهور", "حاسي الفريد", "سبيطلة", "سبيبة", "جدليان", "العيون", "تالة", "حيدرة", "فوسانة", "فريانة", "ماجل بلعباس"
            ]
        ],
        [
            "state" =>  "قابس",
            "cities" =>  [
                "قابـس المدينة", "قابـس الغربية", "قابـس الجنوبية", "غنوش", "المطوية", "منزل الحبيب", "الحامة", "مطماطة", "مطماطة الجديدة", "مارث"
            ]
        ],
        [
            "state" =>  "مدنين",
            "cities" =>  [
                "مدنيـن الشمالية", "مدنين الجنوبية", "بني خداش", "بن قردان", "جرجيس", "جربة حومة السوق", "جربة ميدون", "جربة أجيم", "سيدي مخلوف"
            ]
        ],
        [
            "state" =>  "قفصة",
            "cities" =>  [
                "قفصة الشمالية", "سيدي عيش", "القصر", "قفصة الجنوبية", "أم العرائس", "الرديف", "المتلوي", "المظيلة", "القطار", "بلخير", "السند"
            ]
        ],
        [
            "state" =>  "توزر",
            "cities" =>  [
                "توزر", "دقاش", "تمغزة", "نفطة", "حزوة"
            ]
        ],
        [
            "state" =>  "تطاوين",
            "cities" =>  [
                "تطاوين الشمالية", "تطاوين الجنوبية", "الصمار", "البئر الأحمر", "غمراسن", "ذهيبة", "رمادة"
            ]
        ],
        [
            "state" =>  "قبلي",
            "cities" =>  [
                "قبلي الجنوبية", "قبلي الشمالية", "سوق الأحد", "دوز الشمالية", "دوز الجنوبية ", "الفوار"
            ]
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $state) {
            $parentState = State::where('name', $state['state'])->first();
            $stateId = $parentState->id;
            foreach ($state['cities'] as $city) {

                DB::table('cities')->insert([
                    'name'  => $city,
                    'state_id' => $stateId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
