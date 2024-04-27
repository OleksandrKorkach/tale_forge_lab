<template>
    <div class="flex items-center gap-1">
        <div class="font-semibold">{{ book.members }}</div>
        <div class="material-symbols-outlined text-3xl">
            groups
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

