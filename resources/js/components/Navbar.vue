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

            <v-container fluid style="height: 300px">
                <v-row justify="center">
                    <v-menu bottom min-width="200px" rounded offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn icon x-large v-on="on">
                                <v-avatar color="brown" size="48">
                                    <span class="white--text headline">{{ user.initials }}</span>
                                </v-avatar>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-list-item-content class="justify-center">
                                <div class="mx-auto text-center">
                                    <v-avatar color="brown">
                                        <span class="white--text headline">{{ user.initials }}</span>
                                    </v-avatar>
                                    <h3>{{ user.fullName }}</h3>
                                    <p class="caption mt-1">
                                        {{ user.email }}
                                    </p>
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn depressed rounded text>
                                        Edit Account
                                    </v-btn>
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn depressed rounded text>
                                        Disconnect
                                    </v-btn>
                                </div>
                            </v-list-item-content>
                        </v-card>
                    </v-menu>
                </v-row>
            </v-container>

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
