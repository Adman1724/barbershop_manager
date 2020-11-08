<template>
  <div>
      <navbar :app="this"></navbar>
      <spinner v-if="loading" line-fg-color="#daa520" style="margin:50px;"></spinner>
      <div v-else-if="initiated">

          <router-view :app="this"/>

      </div>
      
  </div>
</template>

<script>
import navbar from './components/Navbar';

export default {
    name: 'app',
    
    components: {
        navbar
    },
    data(){
            return{
            user: null,
            loading: false,
            initiated: false,
            req: axios.create({
                baseUrl: BASE_URL
            })
        }

    },
    mounted(){
        this.init();
    },
    methods: {
        init(){

            this.loading = true;

            this.req.get('auth/init').then(response =>{
                this.user = response.data.user;
                this.loading =false;
                this.initiated = true;
            })
        }
    }
};
</script>

<style>
    body{
        font-family: 'Roboto', sans-serif;
    }

</style>