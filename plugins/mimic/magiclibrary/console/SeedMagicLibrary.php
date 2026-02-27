<?php namespace Mimic\MagicLibrary\Console;

use Illuminate\Console\Command;
use Mimic\MagicLibrary\Updates\Seeder\MagicLibrarySeeder;

class SeedMagicLibrary extends Command
{
    protected $name = 'magiclibrary:seed';
    protected $description = 'Заполняет магическую библиотеку тестовыми данными';

    public function handle()
    {
        $this->info('Начинаю заполнение магической библиотеки...');

        $seeder = new MagicLibrarySeeder();
        $seeder->run();

        $this->info('Заполнение завершено!');
    }
}
