<template>
    <div class="gap-0.5 absolute top-12 right-0 bg-purple-500 text-white px-1 min-w-[20%] flex justify-center items-center">
        <div class="material-symbols-outlined flex items-center">
            passkey
        </div>
        <div class="font-bold flex items-center">
            {{ book.age_rating }}
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
