<?php namespace Mimic\MagicLibrary\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class RenameImageColumnInItemsTable extends Migration
{
    public function up()
    {
        // Проверяем, существует ли колонка 'image'
        if (Schema::hasColumn('mimic_magiclibrary_items', 'image')) {
            Schema::table('mimic_magiclibrary_items', function($table)
            {
                // Переименовываем image в image_url
                $table->renameColumn('image', 'image_url');
            });
        }
    }

    public function down()
    {
        // Проверяем, существует ли колонка 'image_url'
        if (Schema::hasColumn('mimic_magiclibrary_items', 'image_url')) {
            Schema::table('mimic_magiclibrary_items', function($table)
            {
                // Возвращаем обратно
                $table->renameColumn('image_url', 'image');
            });
        }
    }
}
