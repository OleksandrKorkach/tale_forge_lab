<template>
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-4 items-center">
            <div class="text-xl font-bold">Reviews ({{ comments.length }})</div>
        </div>
        <div class="flex items-center gap-2">
            <div class="flex rounded py-1 px-2 items-center">
                <button id="sort1" @click="showSortedComments(1)" class="font-semibold text-md pr-1 hover:scale-[103%]">Date</button>
                <div class="w-[1px] bg-black h-4"></div>
                <button id="sort2" @click="showSortedComments(2)" class="text-md px-1 hover:scale-[103%]">Popularity</button>
                <div class="w-[1px] bg-black h-4"></div>
                <button id="sort3" @click="showSortedComments(3)" class="text-md pl-1 hover:scale-[103%]">Most Liked</button>
            </div>
            <button v-if="$page.props.auth.user" @click="showWriteComment" class="border-black border-2 bg-gray-900 rounded font-medium text-white py-1 px-2 hover:bg-gray-700">
                Comment . .
            </button>
        </div>
    </div>
    <div v-if="$page.props.auth.user" id="writeComment" class="hidden">
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
    mounted() {
        const sort = new URLSearchParams(window.location.search).get('sort');
        console.log(sort);
        if (sort != null) {
            this.setSelectedSort(sort);
        }
    },
    methods: {
        setSelectedSort(sort) {
            const sort1 = document.getElementById('sort1');
            const sort2 = document.getElementById('sort2');
            const sort3 = document.getElementById('sort3');

            sort1.classList.remove('font-semibold');
            sort2.classList.remove('font-semibold');
            sort3.classList.remove('font-semibold');

            if (sort == 1) {
                sort1.classList.add('font-semibold');
            } else if (sort == 2) {
                sort2.classList.add('font-semibold');
            } else if (sort == 3) {
                sort3.classList.add('font-semibold');
            }
        },
        showSortedComments(sort) {
            this.setSelectedSort(sort);
            this.$inertia.visit(window.location.pathname, {
                method: 'get',
                data: {
                    sort: sort
                },
                preserveState: true,
                preserveScroll: true
            });
        },
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
            }, {
                preserveScroll: true
            });
            const input = document.getElementById('commentInput');
            input.innerText = '';
            this.commentContent = '';
            this.showWriteComment();
        },
    }
}
</script>
