<template>
    <div class="magic-card" @mouseenter="$emit('hover', item)" @mouseleave="$emit('leave')">
        <div class="card-image">
            <img v-if="item.image" :src="item.image" :alt="item.name">
            <div v-else class="no-image">
                <span class="image-emoji">{{ item.type === 'spell' ? '✨' : '📦' }}</span>
            </div>
        </div>

        <div class="card-content">
            <div class="item-header">
                <h3 class="item-title">{{ item.name }}</h3>
                <button @click.stop="$emit('toggle-favorite', item)" class="favorite-btn" :class="{ active: isFavorite }">
                    {{ isFavorite ? '⭐' : '☆' }}
                </button>
            </div>

            <div class="item-badges">
                <span class="badge" :class="item.type">
                    {{ item.type === 'spell' ? '✨ Заклинание' : '📦 Предмет' }}
                </span>
                <span class="badge rarity" :class="item.rarity">
                    {{ capitalizeFirst(item.rarity) }}
                </span>
            </div>

            <div class="item-stats">
                <span class="stat">
                    <span class="stat-icon">⚡</span>
                    <span class="stat-value">{{ item.magic_power || 0 }}</span>
                </span>
                <span v-if="item.mana_cost > 0" class="stat">
                    <span class="stat-icon">💧</span>
                    <span class="stat-value">{{ item.mana_cost }}</span>
                </span>
            </div>

            <p class="item-desc">{{ truncateText(item.description, 100) }}</p>

            <div class="item-footer">
                <span class="category-tag">{{ categoryName }}</span>
                <a :href="'/magic-item/' + item.slug" class="btn-detail">Подробнее →</a>
            </div>
        </div>

        <!-- Быстрый просмотр при наведении -->
        <div v-if="hovered" class="quick-view">
            <h4>Быстрый просмотр</h4>
            <p>{{ item.description }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ItemCard',
    props: {
        item: {
            type: Object,
            required: true
        },
        isFavorite: {
            type: Boolean,
            default: false
        },
        categoryName: {
            type: String,
            default: 'Без категории'
        },
        hovered: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        capitalizeFirst(string) {
            if (!string) return '';
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        truncateText(text, length) {
            if (!text) return 'Нет описания';
            return text.length > length ? text.substring(0, length) + '...' : text;
        }
    }
};
</script>

<style scoped>
.magic-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid #e0d5cb;
    display: flex;
    flex-direction: column;
    position: relative;
    height: 100%;
}

.magic-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(139, 69, 19, 0.15);
}

.card-image {
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, #f5efe9 0%, #e8dfd5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.magic-card:hover .card-image img {
    transform: scale(1.05);
}

.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.image-emoji {
    font-size: 64px;
    opacity: 0.5;
}

.card-content {
    padding: 16px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.item-title {
    font-size: 18px;
    color: #2c1810;
    margin: 0;
    font-weight: 600;
}

.favorite-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    transition: transform 0.2s;
    color: #c0a080;
}

.favorite-btn:hover {
    transform: scale(1.2);
}

.favorite-btn.active {
    color: gold;
}

.item-badges {
    display: flex;
    gap: 6px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.badge {
    padding: 4px 8px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
    color: white;
}

.badge.spell { background: #9b59b6; }
.badge.item { background: #3498db; }
.badge.rarity.common { background: #95a5a6; }
.badge.rarity.rare { background: #f39c12; }
.badge.rarity.epic { background: #9b59b6; }
.badge.rarity.legendary { background: #e67e22; }

.item-stats {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.stat {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f5f0eb;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 13px;
}

.stat-icon { font-size: 14px; }
.stat-value { font-weight: bold; color: #8b4513; }

.item-desc {
    color: #666;
    font-size: 13px;
    line-height: 1.5;
    margin: 0 0 12px 0;
    flex-grow: 1;
}

.item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.category-tag {
    font-size: 12px;
    color: #8b4513;
    font-style: italic;
}

.btn-detail {
    padding: 6px 12px;
    background: #8b4513;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 12px;
    transition: all 0.2s;
}

.btn-detail:hover {
    background: #6b3410;
}

.quick-view {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.9);
    color: white;
    padding: 12px;
    transform: translateY(100%);
    transition: transform 0.3s;
    font-size: 13px;
}

.magic-card:hover .quick-view {
    transform: translateY(0);
}
</style>
