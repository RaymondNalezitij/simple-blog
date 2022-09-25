<template>
<div>
    <a slot="brand" class="navbar-brand" href="#">Navbar</a>
    <nuxt-link :to="'/login'">
        Login
    </nuxt-link>
    <nuxt-link :to="'/admin/dashboard'">
        Admin Dashboard
    </nuxt-link>

</div>
  
</template>