<script setup>

import FavoriteMembers from "@/Components/BookStat/FavoriteMembers.vue";
import Members from "@/Components/BookStat/Members.vue";
import CommunityRating from "@/Components/BookStat/CommunityRating.vue";
</script>

<template>
    <div class="relative text-xl gap-1 justify-between flex px-1">
        <div v-if="$page.props.auth.user" id="ratingStars" class="absolute mt-6 ml-6 hidden flex items-center bg-white border-2 border-black rounded px-2 py-1 gap-2">
            <button v-if="rating.value" @click="deleteRating" class="bg-red-500 w-[18px] h-[18px] rounded-2xl flex items-center justify-center text-white text-[14px]">x</button>
            <div class="items-center flex">
                <RatingStars :initial-rating="initialRating" @rating-selected="submitRating"/>
            </div>
        </div>
        <button v-if="$page.props.auth.user" @click="showRatingStars" class="relative text-blue-500 flex gap-0.5 items-center ">
            <div class="font-semibold ">{{rating.value ? rating.value : 'Rate '}}</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                star
            </div>
        </button>

        <CommunityRating :book="book" />
        <Members :book="book" />
        <FavoriteMembers :book="book" />
    </div>
</template>

<script>
import RatingStars from "@/Components/RatingStars.vue";

export default {
    components: {
        RatingStars
    },
    props: {
        book: Object,
        initialRating: Number,
        rating: Object,
    },
    mounted() {
        window.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
        window.removeEventListener('click', this.handleClickOutside);
    },
    methods: {
        submitRating(rating) {
            this.$inertia.post(`/ratings/${this.book.id}`, {
                value: rating
            }, {
                preserveScroll: true
            });
            const ratingStars = document.getElementById('ratingStars');
            ratingStars.classList.add('hidden');
        },
        deleteRating() {
            this.$inertia.delete(`/ratings/${this.book.id}`, {
                preserveScroll: true
            });
            const ratingStars = document.getElementById('ratingStars');
            ratingStars.classList.add('hidden');
        },
        showRatingStars() {
            const ratingStars = document.getElementById('ratingStars');
            ratingStars.classList.remove('hidden');
        },
        handleClickOutside(event) {
            const ratingStars = document.getElementById('ratingStars');
            if (event.target.contains(ratingStars)) {
                this.closeRatingStars();
            }
        },
        closeRatingStars() {
            const ratingStars = document.getElementById('ratingStars');
            ratingStars.classList.add('hidden');
        },

    }
}
</script>

