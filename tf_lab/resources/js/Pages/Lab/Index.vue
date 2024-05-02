<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import NoBookImage from "@/Components/NoBookImage.vue";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white min-h-[600px] shadow sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="text-3xl font-semibold">Your books</div>
                        <button class="flex items-center justify-center font-semibold w-[40px] h-[40px] bg-gray-900 hover:bg-gray-700 rounded">
                            <Link :href="`/lab/create`" class="material-symbols-outlined text-white text-[30px]">
                                add
                            </Link>
                        </button>
                    </div>
                    <div class="flex flex-wrap mt-4">
                        <template v-for="book in books" >
                            <div class="w-[25%] relative border-white border-4 bg-gray-200">
                                <Link :href="`/lab/edit/${book.id}`">
                                    <NoBookImage v-if="!book.image_url" />
                                    <div v-else class=" ">
                                        <img :src="`${book.image_url}`"  alt="Logo" style="width: 100%; height: auto;" />
                                    </div>
                                </Link>
                                <div class="p-2 flex justify-center text-center text-sm">
                                    {{ book.title }}
                                </div>
                                <button @click="publishBook(book.id)" v-if="book.is_published === true" class="absolute flex items-center justify-center top-2 right-2 rounded " title="public">
                                    <span class="material-symbols-outlined text-[40px] text-green-400 hover:text-green-500">
                                        public
                                    </span>
                                </button>
                                <button @click="publishBook(book.id)" v-else class="absolute flex items-center justify-center top-2 right-2 rounded" title="private" >
                                    <span class="material-symbols-outlined text-[40px] text-red-500 hover:text-red-600">
                                        vpn_lock
                                    </span>
                                </button>
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
        books: Array,
    },
    methods: {
        publishBook(bookId) {
            if (confirm('Are you ready to publish this book?')) {
                this.$inertia.post(`/lab/publish-book/${bookId}`);
            }
        },
    },
}

</script>

