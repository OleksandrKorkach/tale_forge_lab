<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
import NoBookImage from "@/Components/NoBookImage.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-8">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <!-- Объединенный Профиль и Статистика -->
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-none mr-6">
                                <img src="/images/vano.jpg" alt="Avatar" class="w-40 h-40 rounded-full">
                            </div>
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
                                                <NoBookImage v-if="!book.url" />
                                                <div v-else>
                                                    <img :src="`${book.url}`"  alt="Logo" style="width: 100%; height: auto;" />
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
                        <h2 class="font-semibold mb-2">Book Lists</h2>
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
    }
}
</script>

