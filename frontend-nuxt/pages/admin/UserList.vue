<template>
  <div>
    <NavBar />

    <form ref="formName" @submit.prevent="addNew">
      <div class="add-user">
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
            v-model="new_user_name"
            placeholder="User Name"
            required
          />
        </div>

        <div class="input-section">
          <v-label>Email</v-label>
          <input
            class="input"
            type="email"
            v-model="new_user_email"
            placeholder="Email"
            required
          />
        </div>

        <div class="input-section">
          <v-label>Password</v-label>
          <input
            class="input"
            type="password"
            v-model="new_user_password"
            required
          />
        </div>

        <div class="input-section">
          <v-label>Password Confimration</v-label>
          <input
            class="input"
            type="password"
            v-model="new_user_password_confirmation"
            required
          />
        </div>

        <input class="button" type="submit" value="Add User" />
      </div>
    </form>

    <User v-for="user in users" v-bind:key="user" :user="user" />

  </div>
</template>

<script>
import axios from "axios";
import User from "@/components/User";

export default {
  components: { User },
  name: "UserList",

  data() {
    return {
      users: [],
      new_user_name: null,
      new_user_email: null,
      new_user_password: null,
      new_user_password_confirmation: null,
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
      const res = await axios.get(this.$config.BACKEND_URI + "/admin/users", payload);

      this.users = res.data.data;
    } catch (error) {
      console.log("TERRIBLE ERROR:", error);
    }
  },

  methods: {
    async addNew() {
      const payload = {
        name: this.new_user_name,
        email: this.new_user_email,
        password: this.new_user_password,
        password_confirmation: this.new_user_password_confirmation,

        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        const res = await axios.post(
          this.$config.BACKEND_URI + "/admin/users",
          payload
        );

        this.users = res.data.data;
      } catch (error) {
        console.log("TERRIBLE ERROR:", error);
      }
    },
  },
};
</script>

<style scoped>
.add-user {
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