<?php

Route::prefix('api')->group(function () {
    // Добавить новый предмет
    Route::post('/magic-items', function () {
        $data = request()->all();

        // Создаем новый предмет
        $item = new Mimic\MagicLibrary\Models\Item();
        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->slug = $data['slug'] ?? str_slug($data['name']);
        $item->type = $data['type'];
        $item->rarity = $data['rarity'];
        $item->magic_power = $data['magic_power'] ?? 0;
        $item->mana_coast = $data['mana_coast'] ?? 0;
        $item->category_id = $data['category_id'];
        $item->is_published = true;
        $item->save();

        // Добавляем путь к изображению (если есть)
        if ($item->image) {
            $item->image = $item->image->getPath();
        }

        return response()->json($item, 201);
    });

    // Получить все предметы
    Route::get('/magic-items', function () {
        $items = Mimic\MagicLibrary\Models\Item::with('category')->get();
        return response()->json($items);
    });
});
