<template>
    <div>
        <span v-for="star in 10" :key="star"
              class="star"
              :class="{ 'selected': (hoverRating >= star || (!hoverRating && rating >= star)) }"
              @click="setRating(star)"
              @mouseenter="hoverRating = star"
              @mouseleave="hoverRating = 0">
          ★
        </span>
    </div>
</template>

<script>
export default {
    props: {
        initialRating: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            rating: this.initialRating,
            hoverRating: 0
        };
    },
    methods: {
        setRating(newRating) {
            this.rating = newRating;
            this.$emit('rating-selected', newRating);
            this.hoverRating = 0;
        }
    }
}
</script>

<style scoped>
.star {
    cursor: pointer;
    font-size: 20px;
    color: grey;
}
.selected {
    color: gold;
}
</style>
