<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::query()->create([
            'first_name' => 'Murad',
            'last_name' => 'Ali',
            'address' => 'Office # 13, 3rd Floor, Shamasabad, Murree Road, Rawalpindi',
            'phone' => '0348-8957943',
            'username' => 'softwareflare',
            'email' => 'admin@softwareflare.com',
            'password' => bcrypt('123456'),
        ])->assignRole('administrator');

        Admin::factory()->count(25)->create();
    }
}
