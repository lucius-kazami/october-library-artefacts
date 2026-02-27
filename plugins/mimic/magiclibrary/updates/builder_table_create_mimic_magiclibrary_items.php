<?php namespace Mimic\MagicLibrary\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMimicMagiclibraryItems extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('mimic_magiclibrary_items')) {
            Schema::create('mimic_magiclibrary_items', function($table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('type')->default('item');
                $table->integer('category_id')->unsigned();
                $table->text('description')->nullable();
                $table->string('short_descrip')->nullable();
                $table->integer('magic_power')->default(0);
                $table->integer('mana_coast')->default(0);
                $table->string('rarity')->default('common');
                $table->string('image')->nullable();
                $table->boolean('is_published')->default(true);
                $table->timestamps();

                $table->foreign('category_id')
                    ->references('id')
                    ->on('mimic_magiclibrary_category')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('mimic_magiclibrary_items');
    }
}
