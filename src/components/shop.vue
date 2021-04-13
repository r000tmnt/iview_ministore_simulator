<template>
  <Row> 
      <div class="modal center">
        <div class="btn_box">
          <Button type="warning" class="btn close" @click="shopClose"></Button> 
          <span class="list_count" v-if="listCount > 0">{{listCount}}</span>                     
          <Button type="primary" icon="md-cart" class="btn toShop" @click="switch_modal"></Button>        
        </div>
        <main class="shelf flex">
          <Col :lg="7" :md="11" :sm="20" v-for="(product, index) in products" :key="product.id">
            <Card class="card">
              <h1>{{product.name}}</h1>
              <div class="product">
                <img :src="product.path" alt="cake">
              </div>
              <p>${{product.price}}</p>
              <ul>
                <!-- <li><Button type="info"><Icon type="md-more" />詳細</Button></li> -->
                <li><Button type="primary" @click="addToCart(index)"><Icon type="md-add-circle" />加入購物車</Button></li>
              </ul>
              <div class="cart-note" v-if="product.push === true">
                已加入
              </div> 
          </Card>
        </Col>
        </main>      
      </div>
  </Row>
</template>

<script>
export default {
  name: 'theShop',
  props: {
    listCount: Number,
    pushID: Array,
    deleteID: Object
  },
  data(){
      return{
          products: [],
          temp_cart: [],
      }
  },
  watch: {
    deleteID: {
      immediate: true,
      deep: true,
      handler(){
        if(this.deleteID.deleted !== false && this.products !== []){
          for(let i=0; i < this.products.length; i++){
            if(this.deleteID.id === this.products[i].ID){
              this.products[i].push = false
            }
          }          
        }

      }
    }

  },
  methods: {
    shopClose(){
      this.$emit('close_shop', false)
    },

    switch_modal(){
      this.$emit('modal_switch', {shop_open: true, cart_open: true})
    },

    addToCart(index){
      this.temp_cart.push({ID: this.products[index].ID, name: this.products[index].name, amount: 1, price: JSON.parse(this.products[index].price), pic: this.products[index].path})

      if(Object.keys(this.temp_cart).length > 0){
        this.$emit('getCart', this.temp_cart)
        this.temp_cart = []
        this.products[index].push = true
      }
    }
  },
  created(){
      let vm = this
      vm.$https.get('http://localhost/iview_ministore_simulation/src/php/get_images.php').then(response => {
          for(let i=0; i < response.data.length; i++){
              vm.products.push(response.data[i])
              vm.products[i].push = false
          }

          if(this.pushID.length > 0){
            for(let i=0; i < vm.pushID.length; i++){
              let thepushedID = vm.pushID[i]
                for(let j=0; j < vm.products.length; j++){
                  if(vm.products[j].ID === thepushedID){
                    vm.products[j].push = true
                  }
                }              
            }            
          }  
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.modal{
  width: 100vw;
  height: 100vh;
  background-color: white;
  overflow-x: auto;
  background-image: url('../assets/Grass-Texture.jpg');
}

.center{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.shelf{
  padding: 5vh 0;
}

.flex{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.btn_box{
  position: sticky;
  top: 0;
  display: flex;
  flex-direction: row-reverse;
  width: 98vw;
  z-index: 2;
  padding: .5% .5% 0 0;
}

.list_count{
  width: 20px;
  border: 1px solid lightblue;
  border-radius: 50%;
  background: white;
  color: #5AA4F0;
  position: absolute;
  margin: 2px 65px 0 0;
  font-size: .1rem;
  font-weight: bold;
}

.btn{
  border-radius: 50%;
  margin: 0.5% 0 0 0;
}

.toShop{
  margin-right: 10px;
}

.close{
  width: 22px;
}

.close::after{
  content: 'X';
  margin-left: -5px;
}

.card{
    margin: 2%;
    transition: all 0s ease;
}

h1{
    border-bottom: 1px solid gray;
}

p{
  margin: 2%;
  font-size: 1.5rem;
  color: goldenrod
}

.product{
  width: 25vw;
  height: 40vh;
}

.product > img{
  max-width: 100%;
  max-height: 100%;
}

nav{
  transform: translateY(1vh);
  padding: 1%
}

ul{
  margin-top: 5px;
  display: flex;
  justify-content: center;
}

ul > li{
  list-style: none;
  margin: 0 1%;
}

.cart-note{
  float: right;
  margin: -10px -8px 0 0;
}

@media screen and (max-width: 991px){
  .btn_box{
    width: 97vw;
    margin-top: 7px;
  }
  .product{
    width: unset;
    height: unset;
  }
}

@media screen and (max-width: 576px){
  .btn_box{
    margin-top: 8vh;
  }

  .shelf{
    padding-top: unset;
  }

  .card{
    margin: 2% 0;
  }
}
</style>
