<template>
  <div id="app">
    <navbar v-if="this.$route.path !== '/'"></navbar>
    <router-view></router-view> 
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
export default {
  name: 'app',
  components: {
    Navbar
  },
  beforeCreate () {
    this.$store.dispatch('checkLogin')
  }
}
</script>

<style>
</style>
