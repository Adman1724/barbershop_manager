<template>
  
  
  <v-card
    class="mx-auto theme--dark.v-navigation-drawer border"
    height="100%"
    width="256"
    dark
  >
    <v-navigation-drawer
      class="deep-purple accent-4"
      dark
      permanent
    >
    <div class="flex content">
         <v-img max-height="60px" max-width="40px" src="http://127.0.0.1:8000/images/frame4.png"></v-img>
        <v-toolbar-title>Barbershop Manager</v-toolbar-title>
    </div>
   
      <v-list>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn block @click="logout()">
            Logout
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </v-card>

</template>

<script>

  export default {
      props: ['app'],
      methods: {
        logout() {
            this.app.req.post("auth/logout").then(() => {
                this.app.user = null;
                this.$router.push("/login");
            });
        }
    },
    data () {
      return {
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard' },
          { title: 'Account', icon: 'mdi-account-box' },
          { title: 'Admin', icon: 'mdi-gavel' },
        ],
      }
    },
  }

</script>

<style>
.border{
    border-radius: 0!important;
}
.content{
    justify-content: center;
    align-items: center;
    margin-top: 5px;
}


</style>