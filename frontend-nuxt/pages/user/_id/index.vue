<template>
  <div>
    <NavBar />

    <form ref="formName" @submit.prevent="onSubmit">
      <div class="change-user">
        <div v-if="this.validationErrors">
          <div
            class="error-messages"
            v-for="(message, error) in this.validationErrors"
          >
            {{ message }}
          </div>
        </div>

        <div class="input-section">
          <v-label>User Name</v-label>
          <input
            class="input"
            type="text"
            v-model="user_name"
            placeholder="User Name"
            required
          />
        </div>

        <div class="input-section">
          <v-label>Email</v-label>
          <input
            class="input"
            type="email"
            v-model="user_email"
            placeholder="Email"
            required
          />
        </div>

        <input class="button" type="submit" value="Change" />
      </div>
    </form>
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
    }
  },

  methods: {
    async onSubmit() {
      const payload = {
        "name": this.user_name,
        "email": this.user_email,
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        await axios.put(
          this.$config.BACKEND_URI + "/admin/comments/" + this.$route.params.id,
          payload
        );
        alert("Successfully Changed!");
      } catch (error) {
        alert("Not Changed!");
        if (error.response) {
          
          this.validationErrors = error.response.data.errors;
        }
      }
    },
  },
};
</script>

<style scoped>
.change-user {
  display: flex;
  flex-direction: column;
  width: 330px;
  padding-left: 20px;
  padding-top: 20px;
}

.input-section {
  display: flex;
  flex-direction: row;
  padding-top: 10px;
  justify-content: space-between;
}

.input {
  border-radius: 10px;
  padding: 5px;
  width: 160px;
}

.button {
  border-radius: 10px;
  padding: 5px;
  cursor: pointer;
  justify-content: end;
  margin-top: 10px;
  width: 100px;
  cursor: pointer;
}

.error-messages {
  color: red;
}
</style>