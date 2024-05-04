<script setup>
import { Head, Link } from '@inertiajs/vue3'
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Books"/>

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white min-h-[600px] shadow sm:rounded-lg">
                    <div class="flex items-center justify-between">
                        <Link :href="`/view-book/${book.id}`" v-if="book.pdf_url" class="bg-gray-900 hover:bg-gray-700 text-white px-2 py-1 rounded-md">
                            Watch uploaded book
                        </Link>
                        <div v-else>You're welcome to upload your book</div>
                        <div>
                            <input type="file" ref="fileInput">
                            <button v-if="!book.pdf_url" @click="submit" class="py-1 px-2 text-white bg-gray-900 hover:bg-gray-700 rounded-md">
                                Load PDF
                            </button>
                            <template v-else-if="book.pdf_url">
                                <button @click="submit" class="py-1 px-2 text-white bg-gray-900 hover:bg-gray-700 rounded-md">
                                    Update PDF
                                </button>
                                <button @click="deletePdf" class="ml-2 py-1 px-2 text-white bg-red-500 hover:bg-red-600 rounded-md">
                                    Delete
                                </button>
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
        },
        deletePdf() {
            this.$inertia.delete(`/editor/${this.book.id}/delete`, {
                onBefore: () => confirm('Are you sure you want to delete this PDF?'),
                onSuccess: () => {
                    alert('PDF deleted successfully!');
                },
                onError: () => {
                    alert('Error deleting PDF');
                }
            });
        },
    }
}

</script>

