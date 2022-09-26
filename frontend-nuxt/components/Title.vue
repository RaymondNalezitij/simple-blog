<template>
    <div>
        <div class="headline">
        <nuxt-link :to="'/article/' + article.id">
        {{ article.title }}
        </nuxt-link>
        &bull; {{ article.category }}
        </div>
        <div class="section">{{ article.author }} &bull;{{ article.date }}</div>
        
    </div>
</template>

<script>
export default {
    name: 'Title',
    props: ['article']
};
</script>

<style scoped>
.headline {
    display: flex;
    flex-direction: row;
    padding: 5px;
}

.section {
    justify-content: end;
    padding: 5px;
}
</style>
