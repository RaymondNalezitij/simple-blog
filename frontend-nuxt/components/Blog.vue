<template>
    <div>
        <Title v-for="article in articles" v-bind:key="article"
        :article="article" />
    </div>
</template>

<script>
import axios from 'axios';
import Title from './Title';


export default {
    components: { Title },
    name: 'Blog',
    data() {
        return {
            articles: []
        }

    },

    async created() {
        const payload = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
            }
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/articles', payload);
            this.articles = res.data.data;

        } catch (error) {
            console.log("SHIT:", error);
        }
    },
}
</script>

<style scoped>
.articles {
    display: flex;
    flex-flow: row wrap;
}

.article {
    box-sizing: border-box;
    width: 500px;
}
</style>