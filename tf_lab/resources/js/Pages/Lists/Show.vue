<script setup>

import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from '@inertiajs/vue3';
import Members from "@/Components/BookStat/Members.vue";
import FavoriteMembers from "@/Components/BookStat/FavoriteMembers.vue";
import CommunityRating from "@/Components/BookStat/CommunityRating.vue";
import NoBookImage from "@/Components/NoBookImage.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow-2xl">
                    <div class="flex justify-between items-center mb-2">
                      <div class="text-2xl font-semibold flex items-center gap-1">
                          {{ list.name }} ({{ list.books.length }})
                          <button v-if="$page.props.auth.user.id === list.user_id && list.type === 'custom'" @click="showModal" class="text-2xl material-symbols-outlined">
                              edit
                          </button>
                          <Modal :show="showUpdateModal" @close="closeModal">

                              <div class="p-6">
                                  <form @submit.prevent="update">
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
                      <button @click="downloadExcel" class="bg-gray-900 hover:bg-gray-700 text-white py-1 px-2 rounded-md">
                        Export
                      </button>
                    </div>
                    <div class="flex flex-col gap-1">
                        <template v-for="(book, index) in list.books" :key="index">
                            <div class="flex border-black border-1 bg-gray-200">
                                <div v-if="book.image_url" class="flex items-center w-[25%]">
                                    <img :src="`${book.image_url}`" alt="">
                                </div>
                                <Link v-else :href="`/books/${book.id}`" class="flex items-center w-[25%]">
                                      <NoBookImage />
                                </Link>

                                <div class="w-[62%] p-4 flex flex-col justify-between">
                                    <Link :href="`/books/${book.id}`" class="font-semibold">{{book.title}} ({{book.year}})</Link>
                                    <div class="flex flex-wrap gap-1 items-center font-semibold text-sm text-gray-500">
                                        <div v-if="book.age_rating" class="">
                                            {{book.age_rating}}
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <div v-if="book.language">
                                            {{book.language}}
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <div>
                                            {{ book.pages }} pages
                                        </div>
                                        <div class="text-[14px]">|</div>
                                        <template v-for="(genre, index) in book.genres" :key="index">
                                            <div>
                                                {{genre.name}}<span v-if="index < book.genres.length - 1">,</span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-sm " style="display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        -webkit-line-clamp: 5;
                                        overflow: hidden;">
                                        {{book.description}}
                                    </div>
                                    <div class=" font-semibold mt-2">
                                        Author: {{ book.author_name }}
                                    </div>
                                    <div class="flex gap-2">
                                        <Members :book="book" />
                                        <FavoriteMembers :book="book" />
                                        <CommunityRating :book="book" />
                                    </div>
                                </div>
                                <div class="flex flex-col mx-auto w-[13%] justify-center p-4">
                                    <button v-if="$page.props.auth.user.id === list.user_id" @click="removeFromList(book.id)" class="bg-gray-900 hover:bg-gray-700 text-white py-1 px-2 rounded-md">
                                        Remove
                                    </button>
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
        list: Object,
    },
    data() {
        return {
            showUpdateModal: false,
            form: this.$inertia.form({
                name: this.list.name,
                description: this.list.description,
            }),
        }
    },
    methods: {
        removeFromList(bookId) {
            if (confirm('Are you sure you want to remove this book?')) {
                this.$inertia.delete(`/lists/${this.list.id}/remove-book/${bookId}`, {
                    preserveScroll: true
                });
            }
        },
        downloadExcel() {
            const listId = this.list.id;
            window.location.href = `/lists/export/${listId}`;
        },
        closeModal () {
            this.showUpdateModal = false;
        },
        update() {
            this.form.put(`/lists/${this.list.id}`)
            this.closeModal();
        },
        showModal() {
            this.showUpdateModal = true;
        },
    }
}
</script>
