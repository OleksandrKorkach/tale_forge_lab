<template>
    <div class="gap-0.5 absolute top-0 right-0 bg-yellow-400 rounded-bl-md py-0.5 px-1 min-w-[20%] flex justify-center items-center">
        <div class="material-symbols-outlined flex items-center">
            star
        </div>
        <div class="font-bold pt-0.5 flex items-center">
            {{book.community_rating}}
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
