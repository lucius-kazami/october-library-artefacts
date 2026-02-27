<?php
// Правильная загрузка October CMS
require __DIR__ . '/bootstrap/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$kernel->handle(
    Illuminate\Http\Request::capture()
);

use Mimic\MagicLibrary\Models\Category;
use Mimic\MagicLibrary\Models\Item;

echo "🔍 НАЧИНАЕМ УДАЛЕНИЕ ДУБЛИКАТОВ\n";
echo "==============================\n\n";

// 1. Удаляем дубликаты категорий
echo "1. КАТЕГОРИИ:\n";
$categories = Category::all();
echo "   Всего категорий сейчас: " . $categories->count() . "\n";

$uniqueNames = [];
$duplicatesRemoved = 0;

foreach ($categories as $category) {
    $name = trim($category->name);
    if (!isset($uniqueNames[$name])) {
        $uniqueNames[$name] = $category->id;
    } else {
        // Это дубликат - удаляем
        $category->delete();
        $duplicatesRemoved++;
        echo "   ❌ Удален дубликат: {$category->name} (ID: {$category->id})\n";
    }
}

echo "   ✅ Удалено дубликатов категорий: {$duplicatesRemoved}\n\n";

// 2. Проверяем результат
$remainingCategories = Category::all();
echo "   Осталось категорий: " . $remainingCategories->count() . "\n";
foreach ($remainingCategories as $cat) {
    echo "   - {$cat->name} (ID: {$cat->id})\n";
}
echo "\n";

// 3. Исправляем ссылки в предметах
echo "2. ПРОВЕРКА ПРЕДМЕТОВ:\n";
$items = Item::all();
echo "   Всего предметов: " . $items->count() . "\n";

// Создаем карту правильных ID категорий
$categoryMap = [];
foreach ($remainingCategories as $category) {
    $categoryMap[$category->name] = $category->id;
}

$fixedItems = 0;
foreach ($items as $item) {
    if ($item->category) {
        $correctId = $categoryMap[$item->category->name] ?? null;

        if ($correctId && $item->category_id != $correctId) {
            $oldId = $item->category_id;
            $item->category_id = $correctId;
            $item->save();
            $fixedItems++;
            echo "   🔧 Исправлен предмет '{$item->name}': категория ID {$oldId} → {$correctId}\n";
        }
    }
}

echo "   ✅ Исправлено предметов: {$fixedItems}\n\n";

echo "3. ИТОГ:\n";
echo "   Категорий: " . Category::count() . "\n";
echo "   Предметов: " . Item::count() . "\n";
