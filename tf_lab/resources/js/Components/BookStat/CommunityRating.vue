<template>
    <div class="text-yellow-500 gap-0.5 flex items-center ">
        <div class="font-semibold">{{book.community_rating}}</div>
        <div class="material-symbols-outlined text-xl font-semibold">
            star
        </div>
    </div>
</template>

<script>
export default {
    props: {
        book: Object,
    }
}
</script>
