<template>
    <div class="absolute bottom-0 right-0 px-2 py-0.5 w-min-[20%] rounded-tl-md items-center justify-center" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="text-white text-sm flex">
            {{book.author_name}}
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
