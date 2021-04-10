<template>
  <div v-if="prepareCart.length === 0" class="cart_modal">
    <div class="theForm center">
      <h1>尚無商品紀錄</h1>
      <p><Button type="text" @click="switch_modal" ghost>購物請往這邊</Button></p>
      <Button type="warning" @click="close">關閉</Button>
    </div>
  </div>

  <div v-else class="cart_modal">
    <div class="theForm center">
      <h1>您的購物清單</h1>
        <Form id="LoginForm" enctype="multipart/form-data">
          <FormItem>
            <Input class="input" type="text" v-model="userForm.username" placeholder="名稱" />
          </FormItem>

          <FormItem>
            <Input class="input" type="tel" v-model="userForm.phone" placeholder="電話" />
          </FormItem>
          
          <FormItem v-for="(item, index) in theCart" :key="item.ID">
            <div class="thumbnail">
              <img :src="item.pic" alt="thumbnail">
            </div>            
            <label for="amount">{{item.name}}</label>
            <Input class="number" type="number" v-model="item.amount" placeholder="價格" :value="item.amount" autosize @on-change="price_recount(index, JSON.parse(item.amount))"/>
            <span class="price">{{item.price}} 元</span>
            <Button type="error" class="del" @click="deleteRow(index)"></Button>
          </FormItem>
          總金額: {{userForm.total}} 元
          <br>
          <p><Button type="text" @click="switch_modal" ghost>繼續購物</Button></p>
          <ButtonGroup>
              <Button type="success" @click="submit_cart">送出</Button>
              <Button type="warning" @click="close">取消</Button>
          </ButtonGroup>
        </Form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'shoppingCart',
  props: {
    prepareCart: {}
  },
  data(){
    return{
        theCart: [],
        userForm: {username: '', phone: '', total: 0},
        one_price: [],
        old_amount: []
    }
  },
  methods: {
    close(){
      this.$parent.cart_open = false
    },

    price_recount(index, amount){
      if(amount <= 0){
        this.theCart[index].price = 0
      }else{
        this.theCart[index].price = this.one_price[index] * amount
      }

      if(this.theCart[index].old_amount < amount){
        this.userForm.total = this.userForm.total + this.one_price[index]
        this.old_amount[index]++
        this.$parent.list_count++
      }else{
        if(this.userForm.total - this.one_price[index] <= 0){
          this.userForm.total = 0
          this.old_amount[index] = 0
          this.$parent.list_count = 0
        }else{
          this.userForm.total = this.userForm.total - this.one_price[index]
          this.old_amount[index]--
          this.$parent.list_count--
        }
      }  
    },

    deleteRow(index){
      this.$parent.list_count = this.$parent.list_count - this.theCart[index].amount
      this.theCart.splice(index, 1)
    },

    switch_modal(){
      this.$parent.shop_open = true
      this.$parent.cart_open = false
    },

    submit_cart(){
      let vm = this
      let formData = new FormData()
      formData.append('username', vm.userForm.username)
      formData.append('phone', vm.userForm.phone)
      formData.append('list', JSON.stringify(vm.theCart))
      formData.append('total', vm.userForm.total)

      if(vm.userForm.username === '' || vm.userForm.phone === ''){
        alert('請確實填入聯絡資料')
      }else{
        vm.$https.post('http://localhost/iview_ministore_simulation/src/php/toCart.php', formData).then(response => {
          console.log(response)
        }).catch(error => console.log(error))          
      }
    }
  },
  created(){
    this.theCart = this.prepareCart
    var setPrice = new Array()
    if(this.prepareCart.length > 0){
      for(let i=0; i < this.theCart.length; i++){
        setPrice.push(this.theCart[i].price)
        this.one_price[i] = this.theCart[i].price / this.theCart[i].amount
        this.old_amount[i] = this.theCart[i].amount
      }
      this.userForm.total = setPrice.reduce( function(a, b){ return a+b}, 0)      
    }
  }
}
</script>

<style>
.center{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.cart_modal{
  width: 100vw;
  height: 100vh;
  background: rgba(51, 42, 34, 0.7);
  position: absolute;
  margin-top: -10vh;
  z-index: 3;
}

.theForm{
  width: 500px;
  /* border: 1px solid red; */
  border-radius: 10px;
  padding: 1%;
  background: #f8f8f9;
  z-index: 2;
}

p > button{
  color: #232!important;
}

P > button:hover{
  color: steelblue!important;
}

.thumbnail{
  width: 50px;
  height: 50px;
  display: inline-block;
}

.thumbnail > img{
  max-width: 100%;
  max-height: 100%;
  top:16%;
  transform: translateY(16%);
}

label{
  margin: 0 1vw;
  vertical-align: middle;
}

.input{
  width: 25vw!important;
}

.number{
  width: 5vw!important;
  margin: 0 .5vw;
}

.price{
  color: gray;
}

.del{
  width: 22px;
  margin-left: 15px;
}

.del::after{
  content: 'X';
  margin-left: -5px;
}

ul> li{
  list-style: none;
}
</style>
