<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Comments from './partial/Comments.vue';
import CommentsHeader from "@/Pages/Books/partial/CommentsHeader.vue";
import BookInfo from "@/Pages/Books/partial/BookInfo.vue";
</script>

<template>
    <Head title="Books" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex">
                        <div class="p-2 w-4/12 flex flex-col">
                            <div class="flex bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300 items-center justify-center">
                                <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                            </div>
                            <Link :href="`/books/${book.id}/page/1`" class="mt-2 bg-black text-white font-semibold flex justify-center rounded-lg p-2">
                                Read from first page
                            </Link>

                            <div class="mt-1 gap-1 justify-between flex">
                                <div class="bg-blue-500 text-gray-200 font-semibold w-5/12 flex justify-center rounded-lg p-2">You 5</div>
                                <div class="bg-yellow-400 w-7/12 font-semibold flex justify-center rounded-lg p-2">Community {{ book.community_rating }}</div>
                            </div>
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
    },
}

</script>
