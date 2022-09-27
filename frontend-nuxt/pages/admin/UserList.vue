<template>
    <div>
        <NavBar/>

        <div v-for="user in users" v-bind:key="user">

            {{ user.name }}

        </div>
    </div>
</template>

<script>
import axios from 'axios';


export default {
    name: 'UserList',

    data() {
        return {
            users: [],
        }

    },

    async created() {

        const payload = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Authorization': 'Bearer ' + this.$store.state.auth.auth.token,
            }
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/admin/users', payload);
            
            this.users = res.data.data;
            
        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }
    },

    methods: {

    }

}
</script>
