<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
import NoBookImage from "@/Components/NoBookImage.vue";
import Modal from "@/Components/Modal.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-8">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg p-2">
                    <!-- Объединенный Профиль и Статистика -->
                    <div class="p-6">
                        <div class="flex items-center gap-2">
                            <div class="relative w-40 h-40 rounded-full overflow-hidden group">
                                <template v-if="user.id === $page.props.auth.user.id">
                                    <img v-if="user.avatar_url" :src="`${user.avatar_url}`" alt="Avatar" class="w-full h-full object-cover group-hover:brightness-50 transition duration-300">
                                    <img v-else src="/images/sobaka_daun.jpg" alt="Avatar" class="w-full h-full object-cover group-hover:brightness-50 transition duration-300">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                        <button class="w-full h-full material-symbols-outlined text-white text-3xl" @click="triggerFileInput">
                                            edit
                                        </button>
                                    </div>
                                </template>
                                <template v-else>
                                    <img v-if="user.avatar_url" :src="`${user.avatar_url}`" alt="Avatar" class="w-full h-full transition duration-300">
                                    <img v-else src="/images/sobaka_daun.jpg" alt="Avatar" class="w-full h-full transition duration-300">
                                </template>
                            </div>
                            <input type="file" class="hidden" ref="fileInput" @change="loadImage" accept="image/*">
                            <Modal :show="showImageModal" @close="showImageModal = false" max-width="cropper" max-height="cropper">
                                <div>
                                    <cropper
                                        v-if="image"
                                        style="height: 500px; width: 500px; background: #DDD;"
                                        class="cropper"
                                        :src="image"
                                        :stencil-props="{
                                              aspectRatio: 1
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
                            <div class="flex-grow">
                                <h1 class="text-2xl font-bold">{{ user.name }}'s profile</h1>
                                <p class="text-gray-600">Book enthusiast, critic, and collector.</p>
                                <p class="text-gray-600">Member since: {{ registeredAt }}</p>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-5 gap-4">
                            <div class="text-center">
                                <div class="text-lg font-semibold">560</div>
                                <div class="text-gray-500">Followers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-semibold">190</div>
                                <div class="text-gray-500">Following</div>
                            </div>
                            <Link :href="`/users/${user.id}/reviews`" class="text-center">
                                <div class="text-lg font-semibold">{{ reviewsCount }}</div>
                                <div class="text-gray-500">Reviews Written</div>
                            </Link>
                            <Link :href="`/users/${user.id}/topics`" class="text-center">
                                <div class="text-lg font-semibold">{{ topics }}</div>
                                <div class="text-gray-500">Topics</div>
                            </Link>
                            <div class="text-center">
                                <div class="text-lg font-semibold">12</div>
                                <div class="text-gray-500">Clubs</div>
                            </div>
                        </div>
                    </div>

                    <!-- User's books -->
                    <div class="p-4">
                        <h2 class="font-semibold mb-2">{{ user.name }}'s published books</h2>
                        <div class="space-y-4">
                            <div v-if="!publishedBooks.length > 0" class="text-gray-500 px-3">
                                The user has not written any books yet.
                            </div>
                            <div class="flex flex-wrap">
                                <template v-for="book in publishedBooks" :key="book.id">
                                    <div class="w-1/6 border-white border-2 bg-gray-100">
                                        <div class="relative">
                                            <div
                                                class="gap-1 absolute top-0 left-0 bg-black text-gray-100 rounded-br-md px-1 min-w-[20%] flex justify-center items-center">
                                                <div class="material-symbols-rounded flex items-center">
                                                    groups
                                                </div>
                                                <div class="font-bold flex pt-0.5 items-center">
                                                    {{ book.members }}
                                                </div>
                                            </div>
                                            <Link :href="`/books/${book.id}`"
                                                  class="flex bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300">
                                                <NoBookImage v-if="!book.image_url" />
                                                <div v-else>
                                                    <img :src="`${book.image_url}`"  alt="Logo" style="width: 100%; height: auto;" />
                                                </div>
                                            </Link>
                                        </div>
                                        <div class="flex items-center justify-center w-auto">
                                            <div class="p-2 text-center text-sm overflow-hidden">{{ book.title }}</div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Отзывы и рекомендации -->
                    <div class="p-4">
                        <h2 class="font-semibold mb-2">Latest Reviews</h2>
                        <div class="space-y-2">
                            <div v-if="!latestReviews.length > 0" class="text-gray-500 px-3">
                                User has no reviews yet.
                            </div>
                            <template v-for="review in latestReviews">
                                <Link :href="`/books/${review.book.id}`" class="flex p-3 bg-gray-100 rounded-lg">
                                    <p>"{{ review.content }}" - <strong>{{ review.book.title }}</strong></p>
                                </Link>
                            </template>
                        </div>
                    </div>

                    <!-- Предпочтения и интересы -->
                    <div class="p-4">
                        <h2 class="font-semibold mb-2">Favorite Genres</h2>
                        <div class="flex flex-wrap gap-1">
                            <template v-for="(genre, index) in genres" :key="index">
                                <Link :href="`/books?genre=${genre.name}`"
                                      class="py-1 px-3 rounded-lg flex items-center font-semibold"
                                      :style="`background-color: ${genre.background_color}; color: ${genre.text_color}`">
                                    {{ genre.name }}
                                </Link>
                            </template>
                        </div>
                    </div>

                    <!-- Активные списки -->
                    <div class="p-4">
                        <div class="mb-2 flex items-center justify-between">
                            <h2 class="font-semibold">Book Lists</h2>
                            <Link :href="`/users/${user.id}/lists`" class="font-semibold text-gray-500 text-sm">All Lists</Link>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <template v-for="list in lists">
                                <Link :href="`/lists/${list.id}`" class="bg-gray-100 p-2 rounded-lg">
                                    <h3 class="font-semibold">{{ list.name }}</h3>
                                    <p class="text-gray-500">{{ list.books_count }} books</p>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import {Cropper} from "vue-advanced-cropper";
import 'vue-advanced-cropper/dist/style.css';

export default {
    props: {
        user: Object,
        lists: Array,
        registeredAt: String,
        topics: Number,
        genres: Array,
        latestReviews: Array,
        reviewsCount: Number,
        publishedBooks: Array,
    },
    components: {
        Cropper
    },
    data() {
        return {
            image: null,
            croppedImageBlob: null,
            showImageModal: false,
            form: this.$inertia.form({
                image: null,
            }),
        }
    },
    mounted() {
        this.fileInput = this.$refs.fileInput;
    },
    methods: {
        triggerFileInput() {
            this.fileInput.click();
        },
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (this.user.avatar_url) {
                    URL.revokeObjectURL(this.user.avatar_url);
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                    this.showImageModal = true;
                };
                reader.readAsDataURL(file);
                this.user.avatar_url = URL.createObjectURL(file);
            }
        },
        change({ coordinates, canvas }) {
            console.log(coordinates, canvas);
            console.log(new Date());
            canvas.toBlob(blob => {
                this.croppedImageBlob = blob;
                this.user.avatar_url = URL.createObjectURL(blob);
            }, 'image/jpeg');
        },
        applyImage() {
            this.showImageModal = false;
            if (this.croppedImageBlob) {
                this.user.avatar_url = URL.createObjectURL(this.croppedImageBlob);
            }
            if (this.croppedImageBlob) {
                this.form.image = this.croppedImageBlob;
            }
            this.form.post(`/users/${this.user.id}/avatar`);
        },
    }
}
</script>

