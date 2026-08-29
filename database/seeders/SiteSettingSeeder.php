<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\SettingController;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SettingController::fields() as $key => [$value, $label, $group]) {
            SiteSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => $label, 'group' => $group]
            );
        }
    }
}
