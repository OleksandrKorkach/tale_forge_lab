<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
    <AuthenticatedLayout>
<!--        <div class="py-8">-->
<!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">-->
<!--                <div class="p-4 flex bg-white shadow sm:rounded-lg justify-center">-->
<!--                    <div id="book_page" class="border-indigo-400 border-2 w-1/2 h-[700px] flex flex-col">-->
<!--                        <div class="bg-red-200 px-4 pt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aspernatur atque deleniti eaque modi quidem quod rem reprehenderit rerum sint!</div>-->
<!--                        <div class="bg-red-200 px-4 pt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aspernatur atque deleniti eaque modi quidem quod rem reprehenderit rerum sint!</div>-->

<!--                        <button v-if="!showInput" id="addBlockButton" @click="showPageBlockTypes" class="flex-grow items-center justify-center border-blue-400 border-[4px] rounded-lg">-->
<!--                            Add block-->
<!--                        </button>-->
<!--                        <div v-else id="textBlockInput" contenteditable="true" class="py-0 px-4"></div>-->

<!--                        <div id="popup" class="hidden flex absolute bg-white border border-gray-300 rounded shadow">-->
<!--                            <button class="popup-btn hover:bg-gray-200 p-2">Text</button>-->
<!--                            <button class="popup-btn hover:bg-gray-200 p-2">Image</button>-->
<!--                            <button class="popup-btn hover:bg-gray-200 p-2">Header</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </AuthenticatedLayout>
</template>

<!--<script>-->
<!--export default {-->
<!--    data() {-->
<!--        return {-->
<!--            showInput: false,-->
<!--            maxChars: 100,-->
<!--        }-->
<!--    },-->
<!--    mounted() {-->
<!--        this.checkSpaceAndToggleButton();-->
<!--        window.addEventListener('resize', this.checkSpaceAndToggleButton);-->
<!--        window.addEventListener('click', this.handleWindowClick);-->

<!--        const popup = document.getElementById('popup');-->
<!--        popup.addEventListener('click', this.handlePopupClick);-->

<!--    },-->
<!--    beforeUnmount() {-->
<!--        window.removeEventListener('resize', this.checkSpaceAndToggleButton);-->
<!--        window.removeEventListener('click', this.handleWindowClick);-->

<!--        const popup = document.getElementById('popup');-->
<!--        if (popup) {-->
<!--            popup.removeEventListener('click', this.handlePopupClick);-->
<!--        }-->
<!--    },-->
<!--    methods: {-->
<!--        handleWindowClick(event) {-->
<!--            const popup = document.getElementById('popup');-->
<!--            if (event.target.closest('#addBlockButton') || event.target.closest('#popup')) {-->
<!--                return;-->
<!--            }-->
<!--            popup.classList.add('hidden');-->
<!--        },-->
<!--        checkSpaceAndToggleButton() {-->
<!--            const bookPage = document.getElementById('book_page');-->
<!--            const addButton = document.getElementById('addBlockButton');-->

<!--            const containerHeight = bookPage.clientHeight;-->
<!--            let totalChildrenHeight = 0;-->
<!--            Array.from(bookPage.children).forEach(child => {-->
<!--                if (child.id !== 'addBlockButton') {-->
<!--                    totalChildrenHeight += child.offsetHeight;-->
<!--                }-->
<!--            });-->

<!--            const availableSpace = containerHeight - totalChildrenHeight;-->

<!--            if (availableSpace > 100) {-->
<!--                addButton.style.display = "flex";-->
<!--            } else {-->
<!--                addButton.style.display = "none";-->
<!--            }-->
<!--        },-->
<!--        showPageBlockTypes(event) {-->
<!--            const popup = document.getElementById('popup');-->
<!--            popup.style.left = event.pageX + 'px';-->
<!--            popup.style.top = event.pageY + 'px';-->
<!--            popup.classList.remove('hidden');-->
<!--        },-->
<!--        handlePopupClick() {-->
<!--            if (event.target.textContent === 'Text') {-->
<!--                const addButton = document.getElementById('addBlockButton');-->
<!--                const addButtonHeight = addButton.offsetHeight + "px";-->
<!--                this.showInput = true;-->

<!--                this.$nextTick(() => {-->
<!--                    const textInput = document.getElementById('textBlockInput');-->
<!--                    textInput.style.height = addButtonHeight;-->
<!--                    textInput.style.maxHeight = addButtonHeight;-->

<!--                    textInput.addEventListener('input', event => {-->
<!--                        const maxChars = this.maxChars;-->
<!--                        if (textInput.innerText.length > maxChars) {-->
<!--                            const selection = window.getSelection();-->
<!--                            const range = document.createRange();-->

<!--                            textInput.innerText = textInput.innerText.substr(0, maxChars);-->
<!--                            range.selectNodeContents(textInput);-->
<!--                            range.collapse(false);-->
<!--                            selection.removeAllRanges();-->
<!--                            selection.addRange(range);-->
<!--                        }-->
<!--                    });-->

<!--                    textInput.focus();-->
<!--                });-->

<!--                document.getElementById('popup').classList.add('hidden');-->
<!--            }-->
<!--        },-->
<!--    },-->
<!--}-->
<!--</script>-->
