<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
</script>

<template>
    <Head title="Page" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-center">
                        <div id="bookPage" class="border-2 border-black flex flex-col h-[750px] w-7/12">

                            <template v-for="(block, index) in blocks" :key="index">
                                <div :id="`pageBlock${block.id}`" class="flex flex-col border-b-2 border-black">
                                    <div :id="`beforeInputBlock${block.id}`" class="flex hidden border-b-2 border-black">
                                        <div :id="`beforeInputContent${block.id}`" contenteditable="true" type="text" class="w-10/12 border-r-2 border-black"></div>
                                        <div class="w-2/12 flex justify-center items-center">
                                            <button type="submit" :form="`beforeInputForm${block.id}`" class="bg-blue-300 hover:bg-blue-400 py-1 px-3 rounded-md">
                                                Save
                                            </button>
                                        </div>
                                    </div>

                                    <button :id="`addBeforeButton${block.id}`" @click="showPopup" class="add-block-button hidden bg-blue-200 flex-grow">
                                        Add before block
                                    </button>

                                    <div class="flex">
                                        <div class="break-words w-10/12 p-2">
                                            {{ block.content }}
                                        </div>
                                        <div class="flex-col flex w-2/12 justify-center">
                                            <button @click="showAddBlockBeforeButton(block.id)">add before</button>
                                            <button @click="deleteBlock(block.id)">delete</button>
                                        </div>
                                    </div>
                                </div>
                                <form :id="`beforeInputForm${block.id}`" @submit.prevent="storeBlock(block.id)">
                                    <text-input :loading="form.processing" type="hidden" name="content" v-model="form.content" />
                                </form>
                            </template>

                            <div id="bottomInputBlock" class="flex hidden flex-grow ">
                                <div id="bottomInputContent" ref="bottomInputBlock" contenteditable="true" @input="updateContent" type="text" class="w-10/12 border-r-2 border-black"></div>
                                <div class="w-2/12 flex justify-center items-center">
                                    <button type="submit" form="bottomInputForm" class="bg-blue-300 hover:bg-blue-400 py-1 px-3 rounded-md">
                                        Save
                                    </button>
                                </div>
                            </div>

                            <form id="bottomInputForm" @submit.prevent="storeBlock(null)">
                                <text-input :loading="form.processing" type="hidden" name="content" v-model="form.content" />
                            </form>

                            <button id="addBottomBlockButton" @click="showPopup" class="hidden add-block-button bg-blue-200 flex-grow">
                                Add bottom block
                            </button>


                            <div id="popup" @click="handlePopup" class="hidden absolute bg-white border border-gray-300 rounded shadow">
                                <button class="popup-btn hover:bg-gray-200 p-2">Text</button>
                                <button class="popup-btn hover:bg-gray-200 p-2">Image</button>
                                <button class="popup-btn hover:bg-gray-200 p-2">Header</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>
export default {
    props: {
        book: Object,
        blocks: Array,
    },
    data() {
        return {
            activeInputId: null,
            activeBlockButtonId: null,
            maxInputHeight: 100,
            content: '',
            currentPopupTargetId: null,
            form: this.$inertia.form({
                content: null,
            }),
        }
    },
    mounted() {
        this.activeBlockButtonId = 'addBottomBlockButton';
        const activeBlock = document.getElementById(this.activeBlockButtonId);
        // if (this.calculateAvailableSpace(document.getElementById('bookPage')) > 100) {
        //     activeBlock.classList.remove('hidden');
        // }
        activeBlock.classList.remove('hidden');
        window.addEventListener('click', this.handleWindowClick);
    },
    methods: {
        showAddBlockBeforeButton(blockId) {
            const addBeforeButton = document.getElementById('addBeforeButton' + blockId);
            if (this.activeInputId !== null) {
                const activeInput = document.getElementById(this.activeInputId);
                activeInput.classList.add('hidden');
                this.activeInputId = null;
            }
            if (addBeforeButton.id === this.activeBlockButtonId) {
                this.activeBlockButtonId = 'addBottomBlockButton';
                addBeforeButton.classList.add('hidden');
                const addBottomBlockButton = document.getElementById('addBottomBlockButton');

                this.stretchButton(addBottomBlockButton.id);
                addBottomBlockButton.classList.remove('hidden');
                return;
            }
            this.activeBlockButtonId = 'addBeforeButton' + blockId;
            document.querySelectorAll('.add-block-button').forEach(button => {
                if (button.id !== addBeforeButton.id)
                    button.classList.add('hidden');
            });
            this.stretchButton(addBeforeButton.id);
            addBeforeButton.classList.remove('hidden');
            // console.log(addBeforeButton.style.height);
        },
        showPopup(event) {
            this.currentPopupTargetId = event.target.id;

            const popup = document.getElementById('popup');
            popup.style.left = event.pageX + 'px';
            popup.style.top = event.pageY + 'px';
            popup.classList.remove('hidden');
        },
        handlePopup(event) {
            if (event.target.textContent === 'Text') {
                const popup = document.getElementById('popup');
                popup.classList.add('hidden');
                const activeBlockButton = document.getElementById(this.activeBlockButtonId);
                this.activeBlockButtonId = null;
                activeBlockButton.classList.add('hidden');
                if (activeBlockButton.id === 'addBottomBlockButton') {
                    this.activeInputId = 'bottomInputBlock';
                    const activeInput = document.getElementById('bottomInputBlock');
                    activeInput.classList.remove('hidden');
                } else {
                    const inputId = activeBlockButton.id.match(/addBeforeButton(\d+)/)[1];
                    this.activeInputId = 'beforeInputBlock' + inputId;
                    const activeInput = document.getElementById('beforeInputBlock' + inputId);
                    this.stretchButton(activeInput.id);
                    activeInput.classList.remove('hidden');
                }
            }
        },
        handleWindowClick(event) {
            const popup = document.getElementById('popup');
            if (event.target.classList.contains('add-block-button')) {
                return;
            }
            popup.classList.add('hidden');
        },
        stretchButton(buttonId) {
            const bookPage = document.getElementById('bookPage');
            const button = document.getElementById(buttonId);

            const availableSpace = this.calculateAvailableSpace(bookPage);
            button.style.height = `${availableSpace}px`;
            button.style.maxHeight = `${availableSpace}px`;
        },
        calculateAvailableSpace(container) {
            const containerHeight = container.clientHeight;

            let totalChildrenHeight = 0;
            Array.from(container.children).forEach(child => {
                totalChildrenHeight += child.offsetHeight;
            });

            return containerHeight - totalChildrenHeight;
        },
        updateContent() {
            this.content = document.getElementById('bottomInputField').innerText;
        },
        storeBlock(blockId = null) {
            let inputBlock;
            if (blockId) {
                inputBlock = document.getElementById('beforeInputContent' + blockId);
            } else {
                inputBlock = document.getElementById('bottomInputContent');
            }

            this.content = inputBlock.innerText;

            const { bookId, pageId } = this.parsePath();
            const url = `/books/${bookId}/page/${pageId}`;
            this.$inertia.post(url, { content: this.content }, {
                onSuccess: () => window.location.reload()
            });
        },
        // storeBlock(blockId) {
        //     const content = blockId ? this.form.content : this.content;
        //     const url = `/books/${bookId}/page/${pageId}`;
        //
        //     this.$inertia.post(url, { content: content }, {
        //         onSuccess: () => window.location.reload()
        //     });
        // },
        parsePath() {
            const path = window.location.pathname;
            const parts = path.split('/');
            const bookId = parts[2];
            const pageId = parts[4];

            return { bookId, pageId };
        },
        deleteBlock(blockId) {
            this.$inertia.delete(`/blocks/${blockId}`, {
                onSuccess: () => window.location.reload()
            });
        },
    }
}

</script>

<!--<script>-->
<!--export default {-->
<!--    props: {-->
<!--        book: Object,-->
<!--        blocks: Array,-->
<!--    },-->
<!--    data() {-->
<!--        return {-->
<!--            showLowerInput: false,-->
<!--            showBeforeInput: false,-->
<!--            activeInputId: null,-->
<!--            maxInputHeight: 100,-->
<!--            currentPopupTargetId: null,-->
<!--            form: this.$inertia.form({-->
<!--                content: null,-->
<!--            }),-->
<!--        }-->
<!--    },-->
<!--    mounted() {-->
<!--        this.stretchButton('addLowerButton');-->
<!--        window.addEventListener('click', this.handleWindowClick);-->
<!--    },-->
<!--    beforeUnmount() {-->
<!--        window.removeEventListener('click', this.handleWindowClick);-->

<!--        const popup = document.getElementById('popup');-->
<!--        if (popup) {-->
<!--            popup.removeEventListener('click', this.handlePopupClick);-->
<!--        }-->
<!--    },-->

<!--    methods: {-->
<!--        handleWindowClick(event) {-->
<!--            const popup = document.getElementById('popup');-->
<!--            if (event.target.closest('#addLowerButton') || event.target.closest('#popup') || event.target.classList.contains('add-block-before-button')) {-->
<!--                return;-->
<!--            }-->
<!--            popup.classList.add('hidden');-->
<!--        },-->
<!--        stretchButton(buttonId) {-->
<!--            const page = document.getElementById('page');-->
<!--            const addButton = document.getElementById(buttonId);-->

<!--            const containerHeight = page.clientHeight;-->
<!--            let totalChildrenHeight = 0;-->
<!--            Array.from(page.children).forEach(child => {-->
<!--                if (child.id !== buttonId) {-->
<!--                    totalChildrenHeight += child.offsetHeight;-->
<!--                }-->
<!--            });-->

<!--            const availableSpace = containerHeight - totalChildrenHeight;-->
<!--            addButton.style.display = availableSpace > 100 ? "flex" : "none";-->
<!--        },-->
<!--        showPopup(event) {-->
<!--            this.currentPopupTargetId = event.target.id;-->

<!--            const popup = document.getElementById('popup');-->
<!--            popup.style.left = event.pageX + 'px';-->
<!--            popup.style.top = event.pageY + 'px';-->
<!--            popup.classList.remove('hidden');-->
<!--        },-->
<!--        showAddBlockBefore(blockId) {-->
<!--            this.activeInputId = blockId;-->
<!--            const addBeforeButton = document.getElementById('addBeforeButton' + blockId);-->
<!--            const addLowerButton = document.getElementById('addLowerButton');-->
<!--            document.querySelectorAll('.add-block-before-button').forEach(button => {-->
<!--                button.style.display = 'none';-->
<!--            });-->

<!--            addBeforeButton.style.display = 'flex';-->

<!--            addLowerButton.style.display = 'none';-->

<!--            const page = document.getElementById('page');-->
<!--            const containerHeight = page.clientHeight;-->

<!--            let totalChildrenHeight = 0;-->
<!--            Array.from(page.children).forEach(child => {-->
<!--                if (child.id !== 'addLowerButton') {-->
<!--                    totalChildrenHeight += child.offsetHeight;-->
<!--                }-->
<!--            });-->
<!--            const availableSpace = containerHeight - totalChildrenHeight;-->
<!--            addBeforeButton.style.height = availableSpace + 'px';-->

<!--            addBeforeButton.classList.remove('hidden');-->
<!--        },-->
<!--        handlePopupClick(event) {-->
<!--            if (event.target.textContent === 'Text') {-->
<!--                this.activeInputId = this.currentPopupTargetId.includes('addBeforeButton') ? this.currentPopupTargetId.replace('addBeforeButton', '') : 'lower';-->
<!--                let button;-->
<!--                let input;-->
<!--                let buttonHeight;-->

<!--                if (this.currentPopupTargetId === 'addLowerButton') {-->
<!--                    this.showLowerInput = true;-->
<!--                    button = document.getElementById('addLowerButton');-->
<!--                    buttonHeight = button.offsetHeight;-->
<!--                    input = document.getElementById('lowerInput');-->

<!--                } else if (this.currentPopupTargetId.startsWith('addBeforeButton')) {-->
<!--                    this.showBeforeInput = true;-->
<!--                    button = document.getElementById(this.currentPopupTargetId);-->
<!--                    const blockId = this.currentPopupTargetId.replace('addBeforeButton', '');-->
<!--                    buttonHeight = button.offsetHeight;-->
<!--                    input = document.getElementById('beforeInput' + blockId);-->

<!--                } else {-->
<!--                    return;-->
<!--                }-->
<!--                // buttonHeight = button.offsetHeight;-->

<!--                this.$nextTick(() => {-->
<!--                    input.style.height = buttonHeight + "px";-->
<!--                    input.style.maxHeight = buttonHeight + "px";-->
<!--                    this.maxInputHeight = buttonHeight;-->
<!--                    input.focus();-->
<!--                    input.addEventListener('input', this.checkHeight);-->

<!--                });-->
<!--                document.getElementById('popup').classList.add('hidden');-->
<!--            }-->
<!--        },-->
<!--        checkHeight() {-->
<!--            const block = this.$refs.editableBlock;-->
<!--            if (block.scrollHeight > this.maxInputHeight) {-->
<!--                let content = block.innerText;-->
<!--                while (block.scrollHeight > this.maxInputHeight && content.length > 0) {-->
<!--                    content = content.substring(0, content.length - 1);-->
<!--                    block.innerText = content;-->

<!--                    const range = document.createRange();-->
<!--                    const sel = window.getSelection();-->
<!--                    range.selectNodeContents(block);-->
<!--                    range.collapse(false);-->
<!--                    sel.removeAllRanges();-->
<!--                    sel.addRange(range);-->
<!--                }-->
<!--            }-->
<!--        },-->
<!--        updateContent() {-->
<!--            this.content = this.$refs.editableBlock.innerText;-->
<!--        },-->
<!--        parsePath() {-->
<!--            const path = window.location.pathname;-->
<!--            const parts = path.split('/');-->
<!--            const bookId = parts[2];-->
<!--            const pageId = parts[4];-->

<!--            return { bookId, pageId };-->
<!--        },-->
<!--        storeBlock() {-->
<!--            const { bookId, pageId } = this.parsePath();-->
<!--            const url = `/books/${bookId}/page/${pageId}`;-->

<!--            this.checkHeight();-->
<!--            this.$inertia.post(url, { content: this.content }, {-->
<!--                onSuccess: () => window.location.reload()-->
<!--            });-->
<!--        },-->
<!--        deleteBlock(blockId) {-->
<!--            this.$inertia.delete(`/blocks/${blockId}`, {-->
<!--                onSuccess: () => window.location.reload()-->
<!--            });-->
<!--        },-->
<!--    },-->
<!--}-->
<!--</script>-->
