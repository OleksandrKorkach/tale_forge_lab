<template>
    <div class="">
        <template v-for="(comment, index) in comments" :key="index">
            <div class="mb-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="text-lg font-semibold text-center">{{comment.username}}</div>
                        <button class="text-sm text-gray-600 text-center">@{{comment.username}}</button>
                    </div>
                    <div class="text-sm"> Today, {{ comment.created_at.slice(11,16) }}</div>
                </div>
                <div class="pl-4 break-words w-[95%]">{{comment.content}}</div>
                <div class="flex justify-end gap-2 items-center">
                    <div class="flex items-center gap-0.5">
                        <div class="text-green-500">{{comment.number_of_likes}}</div>
                        <button @click="likeComment(comment.id, 'like')" class="material-symbols-outlined text-green-500">
                            thumb_up
                        </button>
                    </div>
                    <div class="flex items-center gap-0.5">
                        <div class="text-red-500">{{comment.number_of_dislikes}}</div>
                        <button @click="likeComment(comment.id, 'dislike')" class="material-symbols-outlined text-red-500">
                            thumb_down
                        </button>
                    </div>
                    <div v-if="comment.user_id === userId" class="flex items-center">
                        <button @click="deleteComment(comment.id)" class="material-symbols-outlined">
                            delete
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        comments: Array,
    },
    computed: {
        userId() {
            return this.$page.props.auth.user ? this.$page.props.auth.user.id : null;
        }
    },
    methods: {
        deleteComment(commentId) {
            if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
                this.$inertia.delete(`/comments/${commentId}/delete`, {
                    preserveScroll: true
                });
            }
        },
        likeComment(commentId, type) {
            // Отправляем запрос с сохранением позиции скролла
            this.$inertia.post(`/comments/${commentId}/likes`, {
                type: type
            }, {
                preserveScroll: true
            });
        },
    }

}
</script>
