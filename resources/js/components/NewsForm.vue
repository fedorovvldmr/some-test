<template>
    <form class="w-100" @submit.prevent="submit">
        <input type="hidden" v-model="news.id">
        
        <div class="form-group">
            <label for="news-title">Название</label>
            <input class="form-control" id="news-title" type="text" v-model="news.title">
        </div>
        
        <div class="form-group">
            <label>Текст</label>
            <vue-editor v-model="news.text"></vue-editor>
        </div>
        
        <div class="form-group">
            <button class="btn btn-success">Сохранить</button>
        </div>
    </form>
</template>

<script>
    export default {
        name: 'NewsForm',
        
        props: {
            value: {
                type:     Object,
                required: true,
            },
        },
        
        data: function() {
            return {
                news: this.$props.value,
            };
        },
        
        methods: {
            submit() {
                this.$emit('input', this.news);
            },
        },
    };
</script>

<style scoped>

</style>