<script setup>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from '@inertiajs/vue3';
import Members from "@/Components/BookStat/Members.vue";
import FavoriteMembers from "@/Components/BookStat/FavoriteMembers.vue";
import CommunityRating from "@/Components/BookStat/CommunityRating.vue";
import NoBookImage from "@/Components/NoBookImage.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl">
                    <h1 class="text-2xl font-semibold mb-2">{{ list.name }} ({{ list.books.length }})</h1>
                    <div class="flex flex-col gap-1">
                        <template v-for="(book, index) in list.books" :key="index">
                            <div  class="flex border-black border-1 bg-gray-200">
                                <div v-if="book.url" class="flex items-center w-[25%]">
                                    <img :src="`${book.url}`" alt="">
                                </div>
                              <Link v-else :href="`/books/${book.id}`" class="flex items-center w-[25%]">
                                  <NoBookImage />
                              </Link>

                                <div class="w-[62%] p-4 flex flex-col justify-between">
                                    <Link :href="`/books/${book.id}`" class="font-semibold">{{book.title}} ({{book.year}})</Link>
                                    <div class="flex flex-wrap gap-1 items-center font-semibold text-sm text-gray-500">
                                        <div v-if="book.age_rating" class="">
                                            {{book.age_rating}}
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <div v-if="book.language">
                                            {{book.language}}
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <div>
                                            {{ book.pages }} pages
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <template v-for="(genre, index) in book.genres" :key="index">
                                            <div>
                                                {{genre.name}}<span v-if="index < book.genres.length - 1">,</span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-sm " style="display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        -webkit-line-clamp: 5;
                                        overflow: hidden;">
                                        {{book.description}}
                                    </div>
                                    <div class=" font-semibold mt-2">
                                        Author: {{ book.author_name }}
                                    </div>
                                    <div class="flex gap-2">
                                        <Members :book="book" />
                                        <FavoriteMembers :book="book" />
                                        <CommunityRating :book="book" />
                                    </div>
                                </div>
                                <div class="flex flex-col mx-auto w-[13%] justify-center p-4">
                                    <button @click="removeFromList(book.id)" class="bg-gray-900 hover:vg-gray-700 text-white py-1 px-2 rounded-md">
                                        Remove
                                    </button>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    props: {
        list: Object,
    },
    methods: {
        removeFromList(bookId) {
            if (confirm('Are you sure you want to remove this book?')) {
                this.$inertia.delete(`/lists/${this.list.id}/remove-book/${bookId}`, {
                    preserveScroll: true
                });
            }
        },
    }
}
</script>
