<template>
  <div>
    <NavBar />

    <Comment
      v-for="comment in comments"
      v-bind:key="comment"
      :comment="comment"
    />

  </div>
</template>

<script>
import axios from "axios";
import Comment from "@/components/Comment";

export default {
  components: { Comment },
  name: "CommentList",
  data() {
    return {
      comments: [],
    };
  },

  async created() {
    const payload = {
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "Access-Control-Allow-Origin": "*",
        Authorization: "Bearer " + this.$store.state.auth.auth.token,
      },
    };

    try {
      const res = await axios.get(
        this.$config.BACKEND_URI + "/admin/comments",
        payload
      );
      this.comments = res.data.data;
      for (const comments of this.comments) {
        comments.date = this.convertDateTime(comments.date);
      }
    } catch (error) {
      console.log("TERRIBLE ERROR:", error);
    }
  },

  methods: {
    convertDateTime(time) {
      const dateTime = new Date(time);
      return (
        dateTime.toLocaleDateString() + " - " + dateTime.toLocaleTimeString()
      );
    },
  },
};
</script>
