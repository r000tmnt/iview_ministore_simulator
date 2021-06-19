<template>
  <div id="app">
    <head-bar :open="shop_open" @close_all="closeModal($event)"></head-bar>

    <transition-group :name="fade? 'fadeIn' : 'fadeOut'">
      <shopping-cart v-if="cart_open === true" :prepareCart="sorted_cart" @cart_close="closeModal($event)" @modal_switch="switch_modal($event)" @cart_clear="clearTheCart($event)" @count_list="listCount($event)" key="cart"></shopping-cart>
    </transition-group>
    
    <img-slider :productImgs="product_imgs"></img-Slider>
    <div id="message">
      <h1>適度的休息，<br>
        是開起精神的好夥伴</h1>
    </div>

    <button class="goToshop" @click="openShop">挑麵包</button>
    
    <transition-group :name="fade? 'fadeIn' : 'fadeOut'">
      <the-shop v-if="shop_open === true" :Fullproduct="full_product" :listCount="list_count" :pushID="pushed_id" :deleteID = delete_id @getCart="getTheCart($event)" @close_shop="closeModal($event)" key="shop"></the-shop>      
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
import imgSlider from './components/img_slider.vue'
import theShop from './components/shop.vue'
import shoppingCart from './components/shopping_cart.vue'

export default {
  name: 'App',
  components: {
    headBar,imgSlider, theShop, shoppingCart
  },
  data(){
    return{
      product_imgs: [],
      full_product: [],
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
    getImgs(){
      let vm = this
      vm.$https.get('http://localhost/iview_ministore_simulation/src/php/get_images.php').then(response => {
          for(let i=0; i < response.data.length; i++){
              vm.product_imgs.push(response.data[i].path)
              vm.full_product.push(response.data[i])
          }
      })      
    },

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

    closeModal(signal){
      this.fade = false
      if(signal.location === 'shop') { this.shop_open = signal.open }
      if(signal.location === 'cart') { this.cart_open = signal.open }
    },

    clearTheCart(signal){
      this.sorted_cart.splice(signal)
    },
    
    switch_modal(signals){
      this.cart_open = signals.cart_open
      this.shop_open = signals.shop_open
    }
  },
  created(){
    this.getImgs()
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
  margin-top: 5vh;
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
  cursor: pointer;
}

.goToshop:hover{
  border-bottom: 3px solid rgb(92, 51, 3);
  margin-bottom: -3px;
  transition: all .1s ease;
}

li > a{
  color: #2c3e50
}

li > a:hover{
  color: #328DED;
}

footer{
  margin-top: 3vh!important;
}
</style>
