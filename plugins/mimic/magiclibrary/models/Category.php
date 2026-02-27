<?php namespace Mimic\MagicLibrary\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'mimic_magiclibrary_category';

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
        'description',
        'icon'
    ];

    /**
     * @var array Связи модели
     */
    public $hasMany = [
        'items' => ['Mimic\MagicLibrary\Models\Item', 'key' => 'category_id']
    ];
}
