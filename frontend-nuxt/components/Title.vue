<template>
    <div>
        <div class="headline">
        <nuxt-link :to="'/article/' + article.id">
        {{ article.title }}
        </nuxt-link>
        &ensp;&bull; {{ article.category }}
        </div>
        <div class="author-section">
            <div class="author">
                {{ article.author }}
            </div>
                &ensp;&bull;{{ article.date }}
        </div>
        
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

.author-section {
    display: flex;
    flex-direction: row;
    justify-content: end;
    padding: 5px;
}

.author:hover {
  color: lightseagreen;
}
</style>
