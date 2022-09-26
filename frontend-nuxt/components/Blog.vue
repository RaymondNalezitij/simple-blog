<template>
<div class="main-section">

    <div v-if="this.validationErrors">
        <div class="error-messages" v-for="(message, error) in this.validationErrors">
          {{ message }}
        </div>
      </div>
    
    <form class="add-post" v-if="this.$store.state.auth.auth" @submit.prevent="onSubmit">
        <input class="input" type="text" v-model="new_title" placeholder="Title" required>
        <textarea class="input" v-model="new_post" placeholder="Post" required></textarea>
            <input class="button" type="submit" value="Add Post">
    </form>

    <div class="sub-section">

    <div class="article">
        <Title  class="article" v-for="article in articlesFiltered" v-bind:key="article"
        :article="article" />
    </div>

    <ul>
        <li v-for="category in categories" v-bind:key="category">
            <label v:bind="category.id">
                <input type="checkbox" v-bind:id="category.id" @change="onCategoryChange">
                <span>{{ category.name }}</span>
            </label>
        </li>
    </ul>
    </div>

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
            articles: [],
            categories: [],
            categoryFilter: [],
            articlesFiltered: [],
            validationErrors: null,
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
            for (const article of this.articles) {
                article.date = this.convertDateTime(article.date);
            }

        } catch (error) {
            console.log(error);
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/categories', payload);
            this.categories = res.data.data;

        } catch (error) {
            console.log(error);
        }

        this.filterArticles()
    },

    methods: {

        convertDateTime(time) {
           const dateTime = new Date(time);
            return dateTime.toLocaleDateString() + ' - ' + dateTime.toLocaleTimeString();
        },

        onCategoryChange(event) {

            if (event.target.checked) {
                this.categoryFilter.push(parseInt(event.target.id));
            } else {
                this.categoryFilter = this.categoryFilter.filter(id => (id !== parseInt(event.target.id)));

            }

            this.filterArticles();
        },

        filterArticles() {
            if (this.categoryFilter.length === 0) {
                this.articlesFiltered = this.articles;
                return;
            }

            this.articlesFiltered = this.articles.filter((article) => {
                return this.categoryFilter.includes(article.category_id);
            });
        },

        async onSubmit() {

            this.validationErrors = null;

            const payload = {
                'title': this.new_title,
                'post': this.new_post,
                'category_id': 1,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Authorization': 'Bearer ' + this.$store.state.auth.auth.token,
                }
            }

            console.log("BEFORE POST");
            try {
                await axios.post('http://127.0.0.1:8000/api/articles', payload);
                console.log("AFTER POST");
            } catch (error) {
                if (error.response) {
                    this.validationErrors = error.response.data.errors;
                    return;
                }
            }
            this.new_title = "";
            this.new_post = "";
        }
    }

}
</script>

<style scoped>
.article {
    box-sizing: border-box;
    padding: 10px 20px;
}

.main-section {
    display: flex;
    flex-direction: column;
}

.sub-section {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.categories {
    display: flex;
    flex-direction: column;
    padding: 10px;
}

.add-post {
    display: flex;
    flex-direction: column;
}

.input {
    border-radius: 10px;
    width: 300px;
    margin-top: 10px;
    margin-left: 20px;
    padding: 5px;
}

.button {
    border-radius: 10px;
    width: 70px;
    margin-top: 10px;
    margin-left: 20px;
    padding: 5px;
    cursor: pointer;
}
</style>