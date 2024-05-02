<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg flex">
                    <div class="w-6/12">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-2xl font-semibold">Clubs</h1>
                        </div>
                        <template v-for="club in clubs">
                            <Link :href="`/community/clubs/${club.id}`" class="p-2 flex justify-between">
                                <div>{{ club.name }}</div>
                                <div>{{ club.description }}</div>
                                <div>{{ club.members }}</div>
                            </Link>
                        </template>
                    </div>
                    <div class="w-6/12">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-2xl font-semibold">Topics</h1>
                            <button @click="createTestTopic" class="px-3 py-1 bg-gray-900 hover:bg-gray-700 text-white rounded-lg">
                                Add topic
                            </button>
                        </div>
                        <template v-for="topic in topics">
                            <Link :href="`/community/topics/${topic.id}`" class=" p-2 flex justify-between">
                                <div>{{ topic.title }}</div>
                                <div>{{ topic.description }}</div>
                                <div>{{ topic.number_of_replies }}</div>
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
        clubs: Array,
        topics: Array,
    },
    methods: {
        createTestTopic() {
            if (confirm('Are you sure you want to create test topic?')) {
                this.$inertia.post('/test/topic/create');
            }
        },
    }
}

</script>
