<template>
    <div>
        <div class="bg-gray-100 p-4 rounded my-2">
            <strong>{{ comment.author_name }}</strong>
            <p>{{ comment.content }}</p>
            <div class="flex justify-between">
                <div>
                    <button @click="toggleReplyForm(comment.id)" class="text-gray-500">Reply</button>
                </div>
                <div v-if="comment.user_id === userId" class="flex items-center">
                    <button @click="deleteComment(comment.id)" class="material-symbols-outlined">
                        delete
                    </button>
                </div>
            </div>
            <div v-if="showReplyForm === comment.id">
                <textarea v-model="replyText" class="mt-2 mb-2 w-full p-2 rounded" placeholder="Answer this..."></textarea>
                <button @click="postReply(comment.id)" class="bg-gray-900 text-white p-2 rounded">Send</button>
            </div>
        </div>

        <div v-for="reply in comment.replies" :key="reply.id" class="ml-12">
            <div class="bg-gray-200 p-4 rounded my-2">
                <strong>{{ reply.author_name }}</strong>
                <p>{{ reply.content }}</p>
                <div class="flex justify-between">
                    <div>
                        <button @click="toggleReplyForm(reply.id, reply.author_name)" class="text-gray-500">Reply</button>
                    </div>
                    <div v-if="reply.user_id === userId" class="flex items-center">
                        <button @click="deleteComment(reply.id)" class="material-symbols-outlined">
                            delete
                        </button>
                    </div>
                </div>

                <div v-if="showReplyForm === reply.id">
                    <textarea v-model="replyText" class="mt-2 mb-2 w-full p-2 rounded" placeholder="Answer this..."></textarea>
                    <button @click="postReply(comment.id)" class="bg-gray-900 text-white px-3 py-1 rounded">Send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        topic: Object,
        comment: Object,
        userId: Number,
    },
    data() {
        return {
            showReplyForm: null,
            replyText: ''
        };
    },
    methods: {
        toggleReplyForm(commentId, authorName = '') {
            this.showReplyForm = this.showReplyForm === commentId ? null : commentId;
            if (authorName && this.showReplyForm) {
                this.replyText = `@${authorName}: `;
            } else {
                this.replyText = '';
            }
        },
        deleteComment(commentId) {
            if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
                this.$inertia.delete(`/topics/comments/${commentId}`, {
                    preserveScroll: true
                });
            }
        },
        postReply(parentId) {
            if (!this.replyText.trim()) return;

            const payload = {
                content: this.replyText,
                comment_id: parentId
            };

            this.$inertia.post(`/community/topics/${this.topic.id}`, payload, {
                preserveScroll: true,
            });

            this.replyText = '';
            this.showReplyForm = null;
        },
        // findParentReply(replies, parentId) {
        //     for (let reply of replies) {
        //         if (reply.id === parentId) {
        //             return reply;
        //         }
        //         if (reply.replies) {
        //             const found = this.findParentReply(reply.replies, parentId);
        //             if (found) return found;
        //         }
        //     }
        //     return null;
        // }
    }
}
</script>
