<template>
    <div>
        Hello: {{ auth }}
        Hello: {{ auth.auth.token }}
    </div>
</template>

<script>
import axios from 'axios';


export default {
    name: 'Dashboard',
    props: ['auth'],

    data() {
        return {
            users: [],
            auth: null,
        }

    },

    async created() {

        this.auth = this.$store.state.auth;

        console.log("Hello from dashboard", this.auth);
        console.log("Token:", this.auth.token);

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
            
            console.log(this.users);


        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }
    },

    methods: {

        convertDateTime(time) {
           const dateTime = new Date(time);
            return dateTime.toLocaleDateString() + ' - ' + dateTime.toLocaleTimeString();
        }
    }

}
</script>
