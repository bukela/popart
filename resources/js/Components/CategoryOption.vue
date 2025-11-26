<script setup>
defineProps({
    category: {
        type: Object,
        required: true,
    },
    level: {
        type: Number,
        default: 0,
    },
});

const getIndent = (level) => {
    return '\u00A0\u00A0'.repeat(level) + (level > 0 ? '→ ' : '');
};

const getChildren = (category) => {
    return category.children_recursive || category.childrenRecursive || [];
};
</script>

<template>
    <option :value="category.id">
        {{ getIndent(level) }}{{ category.name }}
    </option>
    <template v-if="getChildren(category).length > 0">
        <CategoryOption
            v-for="child in getChildren(category)"
            :key="child.id"
            :category="child"
            :level="level + 1"
        />
    </template>
</template>
