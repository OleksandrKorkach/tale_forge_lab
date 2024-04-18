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
                <div class="p-8 bg-white shadow sm:rounded-lg flex flex-wrap">
                    Groups!
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>


</script>
