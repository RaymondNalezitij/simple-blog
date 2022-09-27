<template>
    <div>
        <NavBar/>
        {{ categories.length }}
        <form v-for="category in categories" v-bind:key="category" :id="category.id">

            <input type="button" value="Remove"
                v-on:click="removeCategory"/>
            <input type="text" name="category" :value="category.name">
            <input type="button" value="Change"
                v-on:click="changeCategory"/>
                
        </form>
    </div>
</template>

<script>
import axios from 'axios';


export default {
    name: 'CategoryList',

    data() {
        return {
            categories: [],
        }

    },

    async created() {

        const payload = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                // 'Authorization': 'Bearer ' + this.$store.state.auth.auth.token,
            }
        }

        try {
            const res = await axios.get('http://127.0.0.1:8000/api/categories', payload);
            
            this.categories = res.data.data;
            
        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }
    },

    methods: {

        async removeCategory(event) {
            // console.log("FROM REMOVE: ", event.explicitOriginalTarget.parentElement.id);
            const id = event.explicitOriginalTarget.parentElement.id;
                    const payload = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Authorization': 'Bearer ' + this.$store.state.auth.auth.token,
            }
        }

        try {
            await axios.delete('http://127.0.0.1:8000/api/admin/categories/'
                + id,
                payload
            );
        } catch (error) {
            console.log("TERRIBLE ERROR:", error);
        }

        },

        changeCategory(event) {
            const form = event.explicitOriginalTarget.parentElement;
            console.log("FROM CHANGE:", form.category.value);
        }
    }

}
</script>
