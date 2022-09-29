<template>
  <div v-if="!isClosed" class="main-section">
    <div v-if="this.validationErrors">
      <div
        class="error-messages"
        v-for="(message, error) in this.validationErrors"
      >
        {{ message }}
      </div>
    </div>

    <div class="user-section">
      <input
        class="remove-button"
        type="button"
        value="Remove"
        v-on:click="removeUser"
      />
      <div>{{ user.name }}</div>
      <nuxt-link
        class="edit-button"
        :to="'/user/' + user.id"
      >
        Edit User
      </nuxt-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "User",
  props: ["user"],

  data() {
    return {
      validationErrors: false,
      isClosed: false,
    };
  },


  methods: {
    async removeUser() {
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
          this.$config.BACKEND_URI + "/admin/user/" + this.user.id,
          payload
        );
      } catch (error) {
        if (error.response) {
          this.validationErrors = error.response.data.errors;
        }
        console.log("TERRIBLE ERROR:", error);
      }

      this.isClosed = true;
    },
  },
};
</script>

<style scoped>
.main-section {
  padding-left: 20px;
  padding-top: 10px;
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
}
</style>