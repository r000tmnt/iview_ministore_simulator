<template>
  <div class="cart_modal" :style="{'margin-top': cart_modal_style.modal_top + 'vh'}">
    <div class="theForm center" v-if="theCart.length === 0">
      <h1>尚無商品紀錄</h1>
      <p><Button type="text" @click="switch_modal" ghost>購物請往這邊</Button></p>
      <Button type="warning" @click.stop="close">關閉</Button>
    </div>

 <div class="theForm center" v-else :class="{message_show: cart_pushed.status === true || delete_ask.status === true}">
      <h1 style="margin-top: 0">您的購物清單</h1>
        <Form id="LoginForm" enctype="multipart/form-data">
        <div class="inputs">
          <FormItem label="姓名">
            <Input class="input" type="text" v-model="userForm.username" placeholder="您的大名" />
          </FormItem>

          <FormItem label="電話">
            <Input class="input" type="tel" v-model="userForm.phone" placeholder="09********" />
          </FormItem>          
        </div>

          <div class="list_container" :style="{'height': cart_modal_style.list_height + 'px'}">
            <FormItem class="list_item" v-for="(item, index) in theCart" :key="item.ID">
              <Button type="error" class="del" @click="delete_check(index)" icon="md-trash" ghost></Button>
              <div class="clear"></div>
              <div class="thumbnail">
                <img :src="item.pic" alt="thumbnail">
              </div>
              <div class="item_info">
                <label for="itemName">
                  <h2>{{item.name}}</h2>
                </label>
                <br>
                <label>數量:</label> <Button class="plus_minus" :disabled="item.amount === 1" type="primary" shape="circle" icon="md-remove" v-model="item.amount" @click="price_recount(index, JSON.parse(item.amount-1))"></Button><Input class="number" v-model="item.amount" placeholder="價格" :value="item.amount" autosize @on-change="price_recount(index, JSON.parse(item.amount))"/><Button class="plus_minus" type="primary" shape="circle" icon="md-add" v-model="item.amount" @click="price_recount(index, JSON.parse(item.amount+1))"></Button>
                <label class="price">{{item.price}} 元</label>              
              </div>            
            </FormItem>
          </div>
          <div class="total_info">
            <p v-if="userForm.total < 500" style="margin: 0 1%">運費: 75 元 </p>
            <p v-if="userForm.total < 500" style="margin: 0 1%">總金額: {{userForm.total + 75}} 元</p>
            <p v-else>總金額: {{userForm.total}} 元</p>
            <br>
            <small v-if="userForm.total < 500" style="color: gray">*滿500免運, 還要 {{500 - userForm.total}}</small>
          </div>
          <p><Button type="text" @click="switch_modal" ghost>繼續購物</Button></p>
          <ButtonGroup>
              <Button type="success" @click="submit_cart">送出</Button>
              <Button type="warning" @click="close">取消</Button>
          </ButtonGroup>
        </Form>
    </div>

    <div class="message_modal" v-if="cart_pushed.status === true">
      <div class="theForm center">
        <h1 class="message">{{cart_pushed.message}}</h1>
          <Button :type="cart_pushed.type" @click="cart_status_check">確認</Button>
      </div>
    </div>

    <div class="message_modal" v-if="delete_ask.status === true">
      <div class="theForm center">
        <h1 class="message">確定刪除<span style="color: orange">{{delete_ask.message}}</span>?</h1>
        <ButtonGroup>
          <Button type="success" @click="proceed_delete()">確認</Button>
          <Button type="warning" @click="cancle_delete()">取消</Button>          
        </ButtonGroup>        
      </div>
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
      windowHeight: window.innerHeight,
      cart_modal_style: {modal_top: '', list_height: ''},
      theCart: [],
      userForm: {username: '', phone: '', total: 0},
      one_price: [],
      old_amount: [],
      cart_pushed: {status: false, type: '', message: ''},
      delete_ask: {status: false, message: '', index: ''}
    }
  },
  methods: {
    set_modal(windowHeight){
      if(windowHeight < 975){ this.cart_modal_style.modal_top = -13 }
    },

    close(){
      this.$emit('cart_close', false)
    },

    price_recount(index, amount){
      if(amount <= 0){
        amount = 1
        this.theCart[index].amount = 1
      }
      this.theCart[index].price = this.one_price[index] * amount
      this.theCart[index].amount = amount

      if(this.old_amount[index] < amount){
        let increase = amount - this.old_amount[index]
        this.userForm.total = this.userForm.total + (this.one_price[index] * increase)
        this.$emit('count_list', {mode: 'plus', number: increase})
        this.old_amount[index] = amount
      }else{
        let decrease = this.old_amount[index] - amount
        let de_price = this.one_price[index] * decrease
    
        if(this.userForm.total - de_price <= 0){
          this.userForm.total = 0
          this.old_amount[index] = 0
          this.$emit('count_list', {mode: 'clear'})
          this.old_amount[index] = amount
        }else{
          this.$emit('count_list', {mode: 'minus', number: decrease})
          this.userForm.total = this.userForm.total - de_price
          this.old_amount[index] = amount              
        }
      }  
    },

    switch_modal(){
      this.$emit('modal_switch', {shop_open: true, cart_open: false})
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
          this.cart_pushed.status = true
          this.cart_pushed.message = response.data
          this.cart_pushed.type = 'success'
          this.$emit('cart_push_check', true)
        }).catch(error => {
          this.cart_pushed.status = true
          this.cart_pushed.message = error.data
          this.cart_pushed.type = 'failed'
          console.log(error)
        } )          
      }
    },

    cart_status_check(){
      this.cart_pushed.status = false
      this.theCart.splice(0)
      this.$emit('cart_clear', 0)
      this.$emit('count_list', {mode: 'clear'})
    },

    delete_check(index){
      this.delete_ask.status = true
      this.delete_ask.message = this.theCart[index].name
      this.delete_ask.index = index
    },

    proceed_delete(){
      let index = this.delete_ask.index
      let deletePrice = this.one_price[index] * this.theCart[index].amount

      this.$emit('count_list', {mode: 'deleteRow', number: this.theCart[index].amount, delete_id: this.theCart[index].ID, delete_index: index})

      this.userForm.total = this.userForm.total - deletePrice
      this.theCart.splice(index, 1) 
      this.one_price.splice(index, 1)
      this.old_amount.splice(index, 1)
      this.delete_ask.status = false     
    },

    cancle_delete(){
      this.delete_ask.status = false
    }
  },
  created(){
    this.theCart = this.prepareCart
    this.set_modal(this.windowHeight)
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
.clear{
  clear: both;
}

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
  margin-top: -13vh;
  z-index: 3;
}

.theForm{
  width: 500px;
  /* border: 1px solid red; */
  border-radius: 10px;
  padding: 1%;
  background: #f8f8f9;
  z-index: 2;
  transition: all .5s ease;
}

.message_modal > .theForm{
  /* border: 1px solid red; */
  width: unset;
}

.message_show{
  opacity: .5;
}

p > button{
  color: #232!important;
}

P > button:hover{
  color: #5AA4F0!important;
}

.list_container{
  overflow-y: scroll;
  height: 418px;
}

.list_item{
  border: 1px solid rgba(128, 128, 128, 0.7);
  border-radius: 10px;
  padding-bottom: 13px;
}

.del{
  border: none!important;
  border-radius: 10px!important;
  float: right;
  width: 22px;
  opacity: .7;
}

.del > i{
  font-size: 1.2rem;
}

.thumbnail{
  width: 150px;
  height: 150px;
  float: left;
}

.thumbnail > img{
  max-width: 100%;
  max-height: 100%;
  transform: translate(7%, -7%);
}

.item_info{
  margin-top: -19px;
}

.inputs{
  display: flex;
  justify-content: space-evenly;
}

label{
  padding: 1% 0!important;
}

.input{
  margin: 0 1%;
}

.plus_minus{
  padding: 0!important;
  width: 26px!important;
  height: 25px!important;
}

.plus_minus > i::before{
  margin-left: 0.5px;
}

.number{
  width: 5vw!important;
  margin: 0 .5vw;
}

.price{
  color: gray;
}

ul> li{
  list-style: none;
}

.total_info{
  margin-top: 1vh;
}

.total_info > p{
  display: inline-block;
}

@media screen and (max-width: 500px){
  .theForm{
    width: 100vw;
    padding: 2% 1%;
  }

  .list_item{
    padding-bottom: 40px;
  }

  .thumbnail{
    margin-top: -19px;
  }

  .thumbnail > img{
    transform: translate(10%, 10%);
  }

  .number{
    width: 11vw!important;
  }
}

@media screen and (max-width: 450px){
  .cart_modal{
    margin-top: -15vh!important;
  }

  .input{
    width: 46vw!important;
  }
}
</style>
