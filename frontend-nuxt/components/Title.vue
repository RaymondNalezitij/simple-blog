<template>
    <div class="title">
        <nuxt-link :to="'/article/' + article.id">
        {{ article.title }}
        {{ article.author }}
        {{ article.category }}
        {{ article.date }}
        </nuxt-link>
    </div>
</template>

<script>
export default {
    name: 'Title',
    props: ['article']
};
</script>
