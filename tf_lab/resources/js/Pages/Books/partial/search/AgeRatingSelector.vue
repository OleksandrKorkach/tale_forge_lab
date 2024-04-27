<template>
    <select v-model="selectedAgeRating" @change="emitAgeRating"
            class="pl-3 pr-8 py-2 rounded-lg w-full">
        <option value="">All ages</option>
        <option v-for="ageRating in allAgeRatings" :key="ageRating" :value="ageRating">
            {{ ageRating }}
        </option>
    </select>
</template>

<script>
export default {
    props: {
        allAgeRatings: Array
    },
    data() {
        return {
            selectedAgeRating: ''
        };
    },
    methods: {
        emitAgeRating() {
            this.$emit('age-rating-changed', this.selectedAgeRating);
        }
    }
}
</script>
