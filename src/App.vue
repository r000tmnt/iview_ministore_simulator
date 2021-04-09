<template>
  <div id="app">
    <head-bar></head-bar>
    {{sorted_cart}}
    <img_slider></img_Slider>
    <div id="message">
      <h1>適度的休息，<br>
        是開起精神的好夥伴</h1>
    </div>
    <button class="goToshop" @click="openShop"><Icon type="md-pizza" />購物去</button>
    <the-shop v-if="shop_open === true" @getCart="getTheCart($event)"></the-shop>
  </div>
</template>

<script>
import headBar from './components/head_bar.vue'
import img_slider from './components/img_slider.vue'
import theShop from './components/shop.vue'

export default {
  name: 'App',
  components: {
    headBar,img_slider, theShop
  },
  data(){
    return{
      shop_open: false,
      logIn_status: false,
      sorted_cart: [],
      same_name: false
    }
  },
  methods: {
    openShop(){
      this.shop_open = true
    },

    getTheCart(data){
      console.log(data[0])

      if(data !== undefined){
        if(this.sorted_cart.length > 0){
          let car_length = this.sorted_cart.length;
          for(let i=0; i < car_length; i++){
            if(data[0].name === this.sorted_cart[i].name){
              this.same_name = true;
              return this.sorted_cart[i].amount++
            }else{
              this.same_name = false
            }
          }

          if(this.same_name === false){
            this.sorted_cart[car_length] = data[0]
          }
        }else{
          this.sorted_cart = data
          console.log(this.sorted_cart[0])
        }
      }
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
