<template>
    <div>
        <h2>{{ this.article.title }}</h2>
        <div>{{ this.article.author}}</div>
        <div>{{ this.article.post }}</div>
        <div>{{ this.article.date }}</div>

        <div>
        <Comment v-for="comment in this.article.comments" v-bind:key="comment"
        :comment="comment" />
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import Comment from '@/components/Comment';

export default {
    components: { Comment },
    name: 'Article',
    data() {
        return {
            article: []
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
            const res = await axios.get('http://127.0.0.1:8000/api/articles/' + this.$route.params.id, payload);
            this.article = res.data.data;

        } catch (error) {
            console.log("SHIT:", error);
        }
    },
}
</script>
