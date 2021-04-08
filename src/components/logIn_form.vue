<template style="position: relative">
    <div class="theForm center" v-if="theForm === 'login' ">
        <Form id="LoginForm" enctype="multipart/form-data">
        <FormItem>
          <Input class="input" type="text" v-model="loginForm.username" placeholder="使用者名稱" />
        </FormItem>
        <FormItem>
          <Input class="input" type="password" v-model="loginForm.password" placeholder="密碼" />
        </FormItem>
        
        <p @click="switchForm()" class="regist"><Button type="text" size="small" ghost>申請帳號請往這邊</Button></p>

        <ButtonGroup>
            <Button type="success">登入</Button>
            <Button type="warning" @click="close">取消</Button>
        </ButtonGroup>
        </Form>
    </div>

    <div class="theForm center" v-else>
        <Form id="registForm" enctype="multipart/form-data">
        <FormItem>
          <Input class="input" type="text" v-model="registForm.username" placeholder="使用者名稱" />
        </FormItem>
        <FormItem>
          <Input class="input" type="password" v-model="registForm.password" placeholder="密碼" />
        </FormItem>
        <FormItem>
          <Input class="input" type="number" v-model="registForm.username" placeholder="電話" />
        </FormItem>
        <FormItem>
          <Input class="input" type="text" v-model="registForm.username" placeholder="信箱" />
        </FormItem>
        <FormItem>
        <Input class="input" type="date" v-model="registForm.username" placeholder="生日" />
        </FormItem>
        
        <p @click="switchForm()" class="regist"><Button type="text" size="small" ghost>登入請往這邊</Button></p>

        <ButtonGroup>
            <Button type="success">申請</Button>
            <Button type="warning" @click="close">取消</Button>
        </ButtonGroup>
        </Form>
    </div>
</template>

<script>
export default {
  name: 'LogIn',
  data(){
    return{
        theForm: 'login',
        loginForm: {username: '', password: ''},
        registForm: {username: '', password: '', phone: '', email: '', birth_day: '', userPhoto: ''}
    }
  },
  methods: {
    switchForm(){
      if(this.theForm === 'login'){
        this.theForm = 'regist'
      }else{
        this.theForm = 'login'
      }
    },

    close(){
      this.$parent.form_active = false
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
  background: hsla(19, 81%, 19%, 0.7);
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
