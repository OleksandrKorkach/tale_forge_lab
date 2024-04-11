<template>
    <div class="flex items-center justify-between mb-2">
        <div class="flex gap-4 items-center">
            <div class="text-xl font-bold">Reviews ({{ comments.length }})</div>
        </div>
        <div class="flex items-center gap-2">
            <div class="flex rounded border-black border-2 py-1 px-2 items-center">
                <button class="font-semibold text-md pr-1 hover:scale-[103%]">Date</button>
                <div class="w-[1px] bg-black h-4"></div>
                <button class="text-md pl-1 hover:scale-[103%]">Popularity</button>
            </div>
            <button @click="showWriteComment" class="border-black border-2 bg-gray-900 rounded font-medium text-white py-1 px-2 hover:bg-gray-700">Comment . .</button>
        </div>
    </div>
    <div id="writeComment" class="hidden">
        <div class="">
            <div id="commentInput" @input="updateComment" contenteditable="true" class="rounded border-black min-h-[100px] p-2 border-2"></div>
        </div>
        <div id="submitCommentBtn" class=" flex mt-2 justify-end font-medium">
            <button @click="submitComment" class="py-1 px-2 rounded text-white bg-black" type="submit">Save</button>
        </div>
    </div>


</template>

<script>

export default {
    props: {
        comments: Array,
        book: Object,
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
        submitComment() {
            this.$inertia.post(`/books/${this.book.id}/comments`, {
                content: this.commentContent,
            });
            const input = document.getElementById('commentInput');
            input.innerText = '';
            this.commentContent = '';
            this.showWriteComment();
        }


    }
}
</script>
