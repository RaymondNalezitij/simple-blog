<template>
    <div>
        <div>{{ comment.name }}</div>
        <div>{{ comment.comment }}</div>
        <div>&bull; {{ comment.date }}</div>
    </div>
</template>

<script>
export default {
    name: 'Comment',
    props: ['comment']
};
</script>
