<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
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
                <h1 class="text-2xl font-bold">Alex's Book Profile</h1>
                <p class="text-gray-600">Book enthusiast, critic, and collector.</p>
                <p class="text-gray-600">Member since: January 2021</p>
<!--                <div>Author Rating: </div>-->
<!--                <div>Author Popularity</div>-->
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
              <div class="text-center">
                <div class="text-lg font-semibold">75</div>
                <div class="text-gray-500">Reviews Written</div>
              </div>
              <div class="text-center">
                <div class="text-lg font-semibold">15</div>
                <div class="text-gray-500">Topics</div>
              </div>
              <div class="text-center">
                <div class="text-lg font-semibold">12</div>
                <div class="text-gray-500">Groups</div>
              </div>
            </div>
          </div>

          <!-- Отзывы и рекомендации -->
          <div class="p-4">
            <h2 class="font-semibold mb-2">Latest Reviews</h2>
            <div class="space-y-4">
              <div class="p-3 bg-gray-100 rounded-lg">
                <p>"Great narrative and deep characters. Highly recommend!" - <strong>1984</strong></p>
              </div>
              <div class="p-3 bg-gray-100 rounded-lg">
                <p>"A bit lengthy, but a fascinating exploration of magic and fantasy." - <strong>Jonathan Strange & Mr Norrell</strong></p>
              </div>
            </div>
          </div>

          <!-- Предпочтения и интересы -->
          <div class="p-4">
            <h2 class="font-semibold mb-2">Favorite Genres</h2>
            <div class="flex flex-wrap gap-2">
              <span class="px-3 py-1 bg-blue-200 rounded-full">Fantasy</span>
              <span class="px-3 py-1 bg-blue-200 rounded-full">Science Fiction</span>
              <span class="px-3 py-1 bg-blue-200 rounded-full">Historical</span>
            </div>
          </div>

          <!-- Активные списки -->
          <div class="p-4">
            <h2 class="font-semibold mb-2">Book Lists</h2>
            <div class="grid grid-cols-3 gap-2">
              <div class="bg-gray-100 p-2 rounded-lg">
                <h3 class="font-semibold">To Read</h3>
                <p class="text-gray-500">20 books</p>
              </div>
              <div class="bg-gray-100 p-2 rounded-lg">
                <h3 class="font-semibold">Favorites</h3>
                <p class="text-gray-500">15 books</p>
              </div>
              <div class="bg-gray-100 p-2 rounded-lg">
                <h3 class="font-semibold">Recommended for Friends</h3>
                <p class="text-gray-500">10 books</p>
              </div>
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
    userInfo: Object,
    bookLists: Array,
    favorite: Number,
    readList: Number,
  }
}
</script>

