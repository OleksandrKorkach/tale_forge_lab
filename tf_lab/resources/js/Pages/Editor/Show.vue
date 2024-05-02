<script setup>
import {Head} from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Books"/>

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white min-h-[600px] shadow sm:rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>Hello World! Book id: {{ book.id }}</div>
                        <div>
                            <input v-if="!book.pdf_url" type="file" ref="fileInput">
                            <button v-if="!book.pdf_url" @click="submit" class="py-1 px-2 text-white bg-gray-900 hover:bg-gray-700 rounded-md">
                                Load PDF
                            </button>
                            <div v-else>
                                You already downloaded book!
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
        book: Object,
    },
    methods: {
        submit() {
            const file = this.$refs.fileInput.files[0];
            if (!file) {
                alert('Please select a file.');
                return;
            }

            let formData = new FormData();
            formData.append('pdf', file);
            formData.append('bookId', this.book.id);

            this.$inertia.post(`/editor/${this.book.id}/save`, formData, {
                onBefore: () => confirm('Are you sure you want to upload this PDF?'),
                onSuccess: () => {
                    alert('PDF uploaded successfully!');
                },
                onError: () => {
                    alert('Error uploading PDF');
                }
            });
        }
    }
}

</script>

