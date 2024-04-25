<script setup>
import {Head} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import FavoritePercent from "@/Pages/Books/partial/book-tabs/FavoritePercent.vue";
import FavoriteNumber from "@/Pages/Books/partial/book-tabs/FavoriteNumber.vue";
import CommunityRating from "@/Pages/Books/partial/book-tabs/CommunityRating.vue";
import PublishSeason from "@/Pages/Books/partial/book-tabs/PublishSeason.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthorName from "@/Pages/Books/partial/book-tabs/AuthorName.vue";
import AgeRating from "@/Pages/Books/partial/book-tabs/AgeRating.vue";
import InputLabel from "@/Components/InputLabel.vue";
</script>

<template>
    <Head title="Books"/>

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg min-h-screen">
                    <div class="flex">
                        <div class="flex flex-col w-2/12 items-center justify-between border-r-[1px] border-gray-400 pr-2">
                            <button v-for="option in sortOptions" :key="option.value"
                                    :class="{'bg-blue-500 hover:bg-blue-600 text-white': sort === option.value, 'bg-gray-200 hover:bg-gray-300': sort !== option.value}"
                                    @click="setSort(option.value)" class="w-full px-3 py-1.5 rounded-lg">
                                {{ option.text }}
                            </button>
                        </div>
                        <div class="gap-1 pl-2 w-10/12">
                            <div class="flex">
                                <div class="gap-1 w-[70%] pr-2">
                                    <div class="flex gap-1">
                                        <Link :href="`/books`" class="flex justify-center items-center bg-gray-200 hover:bg-red-500 hover:text-white w-full rounded-lg border-[2px]">
                                            Clear filter
                                        </Link>

                                        <select v-model="selectedLanguage" @change="setLanguage(selectedLanguage)"
                                                class="pl-3 pr-8 py-2 rounded-lg w-full">
                                            <option value="">All languages</option>
                                            <option v-for="language in allLanguages" :key="language" :value="language">
                                                {{ language }}
                                            </option>
                                        </select>

                                        <select v-model="selectedAgeRating" @change="setAgeRating(selectedAgeRating)"
                                                class="pl-3 pr-8 py-2 rounded-lg w-full">
                                            <option value="">All ages</option>
                                            <option v-for="ageRating in allAgeRatings" :key="ageRating" :value="ageRating">
                                                {{ ageRating }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex space-x-1 mt-1">

                                        <TextInput
                                            placeholder="Author"
                                            v-model="searchAuthor"
                                            @input="debouncedUpdateBooks"
                                            class="px-3 py-2 rounded-lg w-[40%]"
                                        />

                                        <TextInput
                                            class="w-[30%]"
                                            placeholder="Min members"
                                            @input="debouncedUpdateBooks"
                                            v-model="minMembers"
                                        />
                                        <TextInput
                                            class="w-[30%]"
                                            @input="debouncedUpdateBooks"
                                            placeholder="Max members"
                                            v-model="maxMembers"
                                        />

                                    </div>
                                </div>

                                <div class="w-[1px] bg-gray-200"></div>

                                <div class="w-[30%] justify- flex flex-col gap-1 px-2">
                                    <div class="flex items-center gap-2 justify-between ">
                                        <input-label class="text-lg">
                                            From
                                        </input-label>
                                        <input type="date" @input="debouncedUpdateBooks" v-model="fromDate" id="" class="rounded-lg">
                                    </div>

                                    <div class="flex items-center gap-2 justify-between">
                                        <input-label class="text-md">
                                            To
                                        </input-label>
                                        <input type="date" @input="debouncedUpdateBooks" v-model="toDate" name="" id="" class="rounded-lg">
                                    </div>
                                </div>
                            </div>

                            <div class="w-full py-3">
                                <div class="mx-[5px] bg-gray-300 h-[1px]"></div>
                            </div>

                            <div class="flex flex-wrap gap-1">

                                <button @click="resetGenre"
                                        :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedGenre === null, 'bg-gray-200 hover:bg-gray-300': selectedGenre !== null}"
                                        class="px-3 py-2 rounded-lg">
                                    All genres
                                </button>
                                <button v-for="genre in allGenres" :key="genre.id"
                                        :class="{'bg-blue-500 hover:bg-blue-600 text-white': selectedGenre === genre.name, 'bg-gray-200 hover:bg-gray-300': selectedGenre !== genre.name}"
                                        @click="setGenre(genre.name)" class="px-3 py-2 rounded-lg">
                                    {{ genre.name }}
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-wrap mt-6">
                        <template v-for="book in books" :key="book.id">
                            <div class="w-[25%] border-white border-4 bg-gray-100">
                                <div class="relative">
                                    <FavoriteNumber v-if="sort === '3'" :book="book"/>
                                    <FavoritePercent v-else-if="sort === '4'" :book="book"/>
                                    <PublishSeason v-else-if="sort === '5'" :book="book"/>
                                    <CommunityRating v-else :book="book"/>
                                    <AuthorName v-if="searchAuthor" :book="book" />
                                    <AgeRating v-if="ageRating" :book="book" />

                                    <div
                                        class="gap-1 absolute top-0 left-0 bg-black text-gray-100 rounded-br-md px-1 min-w-[20%] flex justify-center items-center">
                                        <div class="material-symbols-rounded flex items-center">
                                            groups
                                        </div>
                                        <div class="font-bold flex pt-0.5 items-center">
                                            {{ book.members }}
                                        </div>
                                    </div>
                                    <Link :href="`/books/${book.id}`"
                                          class="flex bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300">
                                        <div v-if="!book.url" class="bg-gradient-to-b from-blue-500 via-orange-500 to-yellow-300 items-center justify-center">
                                            <img src="/images/tf_lab_logo.webp"  alt="Logo" />
                                        </div>
                                        <div v-else class=" ">
                                            <img :src="`${book.url}`"  alt="Logo" style="width: 100%; height: auto;" />
                                        </div>
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
        allLanguages: Array,
        allAgeRatings: Array,
    },
    data() {
        return {
            sort: '1',
            genre: null,
            language: null,
            ageRating: null,
            timeoutId: null,
            selectedGenre: null,
            fromDate: '',
            toDate: '',
            minMembers: '',
            maxMembers: '',
            selectedLanguage: '',
            searchAuthor: '',
            selectedAgeRating: '',
            sortOptions: [
                {value: '1', text: 'Top rated'},
                {value: '2', text: 'Top popular'},
                {value: '3', text: 'Top favorite'},
                {value: '4', text: 'Favorite %'},
                {value: '5', text: 'Latest'},
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
        debouncedUpdateBooks() {
            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
            }

            this.timeoutId = setTimeout(() => {
                this.updateBooks();
            }, 250);
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
        setAgeRating(ageRating) {
            this.ageRating = ageRating;
            this.selectedAgeRating = ageRating;
            this.updateBooks();
        },
        resetGenre() {
            this.genre = '';
            this.selectedGenre = null;
            this.updateBooks();
        },
        updateBooks() {
            this.$inertia.visit('/books', {
                method: 'get',
                data: {
                    sort: this.sort,
                    genre: this.genre,
                    language: this.language,
                    author: this.searchAuthor,
                    ageRating: this.ageRating,
                    fromDate: this.fromDate,
                    toDate: this.toDate,
                    minMembers: this.minMembers,
                    maxMembers: this.maxMembers,
                },
                preserveState: true,
                preserveScroll: true,
            });
        }
    },
}

</script>

