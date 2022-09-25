<template>
  <div>
    <NavBar/>
    {{ this.$store.state.auth }}
    <!-- <nuxt-link :to="'/admin/dashboard'">
        Admin Dashboard
    </nuxt-link> -->

    <form @submit.prevent="onSubmit">
      <div>
        <v-label>Email</v-label>
        <input type="text" v-model="user_email" placeholder="User Email" required>
      </div>
      <div>
        <v-label>Password</v-label>
        <input type="text" v-model="user_password" placeholder="User Password" required> 
      </div>
      <div>
        <input type="submit" value="Login">
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import Dashboard from './admin/Dashboard.vue';

export default {
  components: { Dashboard },
  data() {
    return {
      //
    }
  },
  methods: {
    async onSubmit() {
        
        const payload = {
            email: this.user_email,
            password: this.user_password,
        };

        try {
        const response = await axios.post("http://127.0.0.1:8000/api/login", payload);
        this.$store.commit('auth/set', response.data.data);
        console.log("Loging OK!");
        console.log(this.$store.state.auth);
        
        } catch (error) {
            console.log(error);
        }
    }
  }
}
</script>
