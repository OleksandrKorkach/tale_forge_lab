<template>
    <div class="gap-0.5 absolute top-0 right-0 bg-green-500 text-white rounded-bl-md px-1 min-w-[20%] flex justify-center items-center">
        <div class="material-symbols-outlined flex items-center">
            public
        </div>
        <div class="font-bold flex items-center">
            {{ book.season }}, {{book.year}}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        book: Object,
    },
}
</script>
