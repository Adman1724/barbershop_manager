<template>
  <div class="full">
    <div class="is-horizontal-center">
      <v-card elevation="2">
        <div class="center">
          <h1>LOGIN PAGE</h1>
        </div>
        <v-spacer></v-spacer>
        <div class="center red" >
         <h1 v-if="error" >{{error}}</h1>
        </div>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field
            v-model="username"
            :counter="10"
            :rules="usernameRules"
            label="Username"
            required
          ></v-text-field>
          <v-text-field
            v-model="password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            label="Password"
            hint="At least 8 characters"
            counter
            @click:append="show1 = !show1"
          ></v-text-field>

          <v-spacer></v-spacer>
          <v-btn
            :disabled="!valid"
            color="success"
            class="mr-4"
            @click="onSubmit"
          >
            Login
          </v-btn>
        </v-form>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  name: "login",
  props: {
    app: Object,

    usernameRules: [
      (v) => !!v || "Name is required",
      (v) => (v && v.length <= 10) || "Userame must be less than 10 characters",
    ],
  },

  data() {
    return {
      username: "",
      valid: true,
      show1: false,
      error:null,
      password: "",
      rules: {
        required: (value) => !!value || "Required.",
        min: (v) => v.length >= 8 || "Min 8 characters",
        emailMatch: () => `The email and password you entered don't match`,
        valid: true,
      },
    };
  },
  methods: {
    validate() {
      this.onSubmit();
    },
    onSubmit() {
      const data = {
        username: this.username,
        password: this.password,
      };
     
      this.app.req
        .post("auth/login", data)
        .then((response) => {
          this.app.user = response.data;

          this.$router.push("/");
        })
        .catch((error) => {
          this.error=(error.response.data.error);
          console.log(this.error);
        });
    },
  },
};
</script>

<style>
h1 {
  font-size: 1.5em;
}

.spacer {
  height: 25px;
}

.full {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.is-horizontal-center {
  display: block;
  margin-bottom: 300px;
  width: 600px;
}

.center {
  display: flex;
  justify-content: center;
}

.theme--light.v-card {
  padding: 50px;
}
.red{
    color: red;
}
</style>
