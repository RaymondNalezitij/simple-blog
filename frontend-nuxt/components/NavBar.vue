<template>
<div>
    <a slot="brand" class="navbar-brand" href="/">Navbar</a>
    <nuxt-link :to="'/login'">
        Login
    </nuxt-link>
    <nuxt-link :to="'/admin/dashboard'">
        Admin Dashboard
    </nuxt-link>
    <nuxt-link :to="'/'" v-if="this.$store.state.auth.auth">
        {{ this.$store.state.auth.auth.name }}
    </nuxt-link>


</div>
  
</template>