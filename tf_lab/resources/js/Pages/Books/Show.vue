<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Comments from './partial/Comments.vue';
import CommentsHeader from "@/Pages/Books/partial/CommentsHeader.vue";
import BookInfo from "@/Pages/Books/partial/BookInfo.vue";
import RatingStat from "@/Pages/Books/partial/RatingStat.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl relative rounded-lg">
                    <div v-if="book.ai_generated" class="absolute top-5 right-5 h-[100px] w-[100px] rotate-[-15deg]">
                        <img src="/images/qualitychecknoback2.png" alt="" >
                    </div>
                    <div class="flex ">
                        <div class="p-2 w-4/12 flex flex-col">
                            <div v-if="!book.image_url" class="bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300 items-center justify-center">
                                <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                            </div>
                            <div v-else class="">
                                <img :src="`${book.image_url}`"  alt="Logo" style="width: 100%; height: auto;" />
                            </div>
                            <Link :href="`/view-book/${book.id}`" class="mt-2 bg-gradient-to-l from-red-600 to-gray-800 hover:from-red-700 hover:to-black text-white font-semibold flex justify-center rounded-lg p-2">
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
                            <button v-if="$page.props.auth.user" class="font-semibold flex mt-1 justify-center items-center border-4 border-black rounded-lg">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-semibold rounded-md bg-white focus:outline-none transition ease-in-out duration-150">
                                                Add book to your list
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <template v-for="list in lists">
                                            <button @click="addToList(list.id)" class="p-2 flex w-full items-center gap-1">
                                                <div>
                                                    {{list.name}}
                                                </div>
                                                <div v-if="inLists.includes(list.id)" class="material-symbols-outlined font-semibold">
                                                    done
                                                </div>
                                            </button>
                                        </template>
                                    </template>
                                </Dropdown>
                            </button>
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
        lists: Array,
        inLists: Array,
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
            this.$inertia.post(`/favorite-books/toggle`, { book_id: this.book.id }, {
                preserveScroll: true
            });
            this.isFavourite = !this.isFavourite;
        },
        toggleInList() {
            this.$inertia.post(`/booklist/toggle`, { book_id: this.book.id }, {
                preserveScroll: true
            });
            this.isFavourite = !this.isFavourite;
        },
        addToList(listId) {
            this.$inertia.post(`/lists/${listId}/books/${this.book.id}`, {}, {
                preserveScroll: true,
            });
        },
    }
}

</script>
