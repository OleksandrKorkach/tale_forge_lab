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
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex">
                        <div class="p-2 w-[30%] flex flex-col">
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
                            <div class="">
                                <h1 class="text-3xl font-semibold w-[85%]">{{ book.title }}</h1>
                                <div class="flex mt-2 gap-1">
                                    <div class="py-1 px-3 rounded-lg bg-blue-500 flex items-center font-semibold text-gray-200">Comedy</div>
                                    <div class="py-1 px-3 rounded-lg bg-yellow-400 flex items-center font-semibold">Drama</div>
                                    <div class="py-1 px-3 rounded-lg bg-black flex items-center font-semibold text-white">Horror</div>
                                    <div class="py-1 px-3 rounded-lg bg-purple-600 flex items-center font-semibold text-white">Fantasy</div>
                                </div>
                                <div class="mt-2 font-semibold">Quote: "All Student's will be punished!"</div>
                                <div class="mt-4 font-semibold">Author: {{ book.author_name }}</div>
                                <div class="font-semibold">Season: {{book.season}}, {{ book.year }}</div>
                                <div class="font-semibold">Language: {{book.language}}</div>
                                <div class="font-semibold">Pages: {{ book.pages }}</div>
                                <div class="font-semibold">Rating: {{ book.age_rating }} </div>
                                <div class="font-semibold">Tags: Blood, Violence and gore, Prison, Dark Fantasy, Dictatorship</div>
                                <div class="mt-6">{{ book.description }}</div>
                            </div>
                            <div class="mt-6">
                                <h1 class="mb-2 text-xl font-bold">Reviews (4)</h1>
                                <div class="pl-2">
                                    <div class="mb-2">
                                        <div class="font-semibold">Maks Lukovskyi</div>
                                        <div class="pl-6">Amazing book, what a story! </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="font-semibold">Lena Petrachkova</div>
                                        <div class="pl-6">Chapter about fight with dragon near Tokmak was wonderful!</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="font-semibold">Oleksandr "Poland" V.</div>
                                        <div class="pl-6">This book opened the gates to another world for me, filled with magic, ancient secrets, and unforgettable adventures. It's impossible to put down!</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="font-semibold">Diana K.</div>
                                        <div class="pl-6">A magnificent fantasy epic that will leave no fan of the genre indifferent. The plot is full of unexpected twists, and the depth of character development makes you empathize with them throughout the journey. </div>
                                    </div>
                                </div>
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
    },
}

</script>
