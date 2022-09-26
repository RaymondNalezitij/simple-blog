<template>
    <div>
        <div class="user-section">
            <div>{{ comment.name }}</div>
            <div>&ensp;&bull; {{ comment.date }}</div>
        </div>
        <div class="comment">{{ comment.comment }}</div>
        
    </div>
</template>

<script>
export default {
    name: 'Comment',
    props: ['comment']
};
</script>

<style scoped>
.user-section {
    display: flex;
    flex-direction: row;
    padding: 20px 0 5px 0;
}

.comment {
    padding: 0 25px 0 25px;
}
</style>