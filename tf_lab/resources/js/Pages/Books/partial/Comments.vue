<template>
    <div class="">
        <template v-for="(comment, index) in comments" :key="index">
            <div class="mb-0.5">
                <div class="flex items-center gap-2 align-bottom">
                    <div class="text-lg font-semibold text-center">{{comment.username}}</div>
                    <button class="text-sm text-gray-600 text-center">@{{comment.username}}</button>
                </div>
                <div class="pl-6 break-words w-[95%]">{{comment.content}}</div>
                <div class="flex justify-end gap-2 items-center">
                    <div class="flex items-center gap-0.5">
                        <div class="text-green-500">{{comment.number_of_likes}}</div>
                        <button class="material-symbols-outlined text-green-500">
                            thumb_up
                        </button>
                    </div>
                    <div class="flex items-center gap-0.5">
                        <div class="text-red-500">{{comment.number_of_dislikes}}</div>
                        <button class="material-symbols-outlined text-red-500">
                            thumb_down
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
}
</script>
