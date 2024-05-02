<template>
    <DefaultLayout>
        <div class="flex items-center w-full justify-center pt-10">
            <button @click="goToPrevPage">Prev</button>
            <canvas ref="pdfCanvas"></canvas>
            <button @click="goToNextPage">Next</button>
<!--            <div>-->
<!--                <span>{{ internalCurrentPage }} / {{ internalTotalPages }}</span>-->
<!--            </div>-->
        </div>

    </DefaultLayout>
</template>

<script>
import { getDocument, GlobalWorkerOptions } from 'pdfjs-dist';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

GlobalWorkerOptions.workerSrc = '/pdf.worker.mjs';

export default {
    components: {DefaultLayout},
    pdfDoc: null,
    internalCurrentPage: 1,
    internalTotalPages: 0,

    methods: {
        async loadPdf() {
            try {
                const loadingTask = getDocument('/storage/books/HUm7x8iMEqbGXTk67pX39BOtV8DDHF0hT99f52eU.pdf');
                this.pdfDoc = await loadingTask.promise;
                this.internalTotalPages = this.pdfDoc.numPages;
                console.log('PDF loaded');
                this.internalCurrentPage = 1;
                await this.renderPage(this.internalCurrentPage);
            } catch (error) {
                console.error('Error loading PDF:', error);
            }
        },
        async renderPage(pageNum) {
            if (pageNum > 0 && pageNum <= this.internalTotalPages) {
                try {
                    const page = await this.pdfDoc.getPage(pageNum);
                    const viewport = page.getViewport({ scale: 1.65 });
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
        }
    },
    mounted() {
        this.loadPdf();
    }
};
</script>
