<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSpokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('language_spoken')->insert([
        [
            "description" => "Albanian"
          ],[
            "description" => "American Sign Language"
          ],[
            "description" => "Arabic"
          ],[
            "description" => "Armenian"
          ],[
            "description" => "Azerbaijaini"
          ],[
            "description" => "Belarusian"
          ],[
            "description" => "Bengali"
          ],[
            "description" => "Bulagarian"
          ],[
            "description" => "Burmese"
          ],[
            "description" => "Cantonese"
          ],[
            "description" => "Croatian"
          ],[
            "description" => "Czech"
          ],[
            "description" => "Dannish"
          ],[
            "description" => "Dutch"
          ],[
            "description" => "English"
          ],[
            "description" => "Finnish"
          ],[
            "description" => "French"
          ],[
            "description" => "German"
          ],[
            "description" => "Greek"
          ],[
            "description" => "Gujarati"
          ],[
            "description" => "Hakka"
          ],[
            "description" => "Hebrew"
          ],[
            "description" => "Hindi"
          ],[
            "description" => "Hungarian"
          ],[
            "description" => "Italian"
          ],[
            "description" => "Japanese"
          ],[
            "description" => "Javanese"
          ],[
            "description" => "Kannada"
          ],[
            "description" => "Kazakh"
          ],[
            "description" => "Korean"
          ],[
            "description" => "Malayalam"
          ],[
            "description" => "Mandarin"
          ],[
            "description" => "Marathi"
          ],[
            "description" => "Oriya"
          ],[
            "description" => "Persian"
          ],[
            "description" => "Polish"
          ],[
            "description" => "Portuguese"
          ],[
            "description" => "Punjabi"
          ],[
            "description" => "Romanian"
          ],[
            "description" => "Russian"
          ],[
            "description" => "Serbo-Croatian"
          ],[
            "description" => "Slovak"
          ],[
            "description" => "Spanish"
          ],[
            "description" => "Swedish"
          ],[
            "description" => "Tamil"
          ],[
            "description" => "Telugu"
          ],[
            "description" => "Thai"
          ],[
            "description" => "Turkish"
          ],[
            "description" => "Ukrainian"
          ],[
            "description" => "Urdu"
          ],[
            "description" => "Vietnamese"
          ],[
            "description" => "Wu"
          ],[
            "description" => "Xiang"
          ]
          ]);
    }
}
