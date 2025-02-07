<?php

use Database\Seeders\FolioesSeeder;
use Database\Seeders\LogsEntregasSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            FolioesSeeder::class,
            LogsEntregasSeeder::class,
        ]);
    }
}

