<template>
  <Row class="headBar" :class="{shop_open: open}"> 
    <Col :xs="12">
      <div>
        <a class="logo" href="#">
          <img src="../assets/Biken_LOGO_2021.png" alt="LOGO">
        </a>
      </div>
    </Col>
    <Col :xs="12">
      <nav>
        <ul>
          <!-- <li><Button type="text"><Icon type="md-open" />登入</Button></li> -->
          <li><Button class="shopping_cart" type="text" @click="openCart"><Icon type="md-cart" /><span class="list_count" v-if="$parent.list_count > 0">{{$parent.list_count}}</span>購物車</Button></li>
        </ul>
      </nav>
    </Col>
  </Row>
</template>

<script>

export default {
  name: 'head_bar',
  props: {
    open: Boolean
  },
  methods: {
    openCart(){
      this.$parent.cart_open = true
      this.$parent.fade = true
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.headBar{
  background: white;
  position: relative;
  z-index: 2;
  margin-bottom: 3vh;
}

.shop_open{
  box-shadow: 0px 5px 5px rgba(34, 51, 34, 0.5);
}

.logo{
  float: left;
  width: 150px;
}

.logo > img{
  max-width: 100%;
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

.shopping_cart > span> i{
  float: left;
  margin-top: 3px;
}

.shopping_cart{
  font-size: 1.2rem;
  padding: 0;
}

.list_count{
  float: left;
  width: 20px;
  border-radius: 50%;
  color: #5AA4F0;
  position: absolute;
  margin: -5px 0 0 -35px;
  font-size: .1rem;
  font-weight: bold;  
}
</style>
