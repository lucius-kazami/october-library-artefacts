import { reactive, readonly } from 'vue';

// Состояние приложения
const state = reactive({
    items: [],
    categories: [],
    filters: {
        search: '',
        category: '',
        rarity: ''
    },
    loading: false,
    error: null,
    socket: null
});

// Мутации (изменения состояния)
const mutations = {
    setItems(items) {
        state.items = items;
    },

    addItem(item) {
        state.items.unshift(item); // Добавляем в начало массива
    },

    updateItem(updatedItem) {
        const index = state.items.findIndex(item => item.id === updatedItem.id);
        if (index !== -1) {
            state.items[index] = updatedItem;
        }
    },

    removeItem(itemId) {
        state.items = state.items.filter(item => item.id !== itemId);
    },

    setCategories(categories) {
        state.categories = categories;
    },

    setFilter(filterType, value) {
        state.filters[filterType] = value;
    },

    setLoading(status) {
        state.loading = status;
    },

    setError(error) {
        state.error = error;
    }
};

// Действия (асинхронные операции)
const actions = {
    // Загрузка данных с сервера
    async fetchItems() {
        mutations.setLoading(true);
        try {
            const response = await fetch('/api/magic-items');
            const data = await response.json();
            mutations.setItems(data);
            mutations.setError(null);
        } catch (error) {
            mutations.setError('Ошибка загрузки предметов');
            console.error('Error fetching items:', error);
        } finally {
            mutations.setLoading(false);
        }
    },

    async fetchCategories() {
        try {
            const response = await fetch('/api/magic-categories');
            const data = await response.json();
            mutations.setCategories(data);
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    },

    // Добавление нового предмета
    async addItem(itemData) {
        mutations.setLoading(true);
        try {
            const response = await fetch('/api/magic-items', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(itemData)
            });

            const newItem = await response.json();
            mutations.addItem(newItem);
            mutations.setError(null);
            return newItem;
        } catch (error) {
            mutations.setError('Ошибка при добавлении предмета');
            console.error('Error adding item:', error);
        } finally {
            mutations.setLoading(false);
        }
    },

    // WebSocket подключение для реального времени
    initWebSocket() {
        // Для простоты используем polling (опрос сервера каждые 5 секунд)
        setInterval(async () => {
            await this.fetchItems();
        }, 5000);

        // В будущем можно заменить на реальный WebSocket:
        // state.socket = new WebSocket('ws://your-server/ws');
        // state.socket.onmessage = (event) => {
        //     const data = JSON.parse(event.data);
        //     if (data.type === 'new_item') {
        //         mutations.addItem(data.item);
        //     }
        // };
    }
};

// Вычисляемые значения (геттеры)
const getters = {
    filteredItems() {
        return state.items.filter(item => {
            const matchesSearch = !state.filters.search ||
                item.name.toLowerCase().includes(state.filters.search.toLowerCase()) ||
                (item.description && item.description.toLowerCase().includes(state.filters.search.toLowerCase()));

            const matchesCategory = !state.filters.category ||
                item.category_id == state.filters.category;

            const matchesRarity = !state.filters.rarity ||
                item.rarity === state.filters.rarity;

            return matchesSearch && matchesCategory && matchesRarity;
        });
    },

    getCategoryName(categoryId) {
        const category = state.categories.find(c => c.id === categoryId);
        return category ? category.name : 'Без категории';
    },

    itemsCount() {
        return state.items.length;
    },

    filteredCount() {
        return this.filteredItems.length;
    }
};

// Экспортируем store
export default {
    state: readonly(state),
    mutations,
    actions,
    getters
};
