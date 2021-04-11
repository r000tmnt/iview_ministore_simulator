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
                <li><button @click="prevIMG(img_index)"><Icon class="left" type="md-arrow-dropleft" /></button></li>
                <li><button @click="nextIMG(img_index)"><Icon class="right" type="md-arrow-dropright" /></button></li>
            </ul>
        </nav>

        <nav class="circles">
            <ul class="dots">
                <li class="dot" v-for="(img, index) in img_sources" :key="index" :class="{here: index === img_index}" @click="toIndex(index)"></li>
            </ul>            
        </nav>
      </main>
    </Col>
  </Row>
</template>

<script>
export default {
  name: 'img_slider',
  data() {
      return{
          img_sources: [],
          img_index: 0,
          currentIMG: '',
          img_total: '',
          slideBack: false
      } 
  },
  methods: {
      img_slider(){
          window.setInterval(()=>{
              if(this.slideBack === false){
                  this.nextIMG(this.img_index)
              }else{
                  this.prevIMG(this.img_index)
              }
          }, 5000)
      },

      nextIMG(index){
          this.slideBack = false
          if(index === this.img_total-1){
              this.img_index = 0
              return this.currentIMG = this.img_sources[0]
          }else if(this.img_sources[index+1] !== undefined){
              this.img_index = index+1
              return this.currentIMG = this.img_sources[this.img_index]
          }
      },

      prevIMG(index){
          this.slideBack = true
          if(index === 0){
              this.img_index = this.img_total-1
              return this.currentIMG = this.img_sources[this.img_total-1]
          }else if(this.img_sources[index-1] !== undefined){
              this.img_index = index-1
              return this.currentIMG = this.img_sources[this.img_index]
          }          
      },

      toIndex(index){
          this.currentIMG = this.img_sources[index]
          this.img_index = index
      }
  },
  created(){
      let vm = this
      vm.$https.get('http://localhost/iview_ministore_simulation/src/php/get_images.php').then(response => {
          vm.img_total = response.data.length
          vm.currentIMG = response.data[0].path
          for(let i=0; i < response.data.length; i++){
              vm.img_sources .push(response.data[i].path)
          }
      })

      this.img_slider();
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.slide-enter-active, .slide-leave-active {
    transition: all 1.5s ease-in-out;
}
.slide-enter{
    transform: translate(100%, 0);
}

.slide-leave-to{
    transform: translate(-100%,0);
}

.slideBack-enter-active, .slideBack-leave-active {
    transition: all 1.5s ease-in-out;
}
.slideBack-enter{
    transform: translate(-100%, 0);
}

.slideBack-leave-to{
    transform: translate(100%,0);
}

.slider{
    overflow: hidden;
}

.img_slide > img{
    width: 100vw;
    height: 50vh;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
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
  width: 100vw;
  display: flex;
  justify-content: space-between;
  font-size: 1.5rem;
}

.arrows > li{
  list-style: none;
  margin: 0 1%;
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
    border: 1px solid #232;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    transition: all .5s ease;
    margin: 0 .2%;
    cursor: pointer;
}

.dot:hover{
    width: 18px;
    height: 18px;
}

button{
    background: #232;
    border: none;
    border-radius: 50%;
    width: 35px;
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

@media screen and (max-width: 500px){
    .dot{
        margin: 0 1%;
    }
}
</style>
