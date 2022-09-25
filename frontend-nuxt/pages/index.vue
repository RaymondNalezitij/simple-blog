<template>
<div>
  <NavBar/>
  {{ this.$store.state.auth }}
  <Blog/>
</div>
</template>

<script>
import Vue from 'vue'

export default Vue.extend({
  name: 'IndexPage'
})
</script>
