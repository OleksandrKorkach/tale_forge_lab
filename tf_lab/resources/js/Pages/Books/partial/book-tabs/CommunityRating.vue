<template>
    <div class="gap-0.5 absolute top-0 right-0 bg-yellow-400 rounded-bl-md px-1 min-w-[20%] flex justify-center items-center">
        <div class="material-symbols-outlined flex items-center">
            star
        </div>
        <div class="font-bold flex items-center">
            {{book.community_rating ? book.community_rating : 'Not Rated' }}
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
