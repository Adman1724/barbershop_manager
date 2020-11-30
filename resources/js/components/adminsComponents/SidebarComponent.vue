<template>
  <v-card
    class="mx-auto theme--dark.v-navigation-drawer border"
    height="100%"
    width="256"
    dark
  >
    <v-navigation-drawer class="deep-purple accent-4" dark permanent>
      
        <listItemComponent></listItemComponent>
     

      <template v-slot:append>
        <div class="pa-2">
          <v-btn block @click="logout()"> Logout </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </v-card>
</template>

<script>
import listItemComponent from './ListItemComponent';
export default {
    components: {
    listItemComponent
  },

  props: {
    app: Object,
  },

  methods: {
    logout() {
      this.app.req.post("auth/logout").then(() => {
        this.app.user = null;
        this.$router.push("/login");
      });
    },
  },

  data() {
    return {};
  },
};
</script>

<style>
.border {
  border-radius: 0 !important;
}

.content {
  justify-content: center;
  align-items: center;
  margin-top: 5px;
}
</style>
