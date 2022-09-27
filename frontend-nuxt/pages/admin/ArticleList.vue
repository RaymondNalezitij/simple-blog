<template>
    <div>
        <NavBar/>

        <div v-for="article in articles" v-bind:key="article">

            {{ article.title }}

        </div>
    </div>
</template>

<script>
import axios from 'axios';


export default {
    name: 'ArticleList',

    data() {
        return {
            articles: [],
        }

    },

    async created() {

        const payload = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Authorization': 'Bearer ' + this.$store.state.auth.auth.token,
            }
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/articles', payload);
            
            this.users = res.data.data;
            
        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }
    },

    methods: {

    }

}
</script>
