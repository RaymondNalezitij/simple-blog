<template>
    <div>
        <NavBar/>
        <h2>{{ this.article.title }}</h2>
        <div>{{ this.article.author}}</div>
        <div>{{ this.article.post }}</div>
        <div>&bull; {{ this.article.date }}</div>

        <div>
            <form @submit.prevent="onSubmit">
            <input type="text" v-model="user_name" placeholder="User Name" required>
            <input type="text" v-model="user_comment" placeholder="Comment" required>
            <input type="submit" value="Add Comment">
            </form>

        </div>

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
            article: [],
        }

    },

    async created() {
        this.fetchPost();
    },

    methods: {
        async onSubmit() {

            const payload = {
                'user_name': this.user_name,
                'comment': this.user_comment,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                }
            }

            try {
            await axios.post('http://127.0.0.1:8000/api/articles/'
             + this.$route.params.id
             + '/comments',
              payload);
            } catch (error) {
                console.log(error);
                return;
            }

            this.user_name = "";
            this.user_comment = "";

            this.fetchPost();
            
        },

        async fetchPost() {
                const payload = {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                }
            }

            try {
                const res = await axios.get('http://127.0.0.1:8000/api/articles/'
                + this.$route.params.id,
                payload);
                this.article = res.data.data;
            
                this.article.date = this.convertDateTime(this.article.date);
            
                for (const comment of this.article.comments) {
                    comment.date = this.convertDateTime(comment.date);
                }

            } catch (error) {
                console.log(error);
            }
        },

        convertDateTime(time) {
            const dateTime = new Date(time);
            return dateTime.toLocaleDateString() + ' - ' + dateTime.toLocaleTimeString();
        }
    },
}
</script>
