<template>
<div class="main-section">
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
            console.log("TERRIBLE ERROR:", error);
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/categories', payload);
            this.categories = res.data.data;

        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }

        this.filterArticles()
    },

    methods: {

        convertDateTime(time) {
           const dateTime = new Date(time);
            return dateTime.toLocaleDateString() + ' - ' + dateTime.toLocaleTimeString();
        },

        onCategoryChange(event) {
            console.log(event);
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
                console.log("FILTERING", article.category_id);
                return this.categoryFilter.includes(article.category_id);
            });
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
    flex-direction: row;
    justify-content: space-between;
}

.categories {
    display: flex;
    flex-direction: column;
    padding: 10px;
}
</style>