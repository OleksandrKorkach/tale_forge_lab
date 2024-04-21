<script setup>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";

</script>

<template>
    <DefaultLayout>
        <div class="py-8">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex w-full">
                        <div class="w-3/12 flex-col">
                            <div class="p-2">
                                <img src="/images/vano.jpg" alt="Avatar">
                            </div>
                            <div class="">
                                <div class="px-2 py-1">
                                    <div class="flex justify-between w-full">
                                        <button class="mt-1 flex items-center border border-transparent text-md leading-4 font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">Your Subscribers</button>
                                        <div class="font-semibold">255</div>
                                    </div>
                                </div>
                                <div class="px-2 py-1">
                                    <div class="flex justify-between w-full">
                                        <button class="mt-1 flex items-center border border-transparent text-md leading-4 font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">Your Groups</button>
                                        <div class="font-bold">14</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-5/12 ">
                            <div class="px-2 text-xl font-bold">
                                {{userInfo.name}}'s profile
                            </div>
                            <div class="px-2 mt-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem et molestias nesciunt quae ullam?
                            </div>
                            <div class="mt-6 p-2 ">
                                <h1 class="text-md font-semibold">Your Lists</h1>
                                <button class="mt-1 flex items-center px-2 py-2 border border-transparent text-md leading-4 font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    Readlist <span class="pl-1 text-black font-bold">{{readList ? readList : 0}}</span>
                                </button>
                                <button class="mt-1 flex items-center px-2 py-2 border border-transparent text-md leading-4 font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    Favorite books <span class="pl-1 text-black font-bold">{{ favorite ? favorite : 0 }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-4/12 px-2 flex flex-col gap-2">
                            <h1 class="text-lg font-semibold">Last Visited</h1>
                            <template v-for="list in bookLists">
                                <div class="flex">
                                    <div class="bg-gradient-to-b from-blue-400 via-orange-500 to-yellow-300 w-3/12 flex items-center justify-center ">
                                        <img src="/images/tf_lab_logo.webp" alt="">
                                    </div>
                                    <div class="p-3 flex justify-between w-full">
                                        <Link :href="`/lists/${list.id}`" class="font-semibold">
                                            {{ list.name}}
                                        </Link>
                                        <div class="font-bold">
                                            go to list
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="p-2 mt-5">
                        <h1 class="font-semibold">Your last lists updates</h1>
                        <div class="flex gap-2 py-2">
                            <div class="w-[10%] bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300"><img src="/images/vano.jpg" alt=""></div>
                            <div class="w-[10%] bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300"><img src="/images/vano.jpg" alt=""></div>
                            <div class="w-[10%] bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300"><img src="/images/vano.jpg" alt=""></div>
                            <div class="w-[10%] bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300"><img src="/images/vano.jpg" alt=""></div>
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

