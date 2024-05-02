<script setup>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        {{ club.name }}
                    </div>
                    <div>
                        {{ club.description }}
                    </div>
                    <div>
                        {{ club.members }}
                    </div>
                    <div>
                        Members:
                    </div>
                    <template v-for="member in members">
                        <div>{{ member.name }}</div>
                    </template>
                </div>
            </div>
        </div>

    </DefaultLayout>
</template>

<script>
export default {
    props: {
        club: Object,
        members: Array,
    },
}
</script>
