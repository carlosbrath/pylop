<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- Mirpur Division ---
        $mirpurDivision = Location::create([
            'type' => 'division',
            'name' => 'Mirpur Division',
            'name_ur' => 'ڈویژن میرپور',
        ]);

        // District: Mirpur
        $mirpurDistrict = Location::create([
            'type' => 'district',
            'name' => 'Mirpur',
            'name_ur' => 'میرپور',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Mirpur',
                'name_ur' => 'میرپور',
                'parent_id' => $mirpurDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Dadyal',
                'name_ur' => 'ڈڈیال',
                'parent_id' => $mirpurDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Islamgarh',
                'name_ur' => 'اسلام گڑھ',
                'parent_id' => $mirpurDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // District: Kotli
        $kotliDistrict = Location::create([
            'type' => 'district',
            'name' => 'Kotli',
            'name_ur' => 'کوٹلی',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Kotli',
                'name_ur' => 'کوٹلی',
                'parent_id' => $kotliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Khuiratta',
                'name_ur' => 'خویرٹہ',
                'parent_id' => $kotliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Fatehpur',
                'name_ur' => 'فتح پور',
                'parent_id' => $kotliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Sehnsa',
                'name_ur' => 'سہنسہ',
                'parent_id' => $kotliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Charhoi',
                'name_ur' => 'چھڑھوئی',
                'parent_id' => $kotliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // District: Bhimber
        $bhimberDistrict = Location::create([
            'type' => 'district',
            'name' => 'Bhimber',
            'name_ur' => 'بھمبر',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Bhimber',
                'name_ur' => 'بھمبر',
                'parent_id' => $bhimberDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Barnala',
                'name_ur' => 'برنالہ',
                'parent_id' => $bhimberDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Samahni',
                'name_ur' => 'سماہنی',
                'parent_id' => $bhimberDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        // --- Muzaffarabad Division ---
        $muzaffarabadDivision = Location::create([
            'type' => 'division',
            'name' => 'Muzaffarabad Division',
            'name_ur' => 'ڈویژن مظفرآباد',
        ]);

        // District: Muzaffarabad
        $muzaffarabadDistrict = Location::create([
            'type' => 'district',
            'name' => 'Muzaffarabad',
            'name_ur' => 'مظفرآباد',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Muzaffarabad Tehsil',
                'name_ur' => 'تحصیل مظفرآباد',
                'parent_id' => $muzaffarabadDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Nasirabad (Pattika)',
                'name_ur' => 'پٹیکہ / ناصرآباد',
                'parent_id' => $muzaffarabadDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Chikar',
                'name_ur' => 'چکار',
                'parent_id' => $muzaffarabadDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // District: Neelum
        $neelumDistrict = Location::create([
            'type' => 'district',
            'name' => 'Neelum',
            'name_ur' => 'وادی نیلم',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Athmuqam',
                'name_ur' => 'آٹھمقام',
                'parent_id' => $neelumDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Sharda',
                'name_ur' => 'شاردہ',
                'parent_id' => $neelumDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Kundal Shahi',
                'name_ur' => 'کنڈل شاہی',
                'parent_id' => $neelumDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // District: Jhelum Valley (Hattian Bala)
        $jhelumValleyDistrict = Location::create([
            'type' => 'district',
            'name' => 'Jhelum Valley',
            'name_ur' => 'وادی جہلم (ہٹیاں بالا)',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Hattian Bala',
                'name_ur' => 'ہٹیاں بالا',
                'parent_id' => $jhelumValleyDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Leepa',
                'name_ur' => 'لیپہ',
                'parent_id' => $jhelumValleyDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Chikar',
                'name_ur' => 'چکار',
                'parent_id' => $jhelumValleyDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        // --- Poonch Division ---
        $poonchDivision = Location::create([
            'type' => 'division',
            'name' => 'Poonch Division',
            'name_ur' => 'ڈویژن پونچھ',
        ]);

        // District: Poonch (Rawalakot)
        $poonchDistrict = Location::create([
            'type' => 'district',
            'name' => 'Poonch',
            'name_ur' => 'پونچھ (راولا کوٹ)',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Rawalakot',
                'name_ur' => 'راولا کوٹ',
                'parent_id' => $poonchDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Hajira',
                'name_ur' => 'حاجیرا',
                'parent_id' => $poonchDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Abbaspur',
                'name_ur' => 'عباس پور',
                'parent_id' => $poonchDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // District: Bagh
        $baghDistrict = Location::create([
            'type' => 'district',
            'name' => 'Bagh',
            'name_ur' => 'باغ',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Bagh',
                'name_ur' => 'باغ',
                'parent_id' => $baghDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Rera',
                'name_ur' => 'ریڑہ',
                'parent_id' => $baghDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Dhirkot',
                'name_ur' => 'دھیر کوٹ',
                'parent_id' => $baghDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // District: Haveli
        $haveliDistrict = Location::create([
            'type' => 'district',
            'name' => 'Haveli',
            'name_ur' => 'حویلی',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Khurshidabad',
                'name_ur' => 'خورشید آباد',
                'parent_id' => $haveliDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // District: Sudhnoti
        $sudhnotiDistrict = Location::create([
            'type' => 'district',
            'name' => 'Sudhnoti',
            'name_ur' => 'سدھنوتی',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            [
                'type' => 'tehsil',
                'name' => 'Pallandri',
                'name_ur' => 'پلندری',
                'parent_id' => $sudhnotiDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Mang',
                'name_ur' => 'منگ',
                'parent_id' => $sudhnotiDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'tehsil',
                'name' => 'Tarar Khel',
                'name_ur' => 'ترڑکھل',
                'parent_id' => $sudhnotiDistrict->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
