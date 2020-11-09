<template>
<div>
    <v-app-bar color="deep-purple accent-4" dense dark>
        <!--<v-app-bar-nav-icon></v-app-bar-nav-icon>-->
        <v-img max-height="60px" max-width="40px" src="http://127.0.0.1:8000/images/frame4.png"></v-img>
        <v-toolbar-title>Barbershop Manager</v-toolbar-title>

        <v-spacer></v-spacer>

        <div v-if="!app.user">

            <router-link to="/login">Login</router-link>

            <router-link to="/register">Register</router-link>

        </div>

        <div v-else>

            <div @click="logout">
                Welcome {{app.user.name}}
            </div>

        </div>

    </v-app-bar>
</div>
</template>

<script>
export default {
    name: 'navbar',
    props: ['app'],
    data() {

        return {

        }
    },
    
    methods: {
        logout() {
            this.app.req.post("auth/logout").then(() => {
                this.app.user = null;
                this.$router.push("/login");
            });
        }
    }
};
</script>

<style>
a:link {
    color: white;
    text-decoration: none;
}

a:visited {
    text-decoration: none;
    color: white;
}

a:hover {
    color: darkgray;
}
</style>
