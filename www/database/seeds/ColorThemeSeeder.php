<?php

use Illuminate\Database\Seeder;

class ColorThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            [
                'name' => 'air',
                'value' => 'theme-air',
                'href' => 'theme-air.css',
                'href_material' => 'theme-air-material.css',
                'colors' => [
                        '#3c97fe', '#f8f8f8', '#f8f8f8'
                    ]
            ],[
                'name' => 'corporate',
                'value' => 'theme-corporate',
                'href' => 'theme-corporate.css',
                'href_material' => 'theme-corporate-material.css',
                'colors' => [
                        '#26B4FF', '#fff', '#2e323a'
                    ]
            ],[
                'name' => 'cotton',
                'value' => 'theme-cotton',
                'href' => 'theme-cotton.css',
                'href_material' => 'theme-cotton-material.css',
                'colors' => [
                        '#e84c64', '#ffffff', '#ffffff'
                    ]
            ],[
                'name' => 'gradient',
                'value' => 'theme-gradient',
                'href' => 'theme-gradient.css',
                'href_material' => 'theme-gradient-material.css',
                'colors' => [
                        '#775cdc', '#ffffff', 'linear-gradient(to top, #4e54c8, #8c55e4)'
                    ]
            ],[
                'name' => 'paper',
                'value' => 'theme-paper',
                'href' => 'theme-paper.css',
                'href_material' => 'theme-paper-material.css',
                'colors' => [
                        '#17b3a3', '#ffffff', '#ffffff'
                    ]
            ],[
                'name' => 'shadow',
                'value' => 'theme-shadow',
                'href' => 'theme-shadow.css',
                'href_material' => 'theme-shadow-material.css',
                'colors' => [
                        '#7b83ff', '#f8f8f8', '#ececf9'
                    ]
            ],[
                'name' => 'soft',
                'value' => 'theme-soft',
                'href' => 'theme-soft',
                'href_material' => 'theme-soft-material.css',
                'colors' => [
                        '#1cbb84', '#39517b', '#ffffff'
                    ]
            ],[
                'name' => 'sunrise',
                'value' => 'theme-sunrise',
                'href' => 'theme-sunrise.css',
                'href_material' => 'theme-sunrise-material.css',
                'colors' => [
                        '#fc5a5c', '#222222', '#ffffff'
                    ]
            ],[
                'name' => 'twilight',
                'value' => 'theme-twilight',
                'href' => 'theme-twilight.css',
                'href_material' => 'theme-twilight-material.css',
                'colors' => [
                        '#4c84ff', '#343c44', '#3f4853'
                    ]
            ],[
                'name' => 'vibrant',
                'value' => 'theme-vibrant',
                'href' => 'theme-vibrant.css',
                'href_material' => 'theme-vibrant-material.css',
                'colors' => [
                        '#fc5a5c', '#f8f8f8', '#222222'
                    ]
            ]
        ];

        for($i = 0; $i < count($options); $i++) {
            $options[$i]['colors'] = json_encode($options[$i]['colors']);
            \App\ColorTheme::create($options[$i]);
        }

    }
}
