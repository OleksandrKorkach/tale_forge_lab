<template>
    <div class="gap-0.5 absolute top-0 right-0 bg-red-500 text-white rounded-bl-md px-1 min-w-[20%] flex justify-center items-center">
        <div class="material-symbols-outlined flex items-center">
            heart_plus
        </div>
        <div class="font-bold flex items-center">
            {{ this.bookFavoritePercent(book.members, book.favorite_members) }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        book: Object,
    },
    methods: {
        bookFavoritePercent(members, favoriteMembers) {
            if (members === 0) {
                return "0%";
            }
            const percentage = (favoriteMembers / members) * 100;
            return percentage.toFixed(0) + "%";
        },
    }
}
</script>
