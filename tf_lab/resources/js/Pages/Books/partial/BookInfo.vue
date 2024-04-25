<script setup>

import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div>
        <h1 class="text-3xl font-semibold w-[85%]">{{ book.title }}</h1>
        <div class="flex flex-wrap mt-1 gap-1 w-[70%]">
            <template v-for="(genre, index) in genres" :key="index">
                <Link :href="`/books?genre=${genre.name}`" class="py-1 px-3 rounded-lg flex items-center font-semibold"
                     :style="`background-color: ${genre.background_color}; color: ${genre.text_color}`">
                    {{ genre.name }}
                </Link>
            </template>
        </div>
        <div class="mt-2 font-semibold">Quote: "{{ book.quote }}"</div>
        <Link :href="`/books?author=${book.author_name}`" class="flex mt-4 font-semibold">Author: {{ book.author_name }}</Link>
        <div v-if="book.season" class="font-semibold">Season: {{ book.season }}, {{ book.year }}</div>
        <Link :href="`/books?language=${book.language}`" class="flex font-semibold">Language: {{book.language}}</Link>
        <div class="font-semibold">Pages: {{ book.pages }}</div>
        <div class="font-semibold">Rating: {{ book.age_rating }} </div>
        <div v-if="tags.length > 0" class="font-semibold">Tags:
            <template v-for="(tag, index) in tags" :key="index">
                {{ tag.name }}<span v-if="index < tags.length - 1">, </span>
            </template>
        </div>
        <div class="mt-4">{{ book.description }}</div>
    </div>
</template>

<script>

export default {
    props: {
        book: Object,
        genres: Array,
        tags: Array,
    },
}
</script>
