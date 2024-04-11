<template>
    <div>
        <h1 class="text-3xl font-semibold w-[85%]">{{ book.title }}</h1>
        <div class="flex mt-2 gap-1">
            <div class="py-1 px-3 rounded-lg bg-blue-500 flex items-center font-semibold text-gray-200">Comedy</div>
            <div class="py-1 px-3 rounded-lg bg-yellow-400 flex items-center font-semibold">Drama</div>
            <div class="py-1 px-3 rounded-lg bg-black flex items-center font-semibold text-white">Horror</div>
            <div class="py-1 px-3 rounded-lg bg-purple-600 flex items-center font-semibold text-white">Fantasy</div>
        </div>
        <div class="mt-2 font-semibold">Quote: "{{ book.quote }}"</div>
        <div class="mt-4 font-semibold">Author: {{ book.author_name }}</div>
        <div class="font-semibold">Season: {{book.season}}, {{ book.year }}</div>
        <div class="font-semibold">Language: {{book.language}}</div>
        <div class="font-semibold">Pages: {{ book.pages }}</div>
        <div class="font-semibold">Rating: {{ book.age_rating }} </div>
        <div class="font-semibold">Tags: Blood, Violence and gore, Prison, Dark Fantasy, Dictatorship</div>
        <div class="mt-6">{{ book.description }}</div>
    </div>
</template>

<script>
export default {
    props: {
        book: Object,
    },
}
</script>
