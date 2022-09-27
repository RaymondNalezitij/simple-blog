<template>
    <div>
        <NavBar/>
        <div class="main-section">
        <h2 class="title">{{ this.article.title }}</h2>
        <div class="author-section">
        <div class="author">{{ this.article.author}}</div>
        <div>&ensp;&bull; {{ this.article.date }}</div>
        </div>
        <div class="article">{{ this.article.post }}</div>

        
        <form ref="formName" @submit.prevent="onSubmit">
            <div class="add-comment">
                <input class="user-input" type="text" v-model="user_name" placeholder="User Name" required>
                <textarea class="comment-input" v-model="user_comment" placeholder="Comment" required></textarea>
                <input class="button" type="submit" value="Add Comment">
            </div>
        </form>


        <div>
        <Comment v-for="comment in this.article.comments" v-bind:key="comment"
        :comment="comment" />
        </div>

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

            this.$refs.formName.reset();

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

<style scoped>
.main-section {
        margin-left: 20px;
}

.title {
    justify-items: center;
}

.author-section {
    display: flex;
    flex-direction: row;
    padding: 2px 20px;
}

.author:hover {
  text-transform: uppercase;
  color: crimson;
}

.article {
    padding: 20px 0;
}

.add-comment {
    display: flex;
    flex-direction: column;
}

.user-input {
    border-radius: 10px;
    padding: 5px;
    padding-bottom: 3px;
    margin-top: 10px;
    width: 150px;
}

.comment-input {
    border-radius: 10px;
    padding: 5px;
    margin-top: 10px;
    width: 330px;
    height: 90px;
}


.button {
    border-radius: 10px;
    padding: 5px;
    margin-top: 10px;
    width: 100px;
    cursor: pointer;
}
</style>