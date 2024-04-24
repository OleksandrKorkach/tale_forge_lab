<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold mb-2">{{ topic.title }}</h1>
                        <button v-if="topic.user_id === userId" @click="deleteTopic(topic.id)" class="material-symbols-outlined">
                            delete
                        </button>
                    </div>

                    <div class="text-gray-800 mb-4">
                        <span class="font-semibold">Author:</span> {{ topic.author }}
                    </div>
                    <p class="text-gray-600 mb-4">
                        {{ topic.description }}
                    </p>
                    <hr class="my-4">
                    <div class="flex items-center justify-between">
                        <div class="text-xl font-semibold mb-2">Comments ({{ topic.number_of_replies }}) </div>
                        <button @click="showWriteComment" class="border-black border-2 bg-gray-900 rounded font-medium text-white py-1 px-2 hover:bg-gray-700">
                            Comment . .
                        </button>
                    </div>
                    <div id="writeComment" class="hidden mt-2">
                        <div class="">
                            <div id="commentInput" @input="updateComment" contenteditable="true" class="rounded border-black min-h-[100px] p-2 border-2"></div>
                        </div>
                        <div id="submitCommentBtn" class=" flex mt-2 justify-end font-medium">
                            <button @click="submitComment" class="py-1 px-2 rounded text-white bg-black" type="submit">Save</button>
                        </div>
                    </div>
                    <div v-for="comment in comments" :key="comment.id" class="mt-2">
                        <TopicComments :comment="comment" :userId="userId" :topic="topic"/>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>

import TopicComments from "@/Pages/Community/Topics/partial/TopicComments.vue";

export default {
    props: {
        topic: Object,
        comments: Array,
        userId: Number,
    },
    components: {
        TopicComments
    },
    data() {
        return {
            commentContent: '',
        };
    },
    methods: {
        showWriteComment() {
            const writeCommentBlock = document.getElementById('writeComment');
            if (writeCommentBlock.classList.contains('hidden')) {
                writeCommentBlock.classList.remove('hidden');
            } else {
                writeCommentBlock.classList.add('hidden');
            }
        },
        updateComment(event) {
            this.commentContent = event.target.innerText;
        },
        deleteTopic(topicId) {
            if (confirm('Are you sure you want to delete this topic?')) {
                this.$inertia.delete(`/community/topics/${topicId}`)
            }
        },
        submitComment() {
            this.$inertia.post(`/community/topics/${this.topic.id}`, {
                content: this.commentContent,
            }, {
                preserveScroll: true
            });
            const input = document.getElementById('commentInput');
            input.innerText = '';
            this.commentContent = '';
            this.showWriteComment();
        },
    },
}
</script>
