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

    {{ user }}
    
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "User",

  data() {
    return {
      user: null,
      validationErrors: null,
      user_name: null,
      user_email: null,

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
          this.$config.BACKEND_URI + "/admin/users/" + this.$route.params.id,
          payload
        );
        this.user = res.data.data;

        this.user_name = this.user.name;
        this.user_email = this.user.email;

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
        name: this.user_name,
        email: this.user_email,
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