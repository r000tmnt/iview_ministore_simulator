<template style="position: relative">
    <div class="theForm center" v-if="theForm === 'login' ">
        <Form id="LoginForm" enctype="multipart/form-data">
        <FormItem>
          <Input class="input" type="text" v-model="theCart.username" placeholder="名稱" />
        </FormItem>
        <FormItem>
          <Input class="input" type="number" v-model="theCart.phone" placeholder="電話" />
        </FormItem>
        <FormItem v-for="item in theCart" :key="item.ID">
          <label for="amount">{{load.name}}</label>
          <Input class="input" type="number" v-model="item.amount" :placeholder="item.amount" />
        </FormItem>

        <ButtonGroup>
            <Button type="success">送出</Button>
            <Button type="warning" @click="close">取消</Button>
        </ButtonGroup>
        </Form>
    </div>
</template>

<script>
export default {
  name: 'shoppingCart',
  data(){
    return{
        theCart: []
    }
  },
  methods: {
    close(){
      this.$parent.cart_open = false
    }
  },
}
</script>

<style>
.center{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.theForm{
  width: 30vw;
  /* border: 1px solid red; */
  border-radius: 10px;
  display: inline-block;
  padding: 1%;
  background: #f8f8f9;
  z-index: 2;
}

.input{
  width: 25vw!important;
}

.regist{
  margin-bottom: 5px;
}

ul> li{
  list-style: none;
}
</style>
