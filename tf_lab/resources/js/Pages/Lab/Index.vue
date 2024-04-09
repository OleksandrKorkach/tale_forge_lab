<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Books" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg flex flex-wrap">
                    <template v-for="(book, index) in books" :key="Index">
                        <div class="w-[25%] border-white border-4 bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300">
                            <Link :href="`/books/${book.id}`">
                                <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                                <div class="p-2 flex justify-center text-center font-semibold">{{ book.title }}</div>
                            </Link>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    props: {
        books: Array,
    },
}

</script>

