<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Hardware, Template};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            array('denomination'=>'ALMACENAMIENTO', 'icon'=>'<i class="fa-solid fa-hard-drive"></i>'), 
            array('denomination'=>'SISTEMA OPERATIVO', 'icon'=>'<i class="fa-brands fa-windows"></i>'),  
            array('denomination'=>'MONITOR', 'icon' => '<i class="fa-solid fa-display"></i>'),  
            array('denomination'=>'CPU', 'icon' => '<i class="fa-solid fa-microchip"></i>'),  
            array('denomination'=>'UPS', 'icon' => '<i class="fa-solid fa-battery-three-quarters"></i>'),  
            array('denomination'=>'MEMORIA', 'icon' => '<i class="fa-solid fa-memory"></i>'),  
            array('denomination'=>'ANTIVIRUS', 'icon' => '<i class="fa-solid fa-file-shield"></i>'),  
            array('denomination'=>'APLICACIÓN', 'icon' => '<i class="fa-brands fa-uncharted"></i>'),  			
            array('denomination'=>'CONECTIVIDAD', 'icon' => '<i class="fa-solid fa-network-wired"></i>'),  			
            array('denomination'=>'IMPRESORA', 'icon' => '<i class="fa-solid fa-network-wired"></i>'), 
        );
        Hardware::insert($data);
        User::insert(['username' => 'admin', 'is_admin' => 1, 'enabled' => 1, 'email' => 'admin@pcassi.com.ar', 'password' => '$2y$10$TrLvj6no.ctQFCn.A/nv6uCkYsPkYQhySjXz7cEWJstB7r61teqI2']);
        $data = array(
            array('filename'=>'templates.microsoft', 'name'=>'Microsoft Credenciales', 'enabled' => 1), 
            array('filename'=>'templates.brahma', 'name'=>'Brahma', 'enabled' => 1), 
        );
        Template::insert($data);
    }
}
