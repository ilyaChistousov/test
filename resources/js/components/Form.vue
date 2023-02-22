<template>
    <div class='container'>
        <h1 class='title'>Проверка текста</h1>
        <Editor v-model='text'/>
        <button class="btn" @click='check'>Проверить</button>
    </div>
</template>

<script>
import axios from '../api/axios';
import Editor from './Editor.vue';

export default {
    name: 'Form',
    components: {Editor},

    data() {
        return {
            text: "",
            history: []
        }
    },
    methods: {
        check() {
            axios.post('/check', {'text': this.text})
                .then((res) => this.text = res.data)
        },
    }
}
</script>

<style scoped>
*, :after, :before {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    height: 100vh;
}

.title {
    text-align: center;
}

</style>
