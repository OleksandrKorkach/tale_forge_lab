<script setup>


import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-2xl font-semibold">{{ user.name }}'s lists ({{ lists.length }})</div>
                        <button v-if="$page.props.auth.user.id === user.id" @click="showModal">Create List</button>
                        <Modal :show="showCreateModal" @close="closeModal">

                            <div class="p-6">
                                <form @submit.prevent="store">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        Create list
                                    </h2>
                                    <div class="mt-6">
                                        <InputLabel class="pl-0.5">Name</InputLabel>
                                        <text-input class="w-1/2" v-model="form.name" type="text" placeholder="Name" />
                                    </div>
                                    <div class="mt-4">
                                        <InputLabel class="pl-0.5">Description</InputLabel>
                                        <textarea class="rounded-md w-full min-h-[150px]" v-model="form.description" type="text" placeholder="Description" />
                                    </div>
                                    <div class="mt-6 flex justify-end gap-2">
                                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                                        <PrimaryButton>
                                            Submit
                                        </PrimaryButton>
                                    </div>
                                </form>


                            </div>

                        </Modal>
                    </div>
                    <div class="flex flex-wrap space-1">
                        <template v-for="list in lists">
                            <div class=" min-w-[50%] flex border-white border-2 bg-gray-200">
                                <div class="p-4 w-full">
                                    <div class="font-semibold flex justify-between items-center">
                                        <Link :href="`/lists/${list.id}`">
                                            {{ list.name }}
                                        </Link>
                                        <button v-if="list.type === 'custom' && $page.props.auth.user.id === user.id" @click.stop="deleteList(list.id)" class="px-2 py-1 rounded-md bg-red-500 hover:bg-red-600 text-white">
                                            Delete
                                        </button>
                                    </div>
                                    <div class="text-sm " style="display: -webkit-box;
                                                          -webkit-box-orient: vertical;
                                                          -webkit-line-clamp: 5;
                                                          overflow: hidden;">
                                        {{ list.description }}
                                    </div>
                                </div>
                            </div>
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
        lists: Array,
        user: Object,
    },
    data() {
        return {
            showCreateModal: false,
            form: this.$inertia.form({
                name: null,
                description: null,
            }),
        }
    },
    methods: {
        closeModal () {
            this.showCreateModal = false;
        },
        showModal() {
            this.showCreateModal = true;
        },
        store() {
            this.form.post(`/users/${this.user.id}/lists`)
            this.closeModal();
        },
        deleteList(listId) {
            if (!confirm('Are you sure you want to delete this list?')) return;

            this.form.delete(`/lists/${listId}`, {
                onError: () => {
                    alert('Error deleting list!');
                }
            })
        }
    }
}
</script>
