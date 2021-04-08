<template>
  <div id="app">
    <Head></Head>
    <img_slider></img_Slider>
    <div id="message">
      <h1>打適度的休息，<br>
        是開精神的好夥伴</h1>
    </div>
    <button class="goToshop" @click="openShop">購物去</button>
    <the-shop v-if="shop_open === true"></the-shop>
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
  },
  data(){
    return{
      shop_open: false
    }
  },
  methods: {
    openShop(){
      this.shop_open = true
    }
  }
}
</script>

<style>
body{
  margin: 0;
  padding: 0;
  overflow-x: hidden;
}

#app {
  height: 100vh;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background: linear-gradient(white 5%, #ffd28e 95%);
}

#message{
  margin-top: 10vh;
  display: flex;
  justify-content: center;
}

.goToshop{
  width: 100px;
  height: 30px;
  font-size: 1.2rem;
  border: none;
  border-radius: 10px;
  background-color: orange;
}

.goToshop:hover{
  border-bottom: 2px solid rgb(92, 51, 3);
}
</style>
