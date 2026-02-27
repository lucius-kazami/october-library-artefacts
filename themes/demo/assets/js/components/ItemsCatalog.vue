<template>
    <div class="items-catalog">
        <!-- Заголовок и статистика -->
        <div class="catalog-header">
            <h2>📚 Каталог предметов</h2>
            <div class="stats">
                <span>Всего: {{ itemsCount }}</span>
                <span>Показано: {{ filteredCount }}</span>
            </div>
        </div>

        <!-- Фильтры -->
        <div class="filters-section">
            <div class="search-box">
                <input
                    type="text"
                    v-model="searchQuery"
                    placeholder="🔍 Поиск по названию..."
                    class="search-input"
                >
            </div>

            <div class="filter-controls">
                <select v-model="categoryFilter" class="filter-select">
                    <option value="">Все категории</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                        {{ cat.name }}
                    </option>
                </select>

                <select v-model="rarityFilter" class="filter-select">
                    <option value="">Все редкости</option>
                    <option value="common">Обычные</option>
                    <option value="rare">Редкие</option>
                    <option value="epic">Эпические</option>
                    <option value="legendary">Легендарные</option>
                </select>

                <button @click="resetFilters" class="reset-btn">Сбросить</button>
            </div>
        </div>

        <!-- Индикатор загрузки -->
        <div v-if="loading" class="loading">
            <div class="spinner"></div>
            <p>Загрузка предметов...</p>
        </div>

        <!-- Сообщение об ошибке -->
        <div v-else-if="error" class="error-message">
            ❌ {{ error }}
        </div>

        <!-- Сетка предметов -->
        <div v-else-if="filteredItems.length > 0" class="items-grid">
            <ItemCard
                v-for="item in filteredItems"
                :key="item.id"
                :item="item"
                :is-favorite="isFavorite(item)"
                :category-name="getCategoryName(item.category_id)"
                :hovered="hoveredItem === item.id"
                @hover="hoveredItem = item.id"
                @leave="hoveredItem = null"
                @toggle-favorite="toggleFavorite"
            />
        </div>

        <!-- Пустое состояние -->
        <div v-else class="empty-state">
            <span class="empty-emoji">🔮</span>
            <h3>Предметы не найдены</h3>
            <p>Попробуйте изменить параметры поиска</p>
        </div>
    </div>
</template>

<script>
import ItemCard from './ItemCard.vue';
import { useStore } from '../stores/itemStore.js';

export default {
    name: 'ItemsCatalog',
    components: {
        ItemCard
    },
    props: {
        categories: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            searchQuery: '',
            categoryFilter: '',
            rarityFilter: '',
            hoveredItem: null,
            favorites: JSON.parse(localStorage.getItem('magicFavorites') || '[]')
        };
    },
    computed: {
        filteredItems() {
            return this.items.filter(item => {
                const matchesSearch = !this.searchQuery ||
                    item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (item.description && item.description.toLowerCase().includes(this.searchQuery.toLowerCase()));

                const matchesCategory = !this.categoryFilter ||
                    item.category_id == this.categoryFilter;

                const matchesRarity = !this.rarityFilter ||
                    item.rarity === this.rarityFilter;

                return matchesSearch && matchesCategory && matchesRarity;
            });
        },

        items() {
            return this.$store.state.items;
        },

        loading() {
            return this.$store.state.loading;
        },

        error() {
            return this.$store.state.error;
        },

        itemsCount() {
            return this.items.length;
        },

        filteredCount() {
            return this.filteredItems.length;
        }
    },
    watch: {
        searchQuery: {
            handler() {
                this.$emit('filters-changed', {
                    search: this.searchQuery,
                    category: this.categoryFilter,
                    rarity: this.rarityFilter
                });
            }
        },
        categoryFilter: {
            handler() {
                this.$emit('filters-changed', {
                    search: this.searchQuery,
                    category: this.categoryFilter,
                    rarity: this.rarityFilter
                });
            }
        },
        rarityFilter: {
            handler() {
                this.$emit('filters-changed', {
                    search: this.searchQuery,
                    category: this.categoryFilter,
                    rarity: this.rarityFilter
                });
            }
        }
    },
    methods: {
        getCategoryName(categoryId) {
            const category = this.categories.find(c => c.id === categoryId);
            return category ? category.name : 'Без категории';
        },

        isFavorite(item) {
            return this.favorites.some(fav => fav.id === item.id);
        },

        toggleFavorite(item) {
            const index = this.favorites.findIndex(fav => fav.id === item.id);

            if (index === -1) {
                this.favorites.push(item);
            } else {
                this.favorites.splice(index, 1);
            }

            localStorage.setItem('magicFavorites', JSON.stringify(this.favorites));
        },

        resetFilters() {
            this.searchQuery = '';
            this.categoryFilter = '';
            this.rarityFilter = '';
        }
    }
};
</script>

<style scoped>
.items-catalog {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.catalog-header h2 {
    color: #8b4513;
    margin: 0;
    font-size: 28px;
}

.stats {
    display: flex;
    gap: 15px;
    color: #666;
    font-size: 14px;
    background: #f5f0eb;
    padding: 8px 15px;
    border-radius: 20px;
}

.filters-section {
    background: #f5f0eb;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.search-box {
    margin-bottom: 15px;
}

.search-input {
    width: 100%;
    padding: 12px 20px;
    border: 2px solid #d4c4b6;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #8b4513;
    box-shadow: 0 0 10px rgba(139, 69, 19, 0.1);
}

.filter-controls {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-select {
    flex: 1;
    min-width: 150px;
    padding: 10px 15px;
    border: 2px solid #d4c4b6;
    border-radius: 25px;
    font-size: 14px;
    background: white;
}

.reset-btn {
    padding: 10px 20px;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.reset-btn:hover {
    background: #c0392b;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.loading {
    text-align: center;
    padding: 60px;
}

.spinner {
    border: 4px solid #f5f0eb;
    border-top: 4px solid #8b4513;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.empty-state {
    text-align: center;
    padding: 60px;
    color: #999;
}

.empty-emoji {
    font-size: 64px;
    display: block;
    margin-bottom: 20px;
    opacity: 0.5;
}

.error-message {
    text-align: center;
    padding: 40px;
    color: #e74c3c;
    background: #fdf0ed;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .catalog-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .filter-controls {
        flex-direction: column;
    }

    .filter-select,
    .reset-btn {
        width: 100%;
    }
}
</style>
