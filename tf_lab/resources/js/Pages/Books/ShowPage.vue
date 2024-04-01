<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from "@/Components/TextInput.vue";

</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h1>Book Reader</h1>
                    <div class="flex justify-center mt-4">
                        <div id="bookPage" class="rounded-md border-indigo-400 border-4 w-[60%] h-[800px] flex flex-col">
                            <template v-for="(block, index) in blocks" :key="index">
                                <div class="flex">
                                    <div class="w-10/12">
                                        <button :id="`addBlockBeforeButton${block.id}`" class="px-4 py-2 hidden flex-grow items-center justify-center">
                                            Add block
                                        </button>

                                        <div class="break-words px-4 py-2  border-b-2 border-r-2 border-black">
                                            {{ block.content }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center w-2/12 border-b-2 border-black justify-center">
                                        <div>
                                            <button  @click="showAddBlockBefore(block.id)">Add Before</button>
                                        </div>
                                        <div>
                                            <button>Save</button>
                                        </div>
                                        <div>
                                            <button @click="deleteBlock(block.id)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <button v-if="!showInput" id="addBlockButton" @click="showPageBlockTypes" class="flex-grow items-center justify-center">
                                Add block
                            </button>

                            <form v-else id="textInputForm" @submit.prevent="storeBlock" >
                                <div class="flex">
                                    <div id="textBlockInput"
                                         @input="updateContent"
                                         class="flex-grow overflow-y-hidden w-10/12 px-4 py-2 border-r-2 border-black"
                                         contenteditable="true"
                                         ref="editableBlock">
                                    </div>
                                    <text-input :loading="form.processing" type="hidden" name="content" v-model="form.content" />
                                    <div class="flex flex-col items-center w-2/12 border-b-2 border-black justify-center">
                                        <button class="bg-blue-300 p-1 px-3 rounded hover:bg-blue-400" type="submit" form="textInputForm">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>


                            <div id="popup" class="hidden flex absolute bg-white border border-gray-300 rounded shadow">
                                <button class="popup-btn hover:bg-gray-200 p-2">Text</button>
                                <button class="popup-btn hover:bg-gray-200 p-2">Image</button>
                                <button class="popup-btn hover:bg-gray-200 p-2">Header</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        book: Object,
        blocks: Array,
    },
    data() {
        return {
            showInput: false,
            maxInputHeight: 100,
            form: this.$inertia.form({
                content: null,
            }),
        }
    },
    mounted() {
        this.checkSpaceAndToggleButton();
        // window.addEventListener('resize', this.checkSpaceAndToggleButton);
        window.addEventListener('click', this.handleWindowClick);

        const popup = document.getElementById('popup');
        popup.addEventListener('click', this.handlePopupClick);

    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkSpaceAndToggleButton);
        window.removeEventListener('click', this.handleWindowClick);

        const popup = document.getElementById('popup');
        if (popup) {
            popup.removeEventListener('click', this.handlePopupClick);
        }
    },

    methods: {
        updateContent() {
            this.content = this.$refs.editableBlock.innerText;
        },
        parsePath() {
            const path = window.location.pathname;
            const parts = path.split('/');

            const bookId = parts[2];
            const pageId = parts[4];

            return { bookId, pageId };
        },
        deleteBlock(blockId) {
            this.$inertia.delete(`/blocks/${blockId}`, {
                onSuccess: () => {
                    window.location.reload()
                }
            });
        },
        storeBlock() {
            const { bookId, pageId } = this.parsePath();
            const url = `/books/${bookId}/page/${pageId}`;

            this.checkHeight();
            this.$inertia.post(url, { content: this.content }, {
                onSuccess: () => window.location.reload()
            });
        },
        handleWindowClick(event) {
            const popup = document.getElementById('popup');
            if (event.target.closest('#addBlockButton') || event.target.closest('#popup')) {
                return;
            }
            popup.classList.add('hidden');
        },
        checkSpaceAndToggleButton() {
            const bookPage = document.getElementById('bookPage');
            const addButton = document.getElementById('addBlockButton');

            const containerHeight = bookPage.clientHeight;
            let totalChildrenHeight = 0;
            Array.from(bookPage.children).forEach(child => {
                if (child.id !== 'addBlockButton') {
                    totalChildrenHeight += child.offsetHeight;
                }
            });

            const availableSpace = containerHeight - totalChildrenHeight;

            if (availableSpace > 100) {
                addButton.style.display = "flex";
            } else {
                addButton.style.display = "none";
            }
        },
        showPageBlockTypes(event) {
            const popup = document.getElementById('popup');
            popup.style.left = event.pageX + 'px';
            popup.style.top = event.pageY + 'px';
            popup.classList.remove('hidden');
        },
        showAddBlockBefore(blockId) {
            const addBlockBeforeButton = document.getElementById('addBlockBeforeButton' + blockId);
            const addBlockButton = document.getElementById('addBlockButton');
            addBlockButton.style.display = 'none';

            const bookPage = document.getElementById('bookPage');
            const containerHeight = bookPage.clientHeight;

            let totalChildrenHeight = 0;
            Array.from(bookPage.children).forEach(child => {
                if (child.id !== 'addBlockButton') {
                    totalChildrenHeight += child.offsetHeight;
                }
            });
            const availableSpace = containerHeight - totalChildrenHeight;
            console.log(availableSpace);
            addBlockBeforeButton.style.height = availableSpace + 'px';

            addBlockBeforeButton.classList.remove('hidden');
        },
        handlePopupClick() {
            if (event.target.textContent === 'Text') {
                const addButton = document.getElementById('addBlockButton');
                const addButtonHeight = addButton.offsetHeight;
                this.showInput = true;

                this.$nextTick(() => {
                    const textBlockInput = document.getElementById('textBlockInput');
                    textBlockInput.style.height = addButtonHeight + "px";
                    textBlockInput.style.maxHeight = addButtonHeight + "px";
                    this.maxInputHeight = addButtonHeight;
                    textBlockInput.focus();
                    textBlockInput.addEventListener('input', this.checkHeight);

                });

                document.getElementById('popup').classList.add('hidden');
            }
        },
        checkHeight() {
            const block = this.$refs.editableBlock;
            if (block.scrollHeight > this.maxInputHeight) {
                let content = block.innerText;
                while (block.scrollHeight > this.maxInputHeight && content.length > 0) {
                    content = content.substring(0, content.length - 1);
                    block.innerText = content;

                    const range = document.createRange();
                    const sel = window.getSelection();
                    range.selectNodeContents(block);
                    range.collapse(false);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        },
    },
}
</script>
