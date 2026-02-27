<?php namespace Mimic\MagicLibrary\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMimicMagiclibraryCategory extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('mimic_magiclibrary_category')) {
            Schema::create('mimic_magiclibrary_category', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('mimic_magiclibrary_category');
    }
}
