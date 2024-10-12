<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['name' => 'destination','slug' => 'destinations','home_name' => 'destinations', 'template_name' => 'adventure', 'type' => 1],
            ['name' => 'destination','slug' => 'destinations','home_name' => 'destinations', 'template_name' => 'relaxation', 'type' => 1],
            ['name' => 'package','slug' => 'package','home_name' => 'package', 'template_name' => 'adventure', 'type' => 1],
            ['name' => 'package','slug' => 'package','home_name' => 'package', 'template_name' => 'relaxation', 'type' => 1],
            ['name' => 'blog','slug' => 'blog','home_name' => 'blog', 'template_name' => 'adventure', 'type' => 1],
            ['name' => 'blog','slug' => 'blog','home_name' => 'blog', 'template_name' => 'relaxation', 'type' => 1],
        ];
        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }
    }
}
