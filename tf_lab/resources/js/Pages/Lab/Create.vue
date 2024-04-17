<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
</script>

<template>
    <Head title="Create Book" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="">
                        <form @submit.prevent="store" class="gap-2 flex flex-col">
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <InputLabel class="pl-0.5">Title</InputLabel>
                                    <text-input class="w-full" v-model="form.title" type="text" placeholder="Title" />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel class="pl-0.5">Quote</InputLabel>
                                    <text-input class="w-full" v-model="form.quote" type="text" placeholder="Quote" />
                                </div>
                            </div>
                            <div class="flex w-1/2 gap-3 pr-2">
                                <div class="w-2/4 ">
                                    <InputLabel class="pl-0.5">Language</InputLabel>
                                    <select class="rounded w-full" v-model="form.language">
                                        <option value="English">English</option>
                                        <option value="Ukrainian">Ukrainian</option>
                                    </select>
                                </div>

                                <div class="w-2/4">
                                    <InputLabel class="pl-0.5">Age rating</InputLabel>
                                    <select class="rounded w-full" v-model="form.age_rating">
                                        <option value="18+">18+</option>
                                        <option value="R">R</option>
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

                            <div class="">
                                <InputLabel class="pl-0.5">Description</InputLabel>
                                <textarea class="w-full min-h-[150px]" v-model="form.description" type="text" placeholder="Description" />
                            </div>
                            <div class="flex justify-center">
                                <button class="w-1/4 btn-indigo hover:bg-gray-700 bg-gray-900 text-white px-2 py-1 rounded-md" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import TextInput from "@/Components/TextInput.vue";
import Draggable from 'vuedraggable';

export default {
    props: {
        allGenres: Array,
    },
    components: {
        Head,
        Link,
        TextInput,
        Draggable,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                title: null,
                description: null,
                quote: null,
                language: null,
                age_rating: null,
                genres: [],
            }),
            genresInFirstBlock: [],
            genresInSecondBlock: this.allGenres,
        }
    },
    methods: {
        store() {
            this.form.genres = this.genresInFirstBlock.map(genre => genre.id);
            this.form.post('/lab/store-book')
        },
    },
}
</script>



