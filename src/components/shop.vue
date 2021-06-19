<template>
  <Row> 
      <div class="modal center" :style="{height: windowHeight + 'px'}">
        <Button type="warning" class="btn return" @click="shopClose">
          <Icon type="md-return-left" />
        </Button> 
        <div class="clear"></div>     
        <main class="shelf flex">
          <Col :lg="7" :md="11" :sm="20" v-for="(product, index) in products" :key="product.id">
            <Card class="card">
              <h1>{{product.name}}</h1>
              <div class="product">
                <img :src="product.path" alt="cake" @mouseover="showInfo(index)" @mouseleave="hideInfo(index)">
                <div class="product_info" @load="set_height(index)" ref="ifLineBreak" :style="{opacity: product.transparent, marginTop: product.marginTop + 'vh'}">
                  材料: {{product.recipe}}
                  <br>
                  熱量: {{product.calories}} 大卡
                </div>
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
    Fullproduct: Array,
    listCount: Number,
    pushID: Array,
    deleteID: Object
  },
  data(){
      return{
          products: [],
          temp_cart: [],
          windowHeight: Number,
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
    set_height(info_height, index){
      if(info_height > 60){
        this.products[index].marginTop = -7.7
      }else{
        this.products[index].marginTop = -5.5
      }
    },

    shopClose(){
      const signal = {open: false, location: 'shop'}
      this.$emit('close_shop', signal)

      let body = document.body
      body.style['overflow'] = 'unset'
    },

    addToCart(index){
      this.temp_cart.push({ID: this.products[index].ID, name: this.products[index].name, amount: 1, price: JSON.parse(this.products[index].price), pic: this.products[index].path})

      this.$nextTick(() => {
        if(Object.keys(this.temp_cart).length > 0){
          this.$emit('getCart', this.temp_cart)
          this.temp_cart = []
          this.products[index].push = true
        }        
      })
    },

    showInfo(index){
      this.products[index].transparent = 1
    },

    hideInfo(index){
      this.products[index].transparent = 0
    }    
  },
  created(){
      let vm = this
      for(let i=0; i < vm.Fullproduct.length; i++){
          vm.products.push(vm.Fullproduct[i])
          vm.$set(vm.products[i], 'push', false)
          vm.$set(vm.products[i], 'transparent', 0)
          vm.$set(vm.products[i], 'marginTop', -5.5)
      }

      vm.windowHeight = window.innerHeight - 97

      if(vm.pushID.length > 0){
        for(let i=0; i < vm.pushID.length; i++){
          let thepushedID = vm.pushID[i]
            for(let j=0; j < vm.products.length; j++){
              if(vm.products[j].ID === thepushedID){
                vm.products[j].push = true
              }
            }              
        }            
      }  
  },
  beforeUpdate(){
    let info = this.$refs.ifLineBreak

    for(let i=0; i < info.length; i++){
      this.set_height(info[i].offsetHeight, i)
    }    
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.clear{
  clear: both;
}

.modal{
  width: 100vw;
  background-color: white;
  overflow-x: auto;
  background-image: linear-gradient(#fff, hsla(36, 100%, 78%, 0.7)), url('../assets/blanket.jpg');
  margin-top: 48px;
}

.center{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.shelf{
  width: 80vw;
  margin: 0 auto;
}

.flex{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
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
.toShop{
  margin-right: 10px;
}

.return{
  float: right;
  margin: 1vw 15vw 0;
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

.product > img{
  width: 20vw;
  height: 20vw;
  object-fit: cover;
}

.product_info{
  color: white;
  position: relative;
  background: rgba(34, 51, 34, 0.5);
  padding: 1%;
  transition: all .1s ease;
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
  .return{
    margin: 2vw 13.3vw 0 0;
  }

  .product > img{
    width: 30vw;
    height: 30vw;
  }
}

@media screen and (max-width: 767px){
  .product > img{
    width: 50vw;
    height: 50vw;
  }

  .product_info{
    margin-top: -5.8vh!important;
  }
}

@media screen and (max-width: 576px){
  .product{
    width: 60vw;
  }

  .product > img{
    width: 60vw;
    height: 60vw;
  }  

  .product_info{
    margin-top: -6.5vh!important;
  }

  .card{
    margin: 2% 0;
  }
}

@media screen and (max-width: 375px){
  .shelf{
    width: 100vw;
    margin: unset;
  }

  .product{
    width: 250px;
  }

  .product > img{
    width: 60vw;
    height: 60vw;
  }
}
</style>
