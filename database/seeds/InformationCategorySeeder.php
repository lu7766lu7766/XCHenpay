<?php

use App\Constants\InformationCategory\InformationCategoryConstants;
use App\Models\InformationCategory;
use Illuminate\Database\Seeder;

class InformationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (InformationCategoryConstants::enum() as $category) {
            InformationCategory::query()->create(['code' => $category]);
        }
    }
}
