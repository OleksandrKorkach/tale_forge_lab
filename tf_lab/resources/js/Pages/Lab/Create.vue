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
                        <form @submit.prevent="store" class="gap-2 flex flex-col">
                            <div>
                                <div class="flex gap-2">
                                    <div v-if="form.image_url" class="h-[300px] w-[250px]">
                                        <img :src="`${form.image_url}`" alt="You have no logo yet!" style="object-fit: contain; width: 100%; height: 100%;">
                                    </div>
                                    <div>
                                        <InputLabel>
                                            Upload photo
                                        </InputLabel>
                                        <input type="file" @change="loadImage" accept="image/*" >
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
                            </div>
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
        allGenres: Array,
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
                image: null,
                title: null,
                description: null,
                quote: null,
                language: null,
                age_rating: null,
                genres: [],
                image_url: null,
            }),
            genresInFirstBlock: [],
            genresInSecondBlock: this.allGenres,
        }
    },
    methods: {
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (this.form.image_url) {
                    URL.revokeObjectURL(this.form.image_url);
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                    this.showImageModal = true;
                };
                reader.readAsDataURL(file);
                this.form.image_url = URL.createObjectURL(file);
            }
        },
        change({ coordinates, canvas }) {
            console.log(coordinates, canvas);
            console.log(new Date());
            canvas.toBlob(blob => {
                this.croppedImageBlob = blob;
                this.form.image_url = URL.createObjectURL(blob);
            }, 'image/jpeg');
        },
        applyImage() {
            this.showImageModal = false;
            if (this.croppedImageBlob) {
                this.form.image_url = URL.createObjectURL(this.croppedImageBlob);
            }
        },
        store() {
            this.form.genres = this.genresInFirstBlock.map(genre => genre.id);
            if (this.croppedImageBlob) {
                this.form.image = this.croppedImageBlob
            }
            this.form.post('/lab/store-book')
        },
    },
}
</script>



