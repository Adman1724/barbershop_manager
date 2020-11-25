<template>
  <div class="container">
      <h1>{{employees}}
          
      </h1>
  </div>
</template>

<script>
export default {
  
    props:['app'],
    data(){
      return {
      employees: null
      }

      },
    mounted() {
    this.init();},
    methods:{
      init(){
        if(this.app.user){
        this.app.req
        .get("employee/init")
        .then((response) => {
          this.employees = response.data;
          console.log(response)
    
        })
        }
      
      else {
        this.$router.push({ name: 'login' });
      }
        
      }

    }

}
</script>

<style>

</style>