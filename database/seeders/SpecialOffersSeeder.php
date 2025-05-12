<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SpecialOffer;
use Carbon\Carbon;


class SpecialOffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpecialOffer::insert([
            [
                'title' => 'Pavasario žiedų pasiūlymas',
                'code' => 'PAVASARIS10',
                'discount' => 0.10, // 10%
                'valid_until' => Carbon::now()->addWeeks(2)->format('Y-m-d'),
                'description' => 'Pasinaudokite 10% nuolaida visoms pavasario gėlėms! Galioja tik ribotą laiką.',
                'image' => 'spring-flowers.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
