<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg flex">
                    <div class="w-8/12 ">
                        <h1 class="text-2xl font-semibold">Clubs</h1>
                        <template v-for="club in clubs">
                            <div class="p-2  flex justify-between">
                                <div>{{ club.name }}</div>
                                <div>{{ club.description }}</div>
                                <div>{{ club.members }}</div>
                            </div>
                        </template>

                    </div>
                    <div class="w-4/12">
                        Side bar
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
    },
}

</script>
