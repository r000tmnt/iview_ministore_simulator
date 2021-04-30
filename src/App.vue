<template>
  <div id="app">
    <head-bar></head-bar>

    <transition-group :name="fade? 'fadeIn' : 'fadeOut'">
      <shopping-cart v-if="cart_open === true" :prepareCart="sorted_cart" @cart_close="closeTheCart($event)" @modal_switch="switch_modal($event)" @cart_clear="clearTheCart($event)" @count_list="listCount($event)" key="cart"></shopping-cart>
    </transition-group>
    
    <img_slider></img_Slider>
    <div id="message">
      <h1>適度的休息，<br>
        是開起精神的好夥伴</h1>
    </div>

    <button class="goToshop" @click="openShop"><Icon type="md-pizza" />購物去</button>
    
    <transition-group :name="fade? 'fadeIn' : 'fadeOut'">
      <the-shop v-if="shop_open === true" :listCount="list_count" :pushID="pushed_id" :deleteID = delete_id @getCart="getTheCart($event)" @close_shop="closeTheShop($event)" key="shop"></the-shop>      
    </transition-group>

    <footer>
      <ul>
        <li>聯絡人: 鄭秀美</li>
        <li>電話: 0922846018</li>
        <li>信箱: <a class="font-color" href="mailto:a0922846018@gmail.com">a0922846018@gmail.com</a></li>
      </ul>

      <div class="copyRight"><h4>&copy;Biken ministore 2021</h4></div>
    </footer>
  </div>
</template>

<script>
import headBar from './components/head_bar.vue'
import img_slider from './components/img_slider.vue'
import theShop from './components/shop.vue'
import shoppingCart from './components/shopping_cart.vue'

export default {
  name: 'App',
  components: {
    headBar,img_slider, theShop, shoppingCart
  },
  data(){
    return{
      shop_open: false,
      cart_open: false,
      logIn_status: false,
      sorted_cart: [],
      pushed_id: [],
      delete_id: {deleted: false, id: ''},
      list_count: 0,
      same_name: false,
      fade: false
    }
  },
  methods: {
    openShop(){
      this.shop_open = true
      this.fade = true

      let body = document.body
      body.style['overflow'] = 'hidden'
    },

    getTheCart(data){
      if(data !== undefined){
        if(this.sorted_cart.length > 0){
          let car_length = this.sorted_cart.length;
          for(let i=0; i < car_length; i++){
            if(data[0].name === this.sorted_cart[i].name){
              this.same_name = true;
              this.sorted_cart[i].amount++
              this.list_count++
              return this.sorted_cart[i].price = this.sorted_cart[i].price * this.sorted_cart[i].amount
            }else{
              this.same_name = false
            }
          }

          if(this.same_name === false){
            this.sorted_cart[car_length] = data[0]
            this.pushed_id.push(data[0].ID)
            this.list_count++
          }
        }else{
          this.sorted_cart = data
          this.pushed_id.push(data[0].ID)
          this.list_count++
        }
      }
    },

    listCount(set){
      if(set.mode === 'plus'){ this.list_count = this.list_count + set.number }
      if(set.mode === 'clear'){ this.list_count = 0 }
      if(set.mode === 'minus'){ this.list_count = this.list_count -set.number }
      if(set.mode === 'deleteRow'){
        this.list_count = this.list_count - set.number
        this.delete_id= {deleted: true, id: set.delete_id}
        this.pushed_id.splice(set.delete_index, 1)
      }
    },

    closeTheShop(signal){
      this.fade = false
      this.shop_open = signal
    },
    
    closeTheCart(signal){
      this.fade = false
      this.cart_open = signal
    },

    clearTheCart(signal){
      this.sorted_cart.splice(signal)
    },
    
    switch_modal(signals){
      this.cart_open = signals.cart_open
      this.shop_open = signals.shop_open
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
.fadeIn-enter-active, .fadeIn-leave-active {
    transition: all 0.5s ease;
}
.fadeIn-enter{
    opacity: 0;
}

.fadeIn-leave-to{
    opacity: 1;
}

.fadeOut-enter-active, .fadeOut-leave-active {
    transition: all 0.5s ease;
}
.fadeOut-enter{
    opacity: 1;
}

.fadeOut-leave-to{
    opacity: 0;
}

body{
  margin: 0;
  padding: 0;
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
  overflow-x: hidden;  
}

#message{
  margin-top: 10vh;
  display: flex;
  justify-content: center;
}

.goToshop{
  box-sizing: border-box;
  font-size: 2rem;
  padding: .5%;
  border: none;
  border-radius: 10px;
  background-color: orange;
}

.goToshop:hover{
  border-bottom: 3px solid rgb(92, 51, 3);
  transition: border .1s ease;
}

li > a{
  color: #2c3e50
}

li > a:hover{
  color: #328DED;
}
</style>
