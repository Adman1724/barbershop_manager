<template>
  <div class="flex height-100">
    <div v-if="user" class="block">
      <sidebar :app="this"></sidebar>
    </div>
    <div class="block-1">
      <navbar :app="this"></navbar>
      <spinner
        v-if="loading"
        line-fg-color="#daa520"
        style="margin: 50px"
      ></spinner>
      <div v-else-if="initiated">
        <router-view :app="this" />
      </div>
    </div>
  </div>
</template>

<script>
import navbar from "./components/adminsComponents/Navbar";
import sidebar from "./components/adminsComponents/SidebarComponent";

export default {
  name: "app",

  components: {
    navbar,
    sidebar,
  },
  data() {
    return {
      user: null,
      loading: false,
      initiated: false,
      req: axios.create({
        baseUrl: BASE_URL,
      }),
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.loading = true;

      this.req.get("auth/init").then((response) => {
        this.user = response.data.user;

        this.loading = false;
        this.initiated = true;
      });
    },
  },
};
</script>

<style>
html {
  height: 100%;
}
body {
  font-family: "Roboto", sans-serif;
  height: 100%;
}
.flex {
  display: flex;
}
.height-100 {
  height: 100%;
}

.block {
  display: block;
}
.block-1 {
  display: block;
  width: 100%;
}
</style>
