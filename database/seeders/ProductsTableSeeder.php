<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['id' => 2, 'name' => 'Miegančios rožės po kupolu', 'description' => 'Gražios miegančios rožės stiklo kupole.', 'price' => 60.00, 'category' => 'miegancios_rozes', 'image' => 'mieganti-roze-po-kupolu.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Burbulai sniege', 'description' => 'Kompoziciją sudaro 4 skirtingi elementai: balta guboja, rausvi momoko chrizantemų žiedai, melsva zunda ir eukalipto lapeliai.', 'price' => 30.00, 'category' => 'puokstes', 'image' => 'burbulai_sniege.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Loversų klasika', 'description' => 'Gaivi kompozicija iš 3 skirtingų elementų: baltos frezijos, rausvi momoko chrizantemų žiedai ir eukalipto lapeliai.', 'price' => 30.00, 'category' => 'puokstes', 'image' => 'loversu_klasika.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Linkėjimai iš Australijos', 'description' => 'Kompoziciją sudaro 4 elementai: rožinė guboja, melsva zunda, eukalipto lapeliai ir viešnia iš Australijos – banksija.', 'price' => 30.00, 'category' => 'puokstes', 'image' => 'linkejimai_is_austrijos.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Gvazdikų solo', 'description' => 'Kompoziciją sudaro 3 skirtingi elementai: balta guboja, persikiniai apple tea gvazdikai ir eukalipto lapeliai.', 'price' => 30.00, 'category' => 'puokstes', 'image' => 'gvazdiku_solo.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Kraspedijų lietus', 'description' => 'Kompoziciją sudaro 4 elementai: geltonos kraspedijos, balta guboja, melsva zunda ir eukalipto lapeliai.', 'price' => 30.00, 'category' => 'puokstes', 'image' => 'kraspediju_lietus.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'name' => 'Mieganti rožė po kupolu', 'description' => 'Kupolo matmenys: aukštis 30 cm., skersmuo 22 cm.', 'price' => 40.00, 'category' => 'miegancios_rozes', 'image' => 'mieganti_roze_po_kupolu.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'name' => 'Mieganti rožė po kupolu „Mini”', 'description' => 'Matmenys: bendras aukštis – 12 cm.', 'price' => 25.00, 'category' => 'miegancios_rozes', 'image' => 'mieganti_roze_po_kupolu_mini.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'name' => 'Miegančių rožių kompozicija', 'description' => 'Bendras aukštis apie 20 cm.', 'price' => 50.00, 'category' => 'miegancios_rozes', 'image' => 'mieganciu_roziu_kompozicija.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'name' => 'Miegančios rožės dėžutėje', 'description' => '...', 'price' => 100.00, 'category' => 'miegancios_rozes', 'image' => 'miegancios_rozes_dezuteje.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'name' => 'Raudonos rožės', 'description' => '', 'price' => 2.00, 'category' => 'skintos_geles', 'image' => 'raudonos_rozes.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'name' => 'Rožinės rožės', 'description' => '', 'price' => 2.00, 'category' => 'skintos_geles', 'image' => 'rozines_rozes.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'name' => 'Žalsvos rožės', 'description' => '', 'price' => 2.00, 'category' => 'skintos_geles', 'image' => 'zalsvos_rozes.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'name' => 'Raudonos tulpės', 'description' => '', 'price' => 1.50, 'category' => 'skintos_geles', 'image' => 'raudonos_tulpes.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'name' => 'Baltos tulpės', 'description' => '', 'price' => 1.50, 'category' => 'skintos_geles', 'image' => 'baltos_tulpes.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'name' => 'Spalvotos gubojos', 'description' => '', 'price' => 1.00, 'category' => 'skintos_geles', 'image' => 'spalvotos_gubojos.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'name' => 'Baltos gubojos', 'description' => '', 'price' => 1.00, 'category' => 'skintos_geles', 'image' => 'baltos_gubojos.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'name' => 'Rožinių bijūninių rožių dėžutė', 'description' => 'Dėžutės dydis 150×150 mm, gėlių kiekis 11-15vnt.', 'price' => 60.00, 'category' => 'geles_dezuteje', 'image' => 'roziniu_bijuniniu_roziu_dezute.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'name' => 'Rausvų rožių dėžutė', 'description' => 'Dėžutės dydis 150×150 mm, gėlių kiekis 13-15vnt.', 'price' => 60.00, 'category' => 'geles_dezuteje', 'image' => 'rausvu_roziu_dezute.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'name' => 'Rausvų gvazdikų dėžutė', 'description' => 'Dėžutės dydis 150×150 mm, gėlių kiekis 17-19vnt.', 'price' => 45.00, 'category' => 'geles_dezuteje', 'image' => 'rausvu_gvazdiku_dezute.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'name' => 'Pastelinių gėlių dėžutė', 'description' => 'Kompoziciją sudaro: rožės, eustomos, krūminės rožės, frezijos, gvazdikai, žaluma. Dėžutės dydis 150×150 mm.', 'price' => 60.00, 'category' => 'geles_dezuteje', 'image' => 'pasteliniu_geliu_dezute.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'name' => 'Rausvų rožių ir eukalipto dėžutė', 'description' => 'Dėžutės dydis 150×150 mm, gėlių kiekis 13-15vnt.', 'price' => 62.00, 'category' => 'geles_dezuteje', 'image' => 'rausvu_roziu_ir_eukalipto_dezute.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
