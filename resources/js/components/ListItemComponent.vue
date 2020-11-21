<template>
  <v-card class="mx-auto dark" max-width="500">
    <v-toolbar class="dark" color="teal" dark>
      <v-img
        max-height="60px"
        max-width="40px"
        src="http://127.0.0.1:8000/images/frame4.png"
      ></v-img>

      <v-toolbar-title>
        <router-link to="/">Barbershop Manager</router-link>
      </v-toolbar-title>

      <v-spacer></v-spacer>
    </v-toolbar>

    <v-list>
      <v-list-group
        v-for="item in items"
        :key="item.title"
        v-model="item.active"
        :prepend-icon="item.action"
        no-action
      >
        <template v-slot:activator>
          <router-link  :to="item.link">
             <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
          </router-link>
         
        </template>

        <v-list-item v-for="child in item.items" :key="child.title">
          <v-list-item-content>
            <router-link :to="child.link"
              ><v-list-item-title
                v-text="child.title"
                class="margin-5"
              ></v-list-item-title
            ></router-link>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-card>
</template>
<script>
export default {
  data: () => ({
    items: [
      {
        action: "mdi-archive",
        items: [
          { title: "Products", link: "/inventory/products" },
          { title: "New", link: "/inventory/new" },
          { title: "History", link: "/inventory/history" },
        ],
        title: "Inventory",
        link: "/inventory"
      },
      {
        action: "mdi-bottle-soda-outline",
        items: [
          { title: "New", link: "/products/new" },
          { title: "Edit", link: "/inventory/edit" },
        ],
        title: "Products",
        link: "/products"
      },

      {
        action: "mdi-cash-multiple",
        active: true,
        items: [
          { title: "New Tax", link: "/tax/new" },
          { title: "History", link: "/tax/history" },
        ],
        title: "Tax",
        link: "/taxs"
      },
      {
        action: "mdi-content-cut",
        items: [
          { title: "Services", link: "/test" },
          { title: "Add new Service", link: "/users/new" },
          { title: "Edit Service", link: "/users/new" },
        ],
        title: "Services",
        link: "/services"
      },
      {
        action: "mdi-briefcase",
        items: [
          { title: "Add new employee", link: "/employees/new" },
          { title: "Edit employee", link: "/employees/edit" },
        ],
        title: "Employees",
        link: "/employees"
      },
      {
        action: "mdi-account",
        items: [
          { title: "Users", link: "/test" },
          { title: "Add new user", link: "/users/new" },
        ],
        title: "Users",
        link: "/users"
      },
    ],
  }),
};
</script>
<style>
.margin-5 {
  margin-left: 40px;
}
</style>