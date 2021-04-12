<template>
  <Row> 
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
          <li><Button class="shopping_cart" type="text" @click="openCart"><span class="list_count" v-if="$parent.list_count > 0">{{$parent.list_count}}</span><Icon type="md-cart" />購物車</Button></li>
        </ul>
      </nav>
    </Col>
  </Row>
</template>

<script>

export default {
  name: 'head_bar',
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
}
</style>
