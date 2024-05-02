<template>
    <DefaultLayout>
        <div class="flex justify-center items-center gap-2 p-4">
            <PrimaryButton @click="goToPrevPage">Prev</PrimaryButton>
            <div>
                <span>{{ internalCurrentPage }} / {{ internalTotalPages }}</span>
            </div>
            <PrimaryButton @click="goToNextPage">Next</PrimaryButton>
            <div class="flex items-center justify-end ml-4 gap-2">
                <div>Scale: </div>
                <div class="flex border-black border-2 rounded p-2 gap-4">
                    <button @click="setScale(1)">
                        1
                    </button>
                    <button @click="setScale(1.5)">
                        1.5
                    </button>
                    <button @click="setScale(1.8)">
                        1.8
                    </button>
                    <button @click="setScale(2)">
                        2
                    </button>
                    <button @click="setScale(2.5)">
                        2.5
                    </button>
                </div>
            </div>

        </div>
        <div class="flex items-center w-full justify-center gap-2">
            <canvas ref="pdfCanvas"></canvas>
        </div>
        <div class="flex justify-center items-center gap-2 p-4">
            <PrimaryButton @click="goToPrevPage">Prev</PrimaryButton>
            <div>
                <span>{{ internalCurrentPage }} / {{ internalTotalPages }}</span>
            </div>
            <PrimaryButton @click="goToNextPage">Next</PrimaryButton>
        </div>
    </DefaultLayout>
</template>

<script>
import { getDocument, GlobalWorkerOptions } from 'pdfjs-dist';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

GlobalWorkerOptions.workerSrc = '/pdf.worker.mjs';

export default {
    components: {PrimaryButton, DefaultLayout},
    props: {
        pdfUrl: String
    },
    pdfDoc: null,
    data() {
        return {
            internalCurrentPage: 1,
            internalTotalPages: 0,
            scale: 1.5,
        }
    },

    methods: {
        async loadPdf() {
            this.internalCurrentPage = 1;
            try {
                const loadingTask = getDocument(this.pdfUrl);
                this.pdfDoc = await loadingTask.promise;
                this.internalTotalPages = this.pdfDoc.numPages;
                this.internalCurrentPage = 1;
                console.log('PDF loaded');
                await this.renderPage(this.internalCurrentPage);
            } catch (error) {
                console.error('Error loading PDF:', error);
            }
        },
        async renderPage(pageNum) {
            if (pageNum > 0 && pageNum <= this.internalTotalPages) {
                try {
                    const page = await this.pdfDoc.getPage(pageNum);

                    const viewport = page.getViewport({ scale: this.scale });
                    const canvas = this.$refs.pdfCanvas;
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    await page.render(renderContext).promise;
                } catch (error) {
                    console.error('Error rendering page:', error);
                }
            } else {
                console.error('Requested page number out of bounds:', pageNum);
            }
        },
        goToPrevPage() {
            if (this.internalCurrentPage > 1) {
                this.internalCurrentPage--;
                this.renderPage(this.internalCurrentPage);
            }
        },
        goToNextPage() {
            if (this.internalCurrentPage < this.internalTotalPages) {
                this.internalCurrentPage++;
                this.renderPage(this.internalCurrentPage);
            }
        },
        setScale(value) {
            this.scale = value;
            this.renderPage(this.internalCurrentPage);
        }
    },
    mounted() {
        this.loadPdf();
    }
};
</script>
