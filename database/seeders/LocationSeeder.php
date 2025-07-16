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
        // --- Muzaffarabad Division ---
        $muzaffarabadDivision = Location::create([
            'type' => 'division',
            'name' => 'Muzaffarabad Division',
            'name_ur' => 'ڈویژن مظفرآباد',
        ]);

        // District: Neelum
        $neelumDistrict = Location::create([
            'type' => 'district',
            'name' => 'Neelum',
            'name_ur' => 'وادی نیلم',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Athmuqam', 'name_ur' => 'آٹھمقام', 'parent_id' => $neelumDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Sharda', 'name_ur' => 'شاردہ', 'parent_id' => $neelumDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Muzaffarabad
        $muzaffarabadDistrict = Location::create([
            'type' => 'district',
            'name' => 'Muzaffarabad',
            'name_ur' => 'مظفرآباد',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Muzaffarabad', 'name_ur' => 'مظفرآباد', 'parent_id' => $muzaffarabadDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Naseerbad', 'name_ur' => 'نصیر آباد', 'parent_id' => $muzaffarabadDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Jhelum Valley
        $jhelumValleyDistrict = Location::create([
            'type' => 'district',
            'name' => 'Jhelum Valley',
            'name_ur' => 'وادی جہلم',
            'parent_id' => $muzaffarabadDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Hattain Bala', 'name_ur' => 'ہٹیاں بالا', 'parent_id' => $jhelumValleyDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Chikar', 'name_ur' => 'چکار', 'parent_id' => $jhelumValleyDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Leepa', 'name_ur' => 'لیپہ', 'parent_id' => $jhelumValleyDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- Poonch Division ---
        $poonchDivision = Location::create([
            'type' => 'division',
            'name' => 'Poonch Division',
            'name_ur' => 'ڈویژن پونچھ',
        ]);

        // District: Bagh
        $baghDistrict = Location::create([
            'type' => 'district',
            'name' => 'Bagh',
            'name_ur' => 'باغ',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Bagh', 'name_ur' => 'باغ', 'parent_id' => $baghDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Dhirkot', 'name_ur' => 'دھیر کوٹ', 'parent_id' => $baghDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Hari Ghel', 'name_ur' => 'ہری گہل', 'parent_id' => $baghDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Haveli
        $haveliDistrict = Location::create([
            'type' => 'district',
            'name' => 'Haveli',
            'name_ur' => 'حویلی',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Haveli', 'name_ur' => 'حویلی', 'parent_id' => $haveliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Khurshidabad', 'name_ur' => 'خورشیدآباد', 'parent_id' => $haveliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Mumtazabad', 'name_ur' => 'ممتاز آباد', 'parent_id' => $haveliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Poonch
        $poonchDistrict = Location::create([
            'type' => 'district',
            'name' => 'Poonch',
            'name_ur' => 'پونچھ',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Abbaspur', 'name_ur' => 'عباس پور', 'parent_id' => $poonchDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Hajira', 'name_ur' => 'حاجیرا', 'parent_id' => $poonchDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Rawlakot', 'name_ur' => 'راولا کوٹ', 'parent_id' => $poonchDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Thorar', 'name_ur' => 'تھوراڑ', 'parent_id' => $poonchDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Sudhnoti
        $sudhnotiDistrict = Location::create([
            'type' => 'district',
            'name' => 'Sudhnoti',
            'name_ur' => 'سدھنوتی',
            'parent_id' => $poonchDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Balouch', 'name_ur' => 'بلوچ', 'parent_id' => $sudhnotiDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Mang', 'name_ur' => 'منگ', 'parent_id' => $sudhnotiDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Pallandri', 'name_ur' => 'پلندری', 'parent_id' => $sudhnotiDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Tarar Khel', 'name_ur' => 'ترڑکھل', 'parent_id' => $sudhnotiDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- Mirpur Division ---
        $mirpurDivision = Location::create([
            'type' => 'division',
            'name' => 'Mirpur Division',
            'name_ur' => 'ڈویژن میرپور',
        ]);

        // District: Kotli
        $kotliDistrict = Location::create([
            'type' => 'district',
            'name' => 'Kotli',
            'name_ur' => 'کوٹلی',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Kotli', 'name_ur' => 'کوٹلی', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Khuiratta', 'name_ur' => 'خویرٹہ', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Fatehpur Thakiala', 'name_ur' => 'فتح پور تھکیالہ', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Sehnsa', 'name_ur' => 'سہنسہ', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Dulian Jattan', 'name_ur' => 'ڈولیان جٹاں', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Charhoi', 'name_ur' => 'چھڑھوئی', 'parent_id' => $kotliDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Mirpur
        $mirpurDistrict = Location::create([
            'type' => 'district',
            'name' => 'Mirpur',
            'name_ur' => 'میرپور',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Dadyal', 'name_ur' => 'ڈڈیال', 'parent_id' => $mirpurDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Mirpur', 'name_ur' => 'میرپور', 'parent_id' => $mirpurDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // District: Bhimber
        $bhimberDistrict = Location::create([
            'type' => 'district',
            'name' => 'Bhimber',
            'name_ur' => 'بھمبر',
            'parent_id' => $mirpurDivision->id
        ]);

        Location::insert([
            ['type' => 'tehsil', 'name' => 'Bhimber', 'name_ur' => 'بھمبر', 'parent_id' => $bhimberDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Barnala', 'name_ur' => 'برنالہ', 'parent_id' => $bhimberDistrict->id, 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'tehsil', 'name' => 'Samahni', 'name_ur' => 'سماہنی', 'parent_id' => $bhimberDistrict->id, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
