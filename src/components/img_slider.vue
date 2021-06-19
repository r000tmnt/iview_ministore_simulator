<template>
  <Row> 
    <Col span="24">
      <main>
        <transition-group class="slider" :name="slideBack? 'slideBack' : 'slide'">
            <div class="img_slide" :key="img_index">
                <img :src="currentIMG" alt="cake">
            </div>
        </transition-group>
        
        <nav class="direction">
            <ul class="arrows">
                <li><button @click="switchIMG(img_index, true, switch_mode.pre)" :class="{disable: clicked === true}"><Icon class="left" type="md-arrow-dropleft" /></button></li>
                <li><button @click="switchIMG(img_index, true, switch_mode.next)" :class="{disable: clicked === true}"><Icon class="right" type="md-arrow-dropright" /></button></li>
            </ul>
        </nav>

        <nav class="circles">
            <ul class="dots">
                <li class="dot" v-for="(img, index) in img_sources" :key="index" :class="{here: index === img_index, disable: clicked === true}" @click="toIndex(index)"></li>
            </ul>            
        </nav>
      </main>
    </Col>
  </Row>
</template>

<script>
export default {
  name: 'img_slider',
  props: {
      productImgs: Array
  },
  data() {
      return{
          timer: '',
          clicked: false,
          switch_mode: { pre: 'previous', next: 'next'},
          img_sources: [],
          img_index: 0,
          currentIMG: '',
          img_total: '',
          slideBack: false
      } 
  },

  watch: {
      productImgs: function(value){
          this.img_total = value.length
          this.currentIMG = value[0]
          for(let i=0; i < this.img_total; i++){
              this.img_sources.push(value[i])
          }
          this.img_slider()                    
      }
  },

  methods: {
      img_slider(){
          if(this.clicked === true){
              window.setTimeout(()=>{
                  this.clicked = false
              }, 1500)
          }

          this.timer = window.setInterval(()=>{
              if(this.slideBack === false){
                  this.switchIMG(this.img_index, this.clicked, this.switch_mode.next)
              }else{
                  this.switchIMG(this.img_index, this.clicked, this.switch_mode.pre)
              }
          }, 5000)
      },

      switchIMG(index, clicked, mode){
          if(clicked === true){
              this.clicked = clicked
              this.pause_timer()
          }

          if(mode === 'previous'){
              this.slideBack = true

              if(index === 0){
                this.img_index = this.img_total-1
                return this.currentIMG = this.img_sources[this.img_total-1]
              }else{
                this.img_index = index-1
                return this.currentIMG = this.img_sources[this.img_index]
              }               
          }else{
              this.slideBack = false

              if(index === this.img_total-1){
                  this.img_index = 0
                  return this.currentIMG = this.img_sources[0]
              }else{
                  this.img_index = index+1
                  return this.currentIMG = this.img_sources[this.img_index]
              }               
          }
      },

      pause_timer(){
          window.clearInterval(this.timer)
          this.img_slider()
      },

      toIndex(index){
          this.clicked = true
          this.currentIMG = this.img_sources[index]
          this.img_index = index
          this.pause_timer()
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.slide-enter-active, .slide-leave-active {
    transition: all 1.5s ease-in-out;
    opacity: 1;
}
.slide-enter{
    transform: translate(100%, 0);
    opacity: 0;
}

.slide-leave-to{
    transform: translate(-100%,0);
}

.slideBack-enter-active, .slideBack-leave-active {
    transition: all 1.5s ease-in-out;
}
.slideBack-enter{
    transform: translate(-100%, 0);
    opacity: 0;
}

.slideBack-leave-to{
    transform: translate(100%,0);
    opacity: 1;
}

.slider{
    overflow: hidden;
}

.img_slide > img{
    width: 70vw;
    height: 50vh;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: 0 auto;
    transition: all 0s ease;
}

.here{
    background: orange;
}

main{
    width: 100vw;
    height: 50vh;
}

nav{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
}

.arrows{
  width: 65vw;
  display: flex;
  justify-content: space-between;
  font-size: 1.5rem;
}

.arrows > li{
  list-style: none;
  margin: 0 1%;
}

.disable{
    pointer-events: none;
}

.circles{
    margin-top: 26vh;
    width: 100vw;
}

.dots{
    display: flex;
    justify-content: center;
    margin: 0 auto;
    /* border: 1px solid red; */
    padding: 2%;
}

.dot{
    border: 1px solid rgba(34, 51, 34, 0.7);
    width: 15px;
    height: 15px;
    border-radius: 50%;
    transition: all .5s ease;
    margin: 0 .2%;
    cursor: pointer;
}

.dot:hover{
    border: 1px solid #232;
}

button{
    background: #232;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    color: white;
    opacity: .5;
    cursor: pointer;
}

button:hover{
    opacity: .7;
    transition: opacity .5s;
}

.left::before{
    margin-right: 4px;
}

.right::before{
    margin-left: 2px;
}

@media screen and (max-width: 850px){
    .arrows ,.img_slide > img{
        width: 90vw;
    }
}


@media screen and (max-width: 500px){
    .arrows ,.img_slide > img{
        width: 100vw;
    }

    .circles{
        margin-top: 27vh;
    }

    .dot{
        margin: 0 1%;
    }
}
</style>
