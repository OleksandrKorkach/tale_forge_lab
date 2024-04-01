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
                        <div id="page" class="rounded-md border-indigo-400 border-4 w-[60%] h-[800px] flex flex-col">
                            <template v-for="(block, index) in blocks" :key="index">
                                <button @click="showPopup" :id="`addBeforeButton${block.id}`" class="add-block-before-button px-4 py-2 hidden flex-grow border-b-2 border-black items-center justify-center">
                                    Add block
                                </button>
                                <div class="flex">
                                    <div class="w-10/12">
                                        <div class="break-words px-4 py-2 border-b-2 border-r-2 border-black">
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

                            <button v-if="!showInput" id="addLowerButton" @click="showPopup" class="flex-grow items-center justify-center">
                                Add lower block
                            </button>

                            <form v-else id="lowerInputForm" @submit.prevent="storeBlock" >
                                <div class="flex">
                                    <div id="lowerInput"
                                         @input="updateContent"
                                         class="flex-grow break-words overflow-y-hidden w-10/12 px-4 py-2 border-r-2 border-black"
                                         contenteditable="true"
                                         ref="editableBlock">
                                    </div>
                                    <text-input :loading="form.processing" type="hidden" name="content" v-model="form.content" />
                                    <div class="flex flex-col items-center w-2/12 border-b-2 border-black justify-center">
                                        <button class="bg-blue-300 p-1 px-3 rounded hover:bg-blue-400" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>


                            <div id="popup" @click="handlePopupClick" class="hidden flex absolute bg-white border border-gray-300 rounded shadow">
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
            showBeforeBlockInput: false,
            maxInputHeight: 100,
            form: this.$inertia.form({
                content: null,
            }),
        }
    },
    mounted() {
        this.stretchButton('addLowerButton');
        window.addEventListener('click', this.handleWindowClick);
    },
    beforeUnmount() {
        window.removeEventListener('click', this.handleWindowClick);

        const popup = document.getElementById('popup');
        if (popup) {
            popup.removeEventListener('click', this.handlePopupClick);
        }
    },

    methods: {
        handleWindowClick(event) {
            const popup = document.getElementById('popup');
            if (event.target.closest('#addLowerButton') || event.target.closest('#popup') || event.target.classList.contains('add-block-before-button')) {
                return;
            }
            popup.classList.add('hidden');
        },
        stretchButton(buttonId) {
            const page = document.getElementById('page');
            const addButton = document.getElementById(buttonId);

            const containerHeight = page.clientHeight;
            let totalChildrenHeight = 0;
            Array.from(page.children).forEach(child => {
                if (child.id !== buttonId) {
                    totalChildrenHeight += child.offsetHeight;
                }
            });

            const availableSpace = containerHeight - totalChildrenHeight;
            addButton.style.display = availableSpace > 100 ? "flex" : "none";
        },
        showPopup(event) {
            const popup = document.getElementById('popup');
            popup.style.left = event.pageX + 'px';
            popup.style.top = event.pageY + 'px';
            popup.classList.remove('hidden');
        },
        showAddBlockBefore(blockId) {
            const addBeforeButton = document.getElementById('addBeforeButton' + blockId);
            const addLowerButton = document.getElementById('addLowerButton');
            document.querySelectorAll('.add-block-before-button').forEach(button => {
                button.style.display = 'none';
            });

            addBeforeButton.style.display = 'flex';

            addLowerButton.style.display = 'none';

            const page = document.getElementById('page');
            const containerHeight = page.clientHeight;

            let totalChildrenHeight = 0;
            Array.from(page.children).forEach(child => {
                if (child.id !== 'addLowerButton') {
                    totalChildrenHeight += child.offsetHeight;
                }
            });
            const availableSpace = containerHeight - totalChildrenHeight;
            addBeforeButton.style.height = availableSpace + 'px';

            addBeforeButton.classList.remove('hidden');
        },
        handlePopupClick() {
            if (event.target.textContent === 'Text') {
                const addButton = document.getElementById('addLowerButton');
                const addButtonHeight = addButton.offsetHeight;
                this.showInput = true;

                this.$nextTick(() => {
                    const lowerInput = document.getElementById('lowerInput');
                    lowerInput.style.height = addButtonHeight + "px";
                    lowerInput.style.maxHeight = addButtonHeight + "px";
                    this.maxInputHeight = addButtonHeight;
                    lowerInput.focus();
                    lowerInput.addEventListener('input', this.checkHeight);

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
        storeBlock() {
            const { bookId, pageId } = this.parsePath();
            const url = `/books/${bookId}/page/${pageId}`;

            this.checkHeight();
            this.$inertia.post(url, { content: this.content }, {
                onSuccess: () => window.location.reload()
            });
        },
        deleteBlock(blockId) {
            this.$inertia.delete(`/blocks/${blockId}`, {
                onSuccess: () => window.location.reload()
            });
        },
    },
}
</script>
