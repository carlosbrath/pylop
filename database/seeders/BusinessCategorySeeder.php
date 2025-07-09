<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            'IT & Digital Sector' => [
                'Information Technology (by professionals)',
                'E-Commerce',
                'Digital Marketing',
                'Software Houses',
                'Call Centres',
                'TEVT Sector',
            ],
            'Handicrafts & Cottage Industries' => [
                'Hand knotted carpet weaving',
                'Walnut wood carving',
                'Kashmiri Shawls & Embroidery',
                'Papier Machie',
                'Chain-stitch, Numda & Gabba',
                'Kangi Making',
                'Phiren & Embroidered Dresses',
            ],
            'Agriculture & Livestock' => [
                'Agri-Businesses',
                'Livestock, Dairy & Poultry Farming',
                'Horticulture & Rose Farming',
                'Olive Plantation',
                'Off-season Vegetable Farming',
            ],
            'Tourism & Hospitality' => [
                'Traditional Food Courts',
                'Paying Guest Units',
                'Hotels & Restaurants',
            ],
            'SMEs & Local Industry' => [
                'Silk Rearing & Processing',
                'Gem Stone Cutting',
                'Stone Carving & Crushing',
                'Sports Goods Manufacturing',
                'Light Engineering Sector',
                'Auto Repair & Workshops',
            ],
            'Women Entrepreneurs & Misc.' => [
                'Boutiques & Tailoring',
                'Home Baking Units',
                'Pickle, Jam & Jelly Making',
                'Garments / Stitching Units',
                'Mineral Water Plants',
                'Soap & Detergent Production',
                'New Innovations',
            ],
        ];

        foreach ($data as $category => $subcategories) {
            $parent = BusinessCategory::create([
                'name' => $category,
                'parent_id' => 0,
            ]);

            foreach ($subcategories as $sub) {
                BusinessCategory::create([
                    'name' => $sub,
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
