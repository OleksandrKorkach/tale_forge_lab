<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Comments from './partial/Comments.vue';
import CommentsHeader from "@/Pages/Books/partial/CommentsHeader.vue";
import BookInfo from "@/Pages/Books/partial/BookInfo.vue";
import RatingStat from "@/Pages/Books/partial/RatingStat.vue";
</script>

<template>
    <Head title="Books" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl ">
                    <div class="flex">
                        <div class="p-2 w-4/12 flex flex-col">
                            <div class="bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300 items-center justify-center">
                                <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                            </div>
                            <Link :href="`/books/${book.id}/pages/1`" class="mt-2 bg-gradient-to-l from-red-600 to-gray-800 hover:from-red-700 hover:to-black text-white font-semibold flex justify-center rounded-lg p-2">
                                Read from first page
                            </Link>
                            <div class="flex mt-1 rounded-lg font-semibold">
                                <button class="w-1/2 text-center py-1 border-y-4 border-l-4 border-black hover:bg-black hover:text-white rounded-l-lg ease-in-out">Add to readlist</button>
                                <button :class="{'bg-red-500 text-white hover:bg-white hover:text-red-500': isFavorited, 'bg-white text-red-500 hover:bg-red-500 hover:text-white': !isFavorited}" @click="toggleFavorite(book.id)"
                                        class="w-1/2 text-center py-1 border-y-4 border-r-4 border-red-500 hover:bg-red-500 text-red-500 rounded-r-lg ease-in-out ">
                                    {{ isFavorited ? 'In Favorites' : 'Add to Favorites' }}
                                </button>
                            </div>
                            <RatingStat :book="book"/>
                        </div>
                        <div class="w-8/12 py-2 px-2">
                            <BookInfo :book="book" :genres="genres" :tags="tags" />
                            <div class="mt-6">
                                <CommentsHeader :comments="comments" :book="book" />
                                <Comments :comments="comments" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    props: {
        book: Object,
        comments: Array,
        genres: Array,
        tags: Array,
        isFavorited: Boolean,
    },
    methods: {
        toggleFavorite() {
            this.$inertia.post(`/favorite-books/toggle`, { book_id: this.book.id });
            this.isFavorited = !this.isFavorited;
        },
    }
}

</script>
