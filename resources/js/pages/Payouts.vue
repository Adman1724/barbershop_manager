<template>
  <div>
    <div class="flex  justify-center text-left p-12">
      <v-card elevation="2" width="40%" min-width="400px">
          <payouts-list-component :app="this.app"></payouts-list-component>
      </v-card>
      <v-card elevation="2" width="55%" class="ml-5"  >
          <payouts-detail-component :app="this.app"></payouts-detail-component>
      </v-card>
    </div>
  </div>
</template>

<script>

import PayoutsDetailComponent from '../components/payoutsComponents/PayoutsDetailComponent.vue';
import PayoutsListComponent from '../components/payoutsComponents/PayoutsListComponent'
export default {
  components: {
      PayoutsDetailComponent,
      PayoutsListComponent,
   },

 props: ["app"],
  data() {
      return{

      }
  },mounted() {
    if(this.app.user){

    }

    else {
        this.$router.push({ name: 'login' });
      }
  },






}
</script>

<style>
.v-dialog>.v-card>.v-card__subtitle, .v-dialog>.v-card>.v-card__text{
    padding: 0!important;
}
.v-picker__title{
    background-color: goldenrod;
}

</style>
