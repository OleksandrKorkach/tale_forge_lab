<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import FavoritePercent from "@/Pages/Books/partial/book-tabs/FavoritePercent.vue";
import FavoriteNumber from "@/Pages/Books/partial/book-tabs/FavoriteNumber.vue";
import CommunityRating from "@/Pages/Books/partial/book-tabs/CommunityRating.vue";
import PublishSeason from "@/Pages/Books/partial/book-tabs/PublishSeason.vue";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg ">
                    <div class="flex items-start">
                        <div class="flex flex-col gap-1 w-2/12 items-center justify-center border-r-[1px] border-gray-400 pr-2">
                            <button v-for="option in sortOptions" :key="option.value"
                                    :class="{'bg-blue-500 hover:bg-blue-600 text-white': sort === option.value, 'bg-gray-200 hover:bg-gray-300': sort !== option.value}"
                                    @click="setSort(option.value)" class="w-full px-3 py-2 rounded-lg">
                                {{ option.text }}
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-1 pl-2 w-10/12">
                            <button @click="resetLanguage" :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedLanguage === null, 'bg-gray-200 hover:bg-gray-300': selectedLanguage !== null}" class="px-3 py-2 rounded-lg">
                                All languages
                            </button>
                            <button v-for="language in languages"
                                    :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedLanguage === language, 'bg-gray-200 hover:bg-gray-300': selectedLanguage !== language}"
                                    @click="setLanguage(language)" class="px-3 py-2 rounded-lg">
                                {{ language }}
                            </button>
                            <div class="w-full py-1">
                                <div class="mx-[5px] bg-gray-300 h-[1px]"></div>
                            </div>

                            <button @click="resetGenre" :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedGenre === null, 'bg-gray-200 hover:bg-gray-300': selectedGenre !== null}" class="px-3 py-2 rounded-lg">
                                All genres
                            </button>
                            <button v-for="genre in allGenres" :key="genre.id"
                                    :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedGenre === genre.name, 'bg-gray-200 hover:bg-gray-300': selectedGenre !== genre.name}"
                                    @click="setGenre(genre.name)" class="px-3 py-2 rounded-lg">
                                {{ genre.name }}
                            </button>
                        </div>

                    </div>
                    <div class="flex flex-wrap mt-6">
                        <template v-for="book in books" :key="book.id">
                            <div class="w-[25%] border-white border-4 bg-gray-100">
                                <div class="relative">
                                    <FavoriteNumber v-if="sort === '3'" :book="book" />
                                    <FavoritePercent v-else-if="sort === '4'" :book="book" />
                                    <PublishSeason v-else-if="sort === '5'" :book="book" />
                                    <CommunityRating v-else :book="book" />
                                    <div class="gap-1 absolute top-0 left-0 bg-black text-gray-100 rounded-br-md py-0.5 px-1 min-w-[20%] flex justify-center items-center">

                                        <div class="material-symbols-rounded flex items-center">
                                            groups
                                        </div>
                                        <div class="font-bold pt-0.5 flex items-center">
                                            {{book.members}}
                                        </div>
                                    </div>
                                    <Link :href="`/books/${book.id}`" class="flex bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300">
                                        <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                                    </Link>
                                </div>
                                <div class="flex items-center justify-center w-auto">
                                    <div class="p-2 flex justify-center text-center text-sm">{{ book.title }}</div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script>

export default {
    props: {
        books: Array,
        allGenres: Array,
    },
    data() {
        return {
            sort: '1',
            genre: null,
            language: null,
            selectedGenre: null,
            selectedLanguage: null,
            languages: [
                "English",
                "Chinese",
                "Hindi",
                "Spanish",
                "French",
                "Arabic",
                "Bengali",
                "Ukrainian",
                "Portuguese",
                "Urdu",
                "Indonesian",
                "German",
                "Japanese",
                "Swahili",
                "Marathi",
                "Telugu",
                "Turkish",
                "Korean",
                "Vietnamese",
                "Tamil"
            ],
            sortOptions: [
                { value: '1', text: 'Top rated' },
                { value: '2', text: 'Top popular' },
                { value: '3', text: 'Top favorite' },
                { value: '4', text: 'Favorite %'},
                { value: '5', text: 'Latest' },
            ],
        };
    },
    mounted() {
        const params = new URLSearchParams(window.location.search);
        const genre = params.get('genre');
        if (genre && this.allGenres.some(g => g.name === genre)) {
            this.selectedGenre = genre;
        }
    },
    methods: {
        setSort(value) {
            this.sort = value;
            this.updateBooks();
        },
        setGenre(genreName) {
            this.genre = genreName;
            this.selectedGenre = genreName;
            this.updateBooks();
        },
        setLanguage(language) {
            this.language = language;
            this.selectedLanguage = language;
            this.updateBooks();
        },
        resetGenre() {
            this.genre = '';
            this.selectedGenre = null;
            this.updateBooks();
        },
        resetLanguage() {
            this.language = '';
            this.selectedLanguage = null;
            this.updateBooks();
        },
        updateBooks() {
            this.$inertia.visit('/books', {
                method: 'get',
                data: {
                    sort: this.sort,
                    genre: this.genre,
                    language: this.language,
                },
                preserveState: true,
                preserveScroll: true,
            });
        }
    },
}

</script>

