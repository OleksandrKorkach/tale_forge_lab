<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Comments from './partial/Comments.vue';
import CommentsHeader from "@/Pages/Books/partial/CommentsHeader.vue";
import BookInfo from "@/Pages/Books/partial/BookInfo.vue";
import RatingStat from "@/Pages/Books/partial/RatingStat.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
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
                            <div v-if="$page.props.auth.user" class="flex mt-1 rounded-lg font-semibold">
                                <button @click="toggleInList(book.id)" class="w-1/2 flex text-center justify-center items-center py-1 border-y-4 border-l-4 border-black hover:bg-black hover:text-white rounded-l-lg">
                                    <div>
                                        {{ inList ? 'In readlist' : 'Add to readList' }}
                                    </div>
                                    <div v-if="inList" class="material-symbols-outlined font-semibold">
                                        done
                                    </div>
                                </button>
                                <button @click="toggleFavorite(book.id)"
                                        class="w-1/2 flex justify-center items-center py-1 border-y-4 border-r-4 border-red-500 hover:bg-red-500 hover:text-white text-red-500 rounded-r-lg"
                                >
                                    <div>
                                        {{ isFavourite ? 'In Favorites' : 'Add to Favorites' }}
                                    </div>
                                    <div v-if="isFavourite" class="material-symbols-outlined font-semibold">
                                        done
                                    </div>
                                </button>
                            </div>
                            <RatingStat :book="book" :rating="rating"/>
                        </div>
                        <div class="w-8/12 py-2 px-2">
                            <BookInfo :book="book" :genres="genres" :tags="tags" />
                            <div class="mt-6">
                                <CommentsHeader :comments="comments" :book="book" />
                                <Comments :comments="comments" :likedComments="likedComments" :dislikedComments="dislikedComments" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>

export default {
    props: {
        book: Object,
        comments: Array,
        genres: Array,
        tags: Array,
        isFavourite: Boolean,
        inList: Boolean,
        likedComments: Array,
        dislikedComments: Array,
        rating: Object,
    },
    methods: {
        toggleFavorite() {
            this.$inertia.post(`/favorite-books/toggle`, { book_id: this.book.id });
            this.isFavourite = !this.isFavourite;
        },
        toggleInList() {
            this.$inertia.post(`/booklist/toggle`, { book_id: this.book.id });
            this.isFavourite = !this.isFavourite;
        },
    }
}

</script>
