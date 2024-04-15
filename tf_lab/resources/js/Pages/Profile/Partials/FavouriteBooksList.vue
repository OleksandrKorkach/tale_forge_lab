<template>
    <div class="flex gap-2 items-center">
        Favourite:
        <template v-for="(book, index) in books" :key="index">
            <div class="p-2 bg-red-300 rounded-lg">{{book.title}}</div>
        </template>

    </div>
    <div class="flex gap-2 items-center mt-10">
        ReadList:
        <template v-for="(book, index) in readlist" :key="index">
            <div class="p-2 bg-red-300 rounded-lg">{{book.title}}</div>
        </template>
    </div>

</template>

<script>
export default {
    props: {
        books: Array,
        readlist: Array,
    },
}
</script>
