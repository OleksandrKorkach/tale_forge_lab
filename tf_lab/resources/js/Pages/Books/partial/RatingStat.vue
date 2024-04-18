<script setup>

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
        <div class="text-yellow-500 gap-0.5 flex items-center ">
            <div class="font-semibold">{{book.community_rating}}</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                star
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div class="font-semibold">{{ book.members }}</div>
            <div class="material-symbols-outlined text-3xl">
                groups
            </div>
        </div>
        <div class="flex items-center text-red-500 gap-0.5">
            <div class="font-semibold">{{ book.favorite_members}}</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                heart_plus
            </div>
        </div>
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

