<template>
  <div>
    <NavBar/>
    
    <form ref="formName" @submit.prevent="onSubmit">
      <div class="login-form">
      <div v-if="this.validationErrors">
        <div class="error-messages" v-for="(message, error) in this.validationErrors">
          {{ message }}
        </div>
      </div>
      <div class="input-section">
        <v-label>Email</v-label>
        <input class="input" type="email" v-model="user_email" placeholder="User Email" required>
      </div>
      <div  class="input-section">
        <v-label>Password</v-label>
        <input class="input" type="password" v-model="user_password" placeholder="User Password" required> 
      </div>
      
        <input class="button" type="submit" value="Login">
      
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {

  data() {
    return {
      validationErrors: null,
    }
  },
  methods: {
    async onSubmit() {

      this.validationErrors = null;
        
      const payload = {
        email: this.user_email,
        password: this.user_password,
      };

      try {
        const response = await axios.post(this.$config.BACKEND_URI + "/login", payload);
        this.$store.commit('auth/set', response.data.data);
        this.$refs.formName.reset();
        
      } catch (error) {

          if (error.response) {
            this.validationErrors = error.response.data.errors;
          }
      }
    }
  }
}
</script>

<style scoped>
.login-form {
  display: flex;
  flex-direction: column;
  padding-left: 20px;
  padding-top: 10;
  width: 330px;
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
  width: 50px;
  cursor: pointer;
}

.error-messages {
  color: red;
}
</style>