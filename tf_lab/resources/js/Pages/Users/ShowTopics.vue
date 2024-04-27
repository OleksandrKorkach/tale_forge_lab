<script setup>


import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-2xl font-semibold">{{ user.name }}'s topics ({{ topics.length }})</div>
                    </div>
                    <div class="flex flex-wrap space-1">
                        <template v-for="topic in topics">
                            <Link :href="`/community/topics/${topic.id}`"
                                  class=" min-w-[50%] flex border-white border-2 bg-gray-200">
                                <div class="p-4 flex flex-col justify-between">
                                    <div class="font-semibold">
                                        {{ topic.title }}
                                    </div>
                                    <div class="text-sm " style="display: -webkit-box;
                                                          -webkit-box-orient: vertical;
                                                          -webkit-line-clamp: 5;
                                                          overflow: hidden;">
                                        {{ topic.description }}
                                    </div>
                                </div>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    props: {
        topics: Array,
        user: Object,
    }
}
</script>
