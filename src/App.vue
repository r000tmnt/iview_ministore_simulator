<template>
  <div id="app">
    <Head></Head>
    <img_slider></img_Slider>
    <the-shop></the-shop>
  </div>
</template>

<script>
import Head from './components/head_bar.vue'
import img_slider from './components/img_slider.vue'
import theShop from './components/shop.vue'

export default {
  name: 'App',
  components: {
    Head, img_slider, theShop
  }
}
</script>

<style>
body{
  margin: 0;
  padding: 0;
  background-color: #f8f8f9;
  overflow-x: hidden;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
