<template>
  <div>
    <NavBar />

    <div v-if="this.validationErrors">
      <div
        class="error-messages"
        v-for="(message, error) in this.validationErrors"
      >
        {{ message }}
      </div>
    </div>

    <form ref="formName" @submit.prevent="onSubmit">
      <div class="change-comment">
          <input
            class="user-input"
            type="text"
            v-model="user_value"
            required
          />

        <textarea
          class="comment-input"
          v-model="comment_value"
          required
        ></textarea>
        <input class="button" type="submit" value="Change Comment" />
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Comment",

  data() {
    return {
      comment: null,
      validationErrors: null,
      user_value: null,
      comment_value: null,
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
          this.$config.BACKEND_URI + "/admin/comments/" + this.$route.params.id,
          payload
        );
        this.comment = res.data.data;

        this.comment.date = this.convertDateTime(this.comment.date);
        this.comment_value = this.comment.comment;
        this.user_value = this.comment.name;

      } catch (error) {
        if (error.response) {
          this.validationErrors = error.response.data.errors;
        }
        console.log("TERRIBLE ERROR:", error);
      }
  },

  methods: {
    async onSubmit() {

      const payload = {
        user_name: this.user_value,
        comment: this.comment_value,
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        await axios.put(
          this.$config.BACKEND_URI +
            "/admin/comments/" +
            this.$route.params.id,
          payload
        );
        alert("Successfully Changed!");

      } catch (error) {
        if (error.response) {
          alert("Not Changed!");
          this.validationErrors = error.response.data.errors;
        }
        console.log("TERRIBLE ERROR:", error);

      }
    },

    convertDateTime(time) {
      const dateTime = new Date(time);
      return (
        dateTime.toLocaleDateString() + " - " + dateTime.toLocaleTimeString()
      );
    },
  },
};
</script>

<style scoped>
.change-comment {
  display: flex;
  flex-direction: column;
  margin-left: 20px;
  margin-top: 20px;
}

.user-input {
  border-radius: 10px;
  padding: 5px;
  padding-bottom: 3px;
  margin-top: 10px;
  width: 150px;
}

.comment-input {
  border-radius: 10px;
  padding: 5px;
  margin-top: 10px;
  width: 330px;
  height: 90px;
}

.button {
  border-radius: 10px;
  padding: 5px;
  margin-top: 10px;
  width: 130px;
  cursor: pointer;
}

.error-messages {
  color: red;
}
</style>