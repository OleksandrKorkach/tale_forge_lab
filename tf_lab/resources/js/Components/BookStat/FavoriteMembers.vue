<template>
    <div class="flex items-center text-red-500 gap-0.5">
        <div class="font-semibold">{{ book.favorite_members}}</div>
        <div class="material-symbols-outlined text-xl font-semibold">
            heart_plus
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


