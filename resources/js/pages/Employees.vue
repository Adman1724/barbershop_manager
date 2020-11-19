<template>
  <div >
    <h1>Employees</h1>

  
  <div class="flex-centring">
    <v-card elevation="2">
      <v-data-table
        :headers="headers"
        :items="employees"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table>
    </v-card>
  </div>
  </div>
</template>

<script>
export default {
  props:['app'],
  data() {
    return {
      headers: [
        {
          
          align: "start",
          sortable: false,
          
        },
        { text: "Name", value: "name" },
        { text: "Surname", value: "surname" },
        { text: "Username", value: "username" },
        { text: "Wage", value: "wage" },
        { text: "Email", value: "email" },
      ],
      employees: [
      ],
    };
  }, mounted() {
    this.init();},
    methods:{
      init(){
        this.app.req
        .get("employee/init")
        .then((response) => {
          this.employees = response.data.employees;
          console.log(response)
    
        })
        
      }
    }
};
</script>

<style>
.flex-centring {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>