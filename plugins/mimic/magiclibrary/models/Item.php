<?php namespace Mimic\MagicLibrary\Models;

use Model;

/**
 * Model
 */
class Item extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'mimic_magiclibrary_items';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Поля, разрешенные для массового заполнения
     */
    public $fillable = [
        'name',
        'slug',
        'type',
        'category_id',
        'description',
        'short_descrip',
        'magic_power',
        'mana_coast',
        'rarity',
        'image_url',
        'is_published'
    ];

    /**
     * @var array Связи модели
     */
    public $belongsTo = [
        'category' => ['Mimic\MagicLibrary\Models\Category', 'key' => 'category_id']
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
}
