<script setup>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl ">
                    <h1 class="text-xl font-semibold">List "{{ list.name }}"</h1>
                    <template v-for="(book, index) in books" :key="index">
                        <div class="flex items-center justify-between">
                            <div class="p-4 flex items-center">
                                {{ index + 1 }}. {{ book.title }}
                            </div>
                            <button @click="removeFromList(book.id)" class="bg-gray-900 hover:vg-gray-700 text-white py-1 px-2 rounded-md">
                                Remove
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    props: {
        list: Object,
        books: Array,
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
