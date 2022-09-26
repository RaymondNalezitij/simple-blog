<template>
<div>
    <div class="nav-bar">

        <div class="side-links">
            <nuxt-link class="menu-item" :to="'/'">Posts</nuxt-link>
            <nuxt-link class="menu-item" :to="'/login'">Login</nuxt-link>
        </div>

    <div class="side-links" v-if="this.$store.state.auth.auth">
    <nuxt-link class="menu-item" :to="'/admin/dashboard'" v-if="this.$store.state.auth.auth.type == 'Admin'">
        Admin Dashboard
    </nuxt-link>
    <div class="menu-item" :to="'/'" v-if="this.$store.state.auth.auth">
        {{ this.$store.state.auth.auth.name }}
    </div>
    </div>

    </div>

</div>
  
</template>

<style scoped>
.nav-bar {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 2px 2px 20px 2px;
    background-color: burlywood;
}

.side-links {
    display: flex;
    flex-direction: row;
}

.menu-item {
    padding: 0 20px;
}
</style>