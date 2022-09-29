<template>
  <div>
    <NavBar />
    <div class="main-section">
    <form ref="formName" @submit.prevent="addNew">
      <div class="add-category">
        <input
          class="name-input"
          type="text"
          v-model="category_name"
          placeholder="New Category"
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

    <div class="category-section">
      <input class="button" type="button" value="Remove" v-on:click="removeCategory" />
      <input class="name-input" type="text" name="category" :value="category.name" />
      <input class="button" type="button" value="Change" v-on:click="changeCategory" />
      </div>
    </form>
    
    </div>
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
          "Accept": "application/json",
          "Access-Control-Allow-Origin": "*",
          "Authorization": "Bearer " + this.$store.state.auth.auth.token,
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

<style scoped>
.main-section {
    padding-left: 20px;
    padding-top: 20px
}

.add-category {
  padding: 10px;
}

.name-input {
  border-radius: 10px;
  padding: 5px;
}

.button {
  border-radius: 10px;
  padding: 5px;
  cursor: pointer;
  margin-left: 8px;
  margin-right: 8px;
}

.category-section {
  padding-top: 15px;
}
</style>