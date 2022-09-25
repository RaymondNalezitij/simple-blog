<template>
    <div>
        <nuxt-link :to="'/article/' + article.id">
        {{ article.title }}
        </nuxt-link>
        &bull; {{ article.category }}
        <div class="section">{{ article.author }} &bull;{{ article.date }}</div>
        
    </div>
</template>

<script>
export default {
    name: 'Title',
    props: ['article']
};
</script>

<style>
.section {
    padding: 10px 5px;
}
</style>