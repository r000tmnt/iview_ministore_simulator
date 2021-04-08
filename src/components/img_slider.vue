<template>
  <Row> 
    <Col span="24">
      <main>
        <transition-group class="slider" name="slide">
            <div class="img_slide" :key="img_index">
                <img :src="currentIMG" alt="cake">
            </div>
        </transition-group>
        
        <nav class="direction">
            <ul>
                <li><button><Icon class="left" type="md-arrow-dropleft" /></button></li>
                <li><button><Icon class="right" type="md-arrow-dropright" /></button></li>
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
      } 
  },
  methods: {
      img_slider(){
          window.setInterval(()=>{
              this.getIMG(this.img_index)
          }, 5000)
      },

      getIMG(index){
        if(index === this.img_total-1){
            this.img_index = 0
            return this.currentIMG = this.img_sources[0]
        }else if(this.img_sources[index+1] !== undefined){
            this.img_index = index+1
            return this.currentIMG = this.img_sources[this.img_index]
        }
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

main{
    width: 100vw;
    height: 50vh;
}

nav{
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  position: absolute;
  padding: 1%
}

ul{
  width: 100vw;
  display: flex;
  justify-content: space-between;
  font-size: 1.5rem;
}

ul > li{
  list-style: none;
  margin: 0 1%;
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
</style>
