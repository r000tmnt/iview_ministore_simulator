<template>
  <Row> 
      <div class="modal center">
        <Button type="warning" class="close" @click="shopClose"></Button>
        <main class="shelf flex">
          <Col span="7" v-for="(product, index) in products" :key="product.id">
            <Card class="card">
              <h1>{{product.name}}</h1>
              <div class="product">
                <img :src="product.path" alt="cake">
              </div>
              <p>${{product.price}}</p>
              <ul>
                <li><Button type="info"><Icon type="md-more" />詳細</Button></li>
                <li><Button type="primary" @click="addToCart(index)"><Icon type="md-add-circle" />加入購物車</Button></li>
              </ul>
              <div class="cart-note" v-if="pushed_items[index].push === true">
                <Icon type="md-cart" />
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
  data(){
      return{
          products: [],
          pushed_items: [],
          temp_cart: []
      }
  },
  methods: {
    shopClose(){
      this.$parent.shop_open = false;
    },
    addToCart(index){
      if(this.temp_cart.length > 0){
        console.log('temp_cart is full')
      }else{
        console.log('Push to temp_cart')
        this.temp_cart.push({name: this.products[index].name, amount: 1, price: this.products[index].price})

        if(Object.keys(this.temp_cart).length > 0){
          this.$emit('getCart', this.temp_cart)
          this.temp_cart = []
          this.pushed_items[index].push = true
        }
      }
    }
  },
  created(){
      let vm = this
      vm.$https.get('http://localhost/iview_ministore_simulation/src/php/get_images.php').then(response => {
          for(let i=0; i < response.data.length; i++){
              vm.products.push(response.data[i])
              vm.pushed_items.push({id: response.data[i].ID, push: false})
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
}

.center{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.shelf{
  background-image: url('../assets/Grass-Texture.jpg');
}

.flex{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.close{
  width: 22px;
  border-radius: 50%;
  margin: 1% 2% 0 0;
  position: absolute;
  margin-left: 46vw;
}

.close::after{
  content: 'X';
  margin-left: -5px;
}

.card{
    margin: 2%;
    /* background: linear-gradient(0deg, #582209, #ffbc0059); */
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
  height: 50vh;
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
  font-size: 1.2rem;
  margin: -10px -10px 0 0;
}
</style>
