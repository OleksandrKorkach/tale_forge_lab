<template>
    <button v-for="option in sortOptions" :key="option.value"
            :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedSort === option.value, 'bg-gray-200 hover:bg-gray-300': selectedSort !== option.value}"
            @click="changeSort(option.value)" class="w-full px-3 py-1.5 rounded-lg">
        {{ option.text }}
    </button>
</template>

<script>
export default {
    props: {
        sortOptions: Array,
        selectedSort: String
    },
    data() {
        return {
            sortOptions: [
                {value: '1', text: 'Top rated'},
                {value: '2', text: 'Top popular'},
                {value: '3', text: 'Top favorite'},
                {value: '4', text: 'Favorite %'},
                {value: '5', text: 'Latest'},
            ],
        }
    },
    methods: {
        changeSort(value) {
            this.$emit('sort-changed', value);
        }
    }
}
</script>
