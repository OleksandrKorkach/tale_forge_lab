<script setup>

</script>

<template>
    <div class="text-xl gap-1 justify-between flex px-1">
        <div class="text-blue-500 flex items-center ">
            <div class="font-semibold">5</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                star
            </div>
        </div>
        <div class="text-yellow-500 flex items-center ">
            <div class="font-semibold">{{book.community_rating}}</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                star
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div class="font-semibold">27.6K</div>
            <div class="material-symbols-outlined text-3xl">
                groups
            </div>
        </div>
        <div class="flex items-center text-red-500 gap-0.5">
            <div class="font-semibold">5.1K</div>
            <div class="material-symbols-outlined text-xl font-semibold">
                heart_plus
            </div>
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

