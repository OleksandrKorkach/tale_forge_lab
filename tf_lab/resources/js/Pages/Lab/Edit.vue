<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import Modal from "@/Components/Modal.vue";
import {Cropper} from "vue-advanced-cropper";
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
                                        <option v-for="language in allLanguages" :key="language" :value="language">
                                            {{ language }}
                                        </option>
                                    </select>
                                </div>

                                <div class="w-2/4">
                                    <InputLabel class="pl-0.5">Age rating</InputLabel>
                                    <select class="rounded w-full" v-model="form.age_rating">
                                        <option :value="null" />
                                        <option v-for="ageRating in allAgeRatings" :key="ageRating" :value="ageRating">
                                            {{ ageRating }}
                                        </option>
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

                            <div class="flex gap-4 mb-2">
                                <div v-if="book.image_url" class="h-[300px] w-[250px]">
                                    <img :src="`${book.image_url}`" alt="You have no logo yet!" style="object-fit: contain; width: 100%; height: 100%;">
                                </div>
                                <div>
                                    <InputLabel>
                                        Upload photo
                                    </InputLabel>
                                    <input type="file" @change="loadImage" accept="image/*">
                                    <Modal :show="showImageModal" @close="showImageModal = false" max-width="cropper" max-height="cropper">
                                        <div>
                                            <cropper
                                                v-if="image"
                                                style="height: 500px; width: 500px; background: #DDD;"
                                                class="cropper"
                                                :src="image"
                                                :stencil-props="{
                                              aspectRatio: 5/6
                                            }"
                                                @change="change"
                                            ></cropper>
                                        </div>
                                        <div class="p-2 flex justify-end">
                                            <button @click="applyImage" class="bg-gray-900 text-white rounded-lg px-3 py-2" >
                                                Apply
                                            </button>
                                        </div>

                                    </Modal>
                                </div>
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
import {Cropper} from "vue-advanced-cropper";

import 'vue-advanced-cropper/dist/style.css';

export default {
    props: {
        book: Object,
        genres: Array,
        allGenres: Array,
        tags: Array,
        allLanguages: Array,
        allAgeRatings: Array,
    },
    components: {
        Head,
        Link,
        TextInput,
        Draggable,
        Cropper
    },
    remember: 'form',
    data() {
        return {
            image: null,
            croppedImageBlob: null,
            showImageModal: false,
            form: this.$inertia.form({
                title: this.book.title,
                description: this.book.description,
                quote: this.book.quote,
                language: this.book.language,
                age_rating: this.book.age_rating,
                genres: [],
                image: null,
            }),
            genresInFirstBlock: this.genres,
            genresInSecondBlock: this.allGenres.filter(allGenre =>
                !this.genres.some(genre => genre.id === allGenre.id)),
        }
    },
    methods: {
        updateBook() {
            this.form.genres = this.genresInFirstBlock.map(genre => genre.id);
            if (this.croppedImageBlob) {
                this.form.image = this.croppedImageBlob;
            }
            this.form.post(`/lab/update-book/${this.book.id}`);
        },
        publishBook() {
            if (confirm('Are you ready to publish this book?')) {
                this.$inertia.post(`/lab/publish-book/${this.book.id}`);
            }
        },
        destroyBook() {
            if (confirm('Are you sure you want to delete this book?')) {
                this.$inertia.delete(`/lab/delete-book/${this.book.id}`)
            }
        },
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (this.book.image_url) {
                    URL.revokeObjectURL(this.book.image_url);
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                    this.showImageModal = true;
                };
                reader.readAsDataURL(file);
                this.book.image_url = URL.createObjectURL(file);
            }
        },
        change({ coordinates, canvas }) {
            console.log(coordinates, canvas);
            console.log(new Date());
            canvas.toBlob(blob => {
                this.croppedImageBlob = blob;
                this.book.image_url = URL.createObjectURL(blob);
            }, 'image/jpeg');
        },
        applyImage() {
            this.showImageModal = false;
            if (this.croppedImageBlob) {
                this.book.image_url = URL.createObjectURL(this.croppedImageBlob);
            }
        },
    },
}
</script>
