<template>
  <div>
      <div v-if="this.validationErrors">
        <div class="error-messages" v-for="(message, error) in this.validationErrors">
          {{ message }}
        </div>
      </div>

    <div class="headline">
      <input
        type="button"
        value="Remove"
        v-if="this.isAdmin"
        v-on:click="removeArticle"
      />

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
import axios from "axios";

export default {
  name: "Title",
  props: ["article"],

  data() {
    return {
      isAdmin: false,
      validationErrors: null,
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
    async removeArticle() {

      console.log("ARTICLE_ID:", this.article.id);
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
          this.$config.BACKEND_URI + "/articles/" + this.article.id,
          payload
        );
      } catch (error) {
          if (error.response) {
            this.validationErrors = error.response.data.errors;
          }
        console.log("TERRIBLE ERROR:", error);
      }

    },
  },
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
