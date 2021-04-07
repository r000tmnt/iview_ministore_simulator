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
          <li>登入</li>
          <li>購物車</li>
        </ul>
      </nav>
    </Col>
  </Row>
</template>

<script>
export default {
  name: 'head_bar',
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/*div {  Both Row & Col are compiled as div, work as display flex? 
  background-color: #42b983;
} */
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
</style>
