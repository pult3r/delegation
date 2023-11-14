<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CountryRate;
use File;

class CountryRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CountryRate::truncate();

        $json = File::get("storage/dbdata/countryrate.json");
        
        $countryRate = json_decode($json);

        foreach ($countryRate as $key => $value) {
            CountryRate::create([
                "countrycode" => $value->countrycode,
                "price" => $value->price,
                "currency" => $value->currency
            ]);
        }
    }
}
