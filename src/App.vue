<template>
  <div id="app">
    <Head></Head>
    {{cart}}
    <img_slider></img_Slider>
    <div id="message">
      <h1>適度的休息，<br>
        是開起精神的好夥伴</h1>
    </div>
    <button class="goToshop" @click="openShop"><Icon type="md-pizza" />購物去</button>
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
    Head,img_slider, theShop
  },
  data(){
    return{
      shop_open: false,
      logIn_status: false,
      cart: []
    }
  },
  methods: {
    openShop(){
      this.shop_open = true
    }
  },
  created(){ //Check login or not
    if(this.logIn_status === false){
      this.form_active = true
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
  background-image: linear-gradient(#fff, hsla(36, 100%, 78%, 0.7)), url('./assets/blanket.jpg');
  background-size: contain;
}

#message{
  margin-top: 10vh;
  display: flex;
  justify-content: center;
}

.goToshop{
  font-size: 2rem;
  padding: .5%;
  border: none;
  border-radius: 10px;
  background-color: orange;
}

.goToshop:hover{
  border-bottom: 3px solid rgb(92, 51, 3);
}
</style>
