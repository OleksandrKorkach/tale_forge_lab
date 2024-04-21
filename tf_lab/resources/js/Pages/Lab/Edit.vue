<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Create Book" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="">
                        <form id="editForm" @submit.prevent="updateBook" class="gap-2 flex flex-col">
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <InputLabel class="pl-0.5">Title</InputLabel>
                                    <text-input class="w-full" v-model="form.title" type="text" placeholder="Title" />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel class="pl-0.5" >Quote</InputLabel>
                                    <text-input class="w-full" v-model="form.quote" type="text" placeholder="Quote" />
                                </div>
                            </div>
                            <div class="flex w-1/2 gap-3 pr-2">
                                <div class="w-2/4 ">
                                    <InputLabel class="pl-0.5">Language</InputLabel>
                                    <select class="rounded w-full" v-model="form.language">
                                        <option :value="null" />
                                        <option value="English">English</option>
                                        <option value="Ukrainian">Ukrainian</option>
                                    </select>
                                </div>

                                <div class="w-2/4">
                                    <InputLabel class="pl-0.5">Age rating</InputLabel>
                                    <select class="rounded w-full" v-model="form.age_rating">
                                        <option :value="null" />
                                        <option value="R">R</option>
                                        <option value="18+">18+</option>
                                        <option value="16+">16+</option>
                                        <option value="21+">21+</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <InputLabel class="pl-0.5">Genres</InputLabel>
                                <div class="flex  rounded-lg border-black border-2">
                                    <div class="w-1/2">
                                        <Draggable class="flex flex-wrap items-start gap-1 h-[100%] border-r-[1px] border-black p-1" v-model="genresInFirstBlock" group="genres">
                                            <template #item="{ element }">
                                                <div class="py-2 px-4 rounded shadow" :style="{ backgroundColor: element.background_color, color: element.text_color }">
                                                    {{ element.name }}
                                                </div>
                                            </template>
                                        </Draggable>
                                    </div>
                                    <div class="w-1/2">
                                        <Draggable class="flex gap-1 flex-wrap items-start h-[100%] border-l-[1px] border-black p-1" v-model="genresInSecondBlock" group="genres">
                                            <template #item="{ element }">
                                                <div class="py-2 px-4 rounded shadow" :style="{ backgroundColor: element.background_color, color: element.text_color }">
                                                    {{ element.name }}
                                                </div>
                                            </template>
                                        </Draggable>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-2">
                                <textarea class="w-full min-h-[150px]" v-model="form.description" type="text" placeholder="Description" />
                            </div>
                        </form>
                        <div class="flex justify-between gap-1.5 mt-2">
                            <Link :href="`/books/${book.id}`" class="w-1/4 text-center btn-indigo hover:bg-green-600 bg-green-500 text-white px-2 py-1 rounded-md">
                                Watch book page
                            </Link>
                            <button form="editForm" type="submit" class="w-1/4 btn-indigo hover:bg-gray-700 bg-gray-900 text-white px-2 py-1 rounded-md">
                                Update
                            </button>
                            <button @click="destroyBook" class="w-1/4 btn-indigo hover:bg-red-600 bg-red-500 text-white px-2 py-1 rounded-md">
                                Delete
                            </button>
                            <button @click="publishBook"
                                    :class="`${ book.is_published ? 'bg-purple-500 hover:bg-purple-600' : 'bg-green-500 hover:bg-green-600'}`"
                                    class="w-1/4 btn-indigo text-white px-2 py-1 rounded-md">
                                {{ book.is_published === true ? 'Make book private' : 'Publish book' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import TextInput from "@/Components/TextInput.vue";
import Draggable from 'vuedraggable';

export default {
    props: {
        book: Object,
        genres: Array,
        allGenres: Array,
        tags: Array,
    },
    components: {
        Head,
        Link,
        TextInput,
        Draggable
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                title: this.book.title,
                description: this.book.description,
                quote: this.book.quote,
                language: this.book.language,
                age_rating: this.book.age_rating,
                genres: [],
            }),
            genresInFirstBlock: this.genres,
            genresInSecondBlock: this.allGenres.filter(allGenre =>
                !this.genres.some(genre => genre.id === allGenre.id)),
        }
    },
    methods: {
        updateBook() {
            this.form.genres = this.genresInFirstBlock.map(genre => genre.id);
            this.form.put(`/lab/update-book/${this.book.id}`);
        },
        publishBook() {
            if (confirm('Are you ready to publish this book?')) {
                this.$inertia.post(`/lab/publish-book/${this.book.id}`);
            }
        },
        destroyBook() {
            if (confirm('Are you sure you want to delete this organization?')) {
                this.$inertia.delete(`/lab/delete-book/${this.book.id}`)
            }
        },
    },
}
</script>
