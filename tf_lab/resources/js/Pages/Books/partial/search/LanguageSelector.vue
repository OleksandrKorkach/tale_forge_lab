<template>
    <select v-model="selectedLanguage" @change="emitLanguage"
            class="pl-3 pr-8 py-2 rounded-lg w-full">
        <option value="">All languages</option>
        <option v-for="language in allLanguages" :key="language" :value="language">
            {{ language }}
        </option>
    </select>
</template>

<script>
export default {
    props: {
        allLanguages: Array
    },
    data() {
        return {
            selectedLanguage: ''
        };
    },
    methods: {
        emitLanguage() {
            this.$emit('language-changed', this.selectedLanguage);
        }
    }
}
</script>
