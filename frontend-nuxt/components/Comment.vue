<template>
  <div v-if="!isClosed"
  class="main-section"
  >
    <div v-if="this.validationErrors">
      <div
        class="error-messages"
        v-for="(message, error) in this.validationErrors"
      >
        {{ message }}
      </div>
    </div>

    <div class="user-section">
      <div>{{ comment.name }}</div>
      <div>&ensp;&bull; {{ comment.date }}</div>
    </div>
    <div class="comment">{{ comment.comment }}</div>

    <div class="change-section">
    <input class="remove-button"
      type="button"
      value="Remove"
      v-if="this.isAdmin"
      v-on:click="removeComment"
    />

    <nuxt-link class="edit-button" v-if="this.isAdmin" :to="'/comment/' + comment.id">
      Edit Comment
    </nuxt-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Comment",
  props: ["comment"],

  data() {
    return {
      isAdmin: false,
      validationErrors: false,
      isClosed: false,
    };
  },

  created() {
    if (this.$store.state.auth.auth) {
      if (this.$store.state.auth.auth.type === "Admin") {
        this.isAdmin = true;
      }
    }
  },

  methods: {
    async removeComment() {
      const payload = {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        await axios.delete(
          this.$config.BACKEND_URI + "/admin/comments/" + this.comment.id,
          payload
        );
      } catch (error) {
        if (error.response) {
          this.validationErrors = error.response.data.errors;
        }
        console.log("TERRIBLE ERROR:", error);
        return;
      }

      this.isClosed = true;
    },
  },
};
</script>

<style scoped>

.main-section {
    padding-left: 20px;
    padding-top: 10px
}

.user-section {
  display: flex;
  flex-direction: row;
  padding: 20px 0 5px 0;
}

.comment {
  padding: 0 25px 0 25px;
}

.change-section {
  padding: 20px;
}

.edit-button {
  margin-left: 15px;
}

.remove-button {
  color: red;
  border-radius: 10px;
}
</style>