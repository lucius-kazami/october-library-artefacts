<?php namespace Mimic\MagicLibrary\Updates\Seeder;

use Seeder;
use Mimic\MagicLibrary\Models\Category;
use Mimic\MagicLibrary\Models\Item;
use DB;

class MagicLibrarySeeder extends Seeder
{
    public function run()
    {
        // =========================================
        // 1. ОЧИЩАЕМ ТАБЛИЦЫ
        // =========================================
        echo "Очищаю старые данные...\n";

        // Отключаем проверку внешних ключей для PostgreSQL
        DB::statement('SET session_replication_role = replica;');

        // Очищаем таблицы (truncate сам сбросит последовательности)
        DB::table('mimic_magiclibrary_items')->truncate();
        DB::table('mimic_magiclibrary_category')->truncate();

        // Включаем обратно проверку внешних ключей
        DB::statement('SET session_replication_role = DEFAULT;');

        // =========================================
        // 2. СОЗДАЕМ КАТЕГОРИИ
        // =========================================

        $categories = [
            [
                'name' => 'Стихия огня',
                'slug' => 'fire-magic',
                'description' => 'Свитки и артефакты, связанные с огнём, пламенем и жаром',
                'icon' => '🔥',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Стихия воды',
                'slug' => 'water-magic',
                'description' => 'Свитки воды, льда, исцеления и очищения',
                'icon' => '💧',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Стихия ветра',
                'slug' => 'air-magic',
                'description' => 'Свитки ветра, молний, скорости и невидимости',
                'icon' => '🌪️',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Стихия земли',
                'slug' => 'earth-magic',
                'description' => 'Свитки камня, металла, природы и защиты',
                'icon' => '🪨',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Стихия света',
                'slug' => 'light-magic',
                'description' => 'Целительные свитки, защита и благословения',
                'icon' => '✨',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Стихия тьмы',
                'slug' => 'dark-magic',
                'description' => 'Запретные свитки, проклятия и некромантия',
                'icon' => '🌑',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        echo "Создаю категории...\n";
        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            $createdCategories[$category->slug] = $category;
            echo "  + {$category->name}\n";
        }

        // =========================================
        // 3. СОЗДАЕМ ПРЕДМЕТЫ И ЗАКЛИНАНИЯ
        // =========================================

        $items = [
            // Огненная магия
            [
                'name' => 'Огненный шар',
                'slug' => 'fireball',
                'type' => 'spell',
                'category_id' => $createdCategories['fire-magic']->id,
                'description' => 'Запускает шар огня во врага, нанося урон по площади',
                'short_descrip' => 'Мощное огненное заклинание',
                'magic_power' => 50,
                'mana_coast' => 30,
                'rarity' => 'common',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Огненный щит',
                'slug' => 'fire-shield',
                'type' => 'spell',
                'category_id' => $createdCategories['fire-magic']->id,
                'description' => 'Создаёт щит из пламени, сжигающий атакующих',
                'short_descrip' => 'Защитное заклинание',
                'magic_power' => 30,
                'mana_coast' => 25,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Кольцо огня',
                'slug' => 'ring-of-fire',
                'type' => 'item',
                'category_id' => $createdCategories['fire-magic']->id,
                'description' => 'Кольцо, усиливающее огненные заклинания',
                'short_descrip' => 'Магический артефакт',
                'magic_power' => 20,
                'mana_coast' => 0,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Водная магия
            [
                'name' => 'Исцеляющий дождь',
                'slug' => 'healing-rain',
                'type' => 'spell',
                'category_id' => $createdCategories['water-magic']->id,
                'description' => 'Призывает целебный дождь, восстанавливающий здоровье',
                'short_descrip' => 'Целительное заклинание',
                'magic_power' => 40,
                'mana_coast' => 35,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ледяная стрела',
                'slug' => 'ice-arrow',
                'type' => 'spell',
                'category_id' => $createdCategories['water-magic']->id,
                'description' => 'Выпускает стрелу из льда, замораживающую цель',
                'short_descrip' => 'Атакующее заклинание',
                'magic_power' => 45,
                'mana_coast' => 25,
                'rarity' => 'common',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Амулет русалки',
                'slug' => 'mermaid-amulet',
                'type' => 'item',
                'category_id' => $createdCategories['water-magic']->id,
                'description' => 'Позволяет дышать под водой и говорить с морскими обитателями',
                'short_descrip' => 'Древний артефакт',
                'magic_power' => 15,
                'mana_coast' => 0,
                'rarity' => 'legendary',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Воздушная магия
            [
                'name' => 'Молния',
                'slug' => 'lightning',
                'type' => 'spell',
                'category_id' => $createdCategories['air-magic']->id,
                'description' => 'Призывает удар молнии на врага',
                'short_descrip' => 'Мощное заклинание',
                'magic_power' => 60,
                'mana_coast' => 40,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Невидимость',
                'slug' => 'invisibility',
                'type' => 'spell',
                'category_id' => $createdCategories['air-magic']->id,
                'description' => 'Делает цель невидимой на короткое время',
                'short_descrip' => 'Скрытность',
                'magic_power' => 35,
                'mana_coast' => 30,
                'rarity' => 'epic',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Сапоги ветра',
                'slug' => 'wind-boots',
                'type' => 'item',
                'category_id' => $createdCategories['air-magic']->id,
                'description' => 'Увеличивают скорость передвижения',
                'short_descrip' => 'Магическая обувь',
                'magic_power' => 10,
                'mana_coast' => 0,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Земляная магия
            [
                'name' => 'Каменная кожа',
                'slug' => 'stone-skin',
                'type' => 'spell',
                'category_id' => $createdCategories['earth-magic']->id,
                'description' => 'Превращает кожу в камень, сильно повышая защиту',
                'short_descrip' => 'Защитное заклинание',
                'magic_power' => 40,
                'mana_coast' => 25,
                'rarity' => 'common',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Землетрясение',
                'slug' => 'earthquake',
                'type' => 'spell',
                'category_id' => $createdCategories['earth-magic']->id,
                'description' => 'Вызывает мощное землетрясение',
                'short_descrip' => 'Разрушительное заклинание',
                'magic_power' => 70,
                'mana_coast' => 50,
                'rarity' => 'epic',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Амулет плодородия',
                'slug' => 'fertility-amulet',
                'type' => 'item',
                'category_id' => $createdCategories['earth-magic']->id,
                'description' => 'Ускоряет рост растений',
                'short_descrip' => 'Древний амулет',
                'magic_power' => 5,
                'mana_coast' => 0,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Светлая магия
            [
                'name' => 'Великое исцеление',
                'slug' => 'greater-healing',
                'type' => 'spell',
                'category_id' => $createdCategories['light-magic']->id,
                'description' => 'Мощное заклинание исцеления',
                'short_descrip' => 'Лечит все раны',
                'magic_power' => 50,
                'mana_coast' => 40,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Благословение',
                'slug' => 'blessing',
                'type' => 'spell',
                'category_id' => $createdCategories['light-magic']->id,
                'description' => 'Повышает удачу и защиту цели',
                'short_descrip' => 'Божественная поддержка',
                'magic_power' => 25,
                'mana_coast' => 20,
                'rarity' => 'common',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Посох света',
                'slug' => 'staff-of-light',
                'type' => 'item',
                'category_id' => $createdCategories['light-magic']->id,
                'description' => 'Освещает тьму и отпугивает нежить',
                'short_descrip' => 'Священный артефакт',
                'magic_power' => 30,
                'mana_coast' => 5,
                'rarity' => 'legendary',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Тёмная магия
            [
                'name' => 'Проклятие',
                'slug' => 'curse',
                'type' => 'spell',
                'category_id' => $createdCategories['dark-magic']->id,
                'description' => 'Накладывает проклятие на врага, снижая его характеристики',
                'short_descrip' => 'Чёрная магия',
                'magic_power' => 40,
                'mana_coast' => 30,
                'rarity' => 'rare',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Призыв скелета',
                'slug' => 'summon-skeleton',
                'type' => 'spell',
                'category_id' => $createdCategories['dark-magic']->id,
                'description' => 'Призывает скелета-воина на помощь',
                'short_descrip' => 'Некромантия',
                'magic_power' => 35,
                'mana_coast' => 45,
                'rarity' => 'epic',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Книга мёртвых',
                'slug' => 'book-of-dead',
                'type' => 'item',
                'category_id' => $createdCategories['dark-magic']->id,
                'description' => 'Древняя книга с запретными знаниями',
                'short_descrip' => 'Запретный артефакт',
                'magic_power' => 80,
                'mana_coast' => 20,
                'rarity' => 'legendary',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        echo "Создаю предметы и заклинания...\n";
        foreach ($items as $itemData) {
            $item = Item::create($itemData);
            echo "  + {$item->name} [{$item->type}]\n";
        }

        echo "\n✅ Готово! Создано категорий: " . Category::count() . ", предметов: " . Item::count() . "\n";
    }
}
