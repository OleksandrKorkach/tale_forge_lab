<script setup>
import { Head } from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Head title="Books" />

    <DefaultLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 ">
                <div class="p-8 bg-white shadow sm:rounded-lg flex">
                    <div class="w-6/12">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-2xl font-semibold">Clubs</h1>
                        </div>
                        <template v-for="club in clubs">
                            <Link :href="`/community/clubs/${club.id}`" class="p-2 flex justify-between">
                                <div>{{ club.name }}</div>
                                <div>{{ club.description }}</div>
                                <div>{{ club.members }}</div>
                            </Link>
                        </template>
                    </div>
                    <div class="w-6/12">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-2xl font-semibold">Topics</h1>
                            <button @click="createTestTopic" class="px-3 py-1 bg-gray-900 hover:bg-gray-700 text-white rounded-lg">
                                Add topic
                            </button>
                        </div>
                        <template v-for="topic in topics">
                            <Link :href="`/community/topics/${topic.id}`" class=" p-2 flex justify-between">
                                <div>{{ topic.title }}</div>
                                <div>{{ topic.description }}</div>
                                <div>{{ topic.number_of_replies }}</div>
                            </Link>
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
        clubs: Array,
        topics: Array,
    },
    methods: {
        createTestTopic() {
            if (confirm('Are you sure you want to create test topic?')) {
                this.$inertia.post('/test/topic/create');
            }
        },
    }
}

</script>

<!--<script setup>-->
<!--import {Head} from '@inertiajs/vue3';-->
<!--import DefaultLayout from "@/Layouts/DefaultLayout.vue";-->
<!--</script>-->

<!--<template>-->
<!--    <DefaultLayout>-->
<!--        <div class="py-8">-->
<!--            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-white shadow sm:rounded-lg p-2">-->
<!--                    <div class="container mx-auto p-5">-->
<!--                        &lt;!&ndash; Панель навигации &ndash;&gt;-->
<!--                        &lt;!&ndash;                        <nav class="flex justify-between items-center py-4">&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <h1 class="text-lg font-bold">Community</h1>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="flex gap-2">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <input type="text" placeholder="Search..." class="border rounded p-2"/>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    Search&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </button>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                        </nav>&ndash;&gt;-->

<!--                        &lt;!&ndash; Главный баннер &ndash;&gt;-->
<!--                        <div class="bg-blue-100 p-4 rounded">-->
<!--                            <h2 class="font-semibold text-xl">Welcome to our Community!</h2>-->
<!--                            <p>Join our upcoming events and check out the latest news!</p>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Секция топиков &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Top Topics</h3>-->
<!--                            <div class="grid grid-cols-3 gap-4">-->
<!--                                <div v-for="topic in topics" :key="topic.title" class="p-4 flex flex-col border rounded">-->
<!--                                    <h4 class="font-bold">{{ topic.title }}</h4>-->
<!--                                    <p>{{ topic.description }}</p>-->
<!--                                    <div>>{{ topic.likes }} Likes</div>-->
<!--                                    <div>{{ topic.comments }} Comments</div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Секция клубов &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Clubs</h3>-->
<!--                            <div class="grid grid-cols-2 gap-4">-->
<!--                                <div v-for="club in clubs" :key="club.name" class="p-4 border rounded">-->
<!--                                    <h4 class="font-bold">{{ club.name }}</h4>-->
<!--                                    <p>{{ club.description }}</p>-->
<!--                                    <span>{{ span }}">{{ club.members }} Members</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Участники сообщества &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Community Members</h3>-->
<!--                            <div class="flex overflow-auto">-->
<!--                                <div class="min-w-max p-2 rounded-full" v-for="member in members" :key="member.name">-->
<!--                                    <img src="/images/vano.jpg" alt="member photo" class="h-[93px] w-[93px] rounded-full">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Форумы и обсуждения &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Forums and Discussions</h3>-->
<!--                            <ul>-->
<!--                                <li v-for="forum in forums" :key="forum.title">-->
<!--                                    {{ forum.title }}-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; События и мероприятия &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Events</h3>-->
<!--                            <ul>-->
<!--                                <li v-for="event in events" :key="event.title">-->
<!--                                    {{ event.title }} - {{ event.date }}-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Блоги участников &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Member Blogs</h3>-->
<!--                            <ul>-->
<!--                                <li v-for="post in posts" :key="post.title">-->
<!--                                    {{ post.title }} by {{ post.author }}-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Статистика и достижения &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Statistics and Achievements</h3>-->
<!--                            <div class="flex justify-between">-->
<!--                                <div>Total Posts: 1200</div>-->
<!--                                <div>Active Users: 300</div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Виджеты интерактивности &ndash;&gt;-->
<!--                        <div class="my-4">-->
<!--                            <h3 class="font-semibold text-lg">Interactive Widgets</h3>-->
<!--                            <div class="flex gap-2">-->
<!--                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">-->
<!--                                    Take a Poll-->
<!--                                </button>-->
<!--                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">-->
<!--                                    Join a Challenge-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--    </DefaultLayout>-->

<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    data() {-->
<!--        return {-->
<!--            topics: [-->
<!--                {-->
<!--                    title: "Best books to read this summer",-->
<!--                    description: "Discussing the best books list...",-->
<!--                    likes: 150,-->
<!--                    comments: 40-->
<!--                },-->
<!--                {-->
<!--                    title: "How to create your own book cover?",-->
<!--                    description: "Share your ideas and findings...",-->
<!--                    likes: 85,-->
<!--                    comments: 30-->
<!--                }-->
<!--            ],-->
<!--            clubs: [-->
<!--                {name: "Sci-Fi Lovers Club", description: "Join us if you love sci-fi as much as we do!", members: 120},-->
<!--                {-->
<!--                    name: "Historical Novels",-->
<!--                    description: "For those who value history and quality storytelling",-->
<!--                    members: 75-->
<!--                }-->
<!--            ],-->
<!--            members: [-->
<!--                {name: "Alice", photo: "/path/to/photo1.jpg"},-->
<!--                {name: "Alice", photo: "/path/to/photo1.jpg"},-->
<!--                {name: "Bob", photo: "/path/to/photo2.jpg"},-->
<!--                {name: "Alice", photo: "/path/to/photo1.jpg"},-->
<!--                {name: "Bob", photo: "/path/to/photo2.jpg"},-->
<!--                {name: "Alice", photo: "/path/to/photo1.jpg"},-->
<!--                {name: "Bob", photo: "/path/to/photo2.jpg"},-->
<!--                {name: "Alice", photo: "/path/to/photo1.jpg"},-->
<!--                {name: "Bob", photo: "/path/to/photo2.jpg"},-->
<!--                {name: "Bob", photo: "/path/to/photo2.jpg"},-->
<!--            ],-->
<!--            forums: [-->
<!--                {title: "Book Editing Techniques"},-->
<!--                {title: "Cover Design Ideas"}-->
<!--            ],-->
<!--            events: [-->
<!--                {title: "Authors Meeting", date: "2024-06-10", description: "Authors' meeting on Zoom platform."},-->
<!--                {-->
<!--                    title: "Self-Publishing Seminar",-->
<!--                    date: "2024-06-20",-->
<!--                    description: "Learn how to publish your book independently!"-->
<!--                }-->
<!--            ],-->
<!--            posts: [-->
<!--                {title: "My Journey with Writing", author: "Alice"},-->
<!--                {title: "Designing Engaging Covers", author: "Bob"}-->
<!--            ]-->
<!--        };-->
<!--    }-->
<!--};-->
<!--</script>-->

