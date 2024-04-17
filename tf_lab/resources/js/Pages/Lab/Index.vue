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
                        <template v-for="(book, index) in books" :key="Index">
                            <div class="w-[25%] relative border-white border-4 bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300">
                                <Link :href="`/lab/edit/${book.id}`">
                                    <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                                    <div class="p-2 flex justify-center text-center font-semibold">{{ book.title }}</div>
                                </Link>
                                <button v-if="book.is_published === true" class="absolute flex items-center justify-center top-2 right-2 rounded " title="public">
                                    <span class="material-symbols-outlined text-[40px] text-green-400 hover:text-green-500">
                                        public
                                    </span>
                                </button>
                                <button v-else class="absolute flex items-center justify-center top-2 right-2 rounded" title="private" >
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
    </AuthenticatedLayout>
</template>

<script>

export default {
    props: {
        books: Array,
    },
}

</script>

