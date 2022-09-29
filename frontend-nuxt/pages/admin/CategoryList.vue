<template>
  <div>
    <NavBar />

    <form ref="formName" @submit.prevent="addNew">
      <div class="add-category">
        <input
          class="name-input"
          type="text"
          v-model="category_name"
          placeholder="Category"
          required
        />
        <input class="button" type="submit" value="Add Category" />
      </div>
    </form>

    <form
      v-for="category in categories"
      v-bind:key="category"
      :id="category.id"
    >
      <input type="button" value="Remove" v-on:click="removeCategory" />
      <input type="text" name="category" :value="category.name" />
      <input type="button" value="Change" v-on:click="changeCategory" />
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CategoryList",

  data() {
    return {
      categories: [],
    };
  },

  created() {
    this.fetchCategories();
  },

  methods: {
    async fetchCategories() {
      const payload = {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
        },
      };

      try {
        const res = await axios.get(
          this.$config.BACKEND_URI + "/categories",
          payload
        );

        this.categories = res.data.data;
      } catch (error) {
        console.log("TERRIBLE ERROR:", error);
      }
    },

    async removeCategory(event) {
      const id = event.target.parentElement.id;
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
          this.$config.BACKEND_URI + "/admin/categories/" + id,
          payload
        );

        this.fetchCategories();
      } catch (error) {
        console.log("TERRIBLE ERROR:", error);
      }
    },

    async changeCategory(event) {
      const form = event.target.parentElement;
      // console.log("FROM CHANGE:", form.category.value);
      // console.log("FROM CHANGE:", event.target.parentElement);
      const id = event.target.parentElement.id;
      const name = form.category.value;
      const payload = {
        name: name,
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        await axios.put(
          this.$config.BACKEND_URI + "/admin/categories/" + id,
          payload
        );

        this.fetchCategories();
      } catch (error) {
        console.log("TERRIBLE ERROR:", error);
      }
    },

    async addNew() {
      const payload = {
        name: this.category_name,
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "Access-Control-Allow-Origin": "*",
          Authorization: "Bearer " + this.$store.state.auth.auth.token,
        },
      };

      try {
        await axios.post(
          this.$config.BACKEND_URI + "/admin/categories/",
          payload
        );
      } catch (error) {
        console.log("TERRIBLE ERROR:", error);
        return;
      }

      this.$refs.formName.reset();

      this.fetchCategories();
    },
  },
};
</script>
