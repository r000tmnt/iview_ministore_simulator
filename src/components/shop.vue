<template>
  <Row> 
    <Col span="24" class="center">
      <div class="modal">
        <button class="close" @click="shopClose">X</button>
        <main class="shelf flex">
          <Card class="card" v-for="product in products" :key="product.id">
            <h1>{{product.name}}</h1>
            <div class="product">
              <img :src="product.path" alt="cake">
            </div>
            <p>price: NAN</p>
            <button>加入購物車</button>
        </Card>
        </main>      
      </div>
    </Col>
  </Row>
</template>

<script>
export default {
  name: 'theShop',
  data(){
      return{
          products: []
      }
  },
  methods: {
    shopClose(){
      this.$parent.shop_open = false;
    }
  },
  created(){
      let vm = this
      vm.$https.get('http://localhost/iview_ministore_simulation/src/php/get_images.php').then(response => {
          for(let i=0; i < response.data.length; i++){
              vm.products.push(response.data[i])
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

.flex{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.close{
  width: 22px;
  border-radius: 50%;
  border: none;
  background-color: gray;
  float: right;
  margin: 1% 2% 0 0;
}

.card{
    margin: 0.5%;
}

h1{
    border-bottom: 1px solid gray;
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
  display: flex;
  flex-flow: row-reverse;
  font-size: 1.5rem;
}

ul > li{
  list-style: none;
  margin: 0 1%;
}
</style>
