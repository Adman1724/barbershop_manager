<template>
  <div >
    <div class="flex items-center justify-center mt-6 text-left">
      <v-card elevation="2" width="80%">
        <v-data-table
          data-app
          :headers="headers"
          :items="employees"
          :items-per-page="10"
          class="elevation-1"
          loading
          loading-text="Loading... Please wait"
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>Emplyoees</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    New Employee
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.name"
                            label="Name"
                            class="capitalize"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.surname"
                            label="Surname"
                            class="capitalize"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.username"
                            label="Username"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.wage"
                            label="Wage"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="8">
                          <v-text-field
                            v-model="editedItem.email"
                            label="Email"
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">
                      Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="save">
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline"
                    >Are you sure you want to delete this
                    Employee?</v-card-title
                  >
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete"
                      >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                      >OK</v-btn
                    >
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">
              mdi-pencil
            </v-icon>
            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  props: ["app"],
 
  data() {
    return {
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          align: "start",
          sortable: true,
        },
        { text: "Name", value: "name" },
        { text: "Surname", value: "surname" },
        { text: "Username", value: "username" },
        { text: "Wage", value: "wage" },
        { text: "Email", value: "email" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      employees: [],
      employee: Object,
      editedIndex: -1,
      editedItem: {
        name: "",
        surname: "",
        username: "",
        wage: 0,
        email: "",
      },
      defaultItem: {
        name: "",
        surname: "",
        username: "",
        wage: 0,
        email: "",
      },
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },

    
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.init();
  },

  methods: {
    init() {
      if(this.app.user){
        this.app.req.get("employee/init").then((response) => {
        this.employees = response.data.employees;
        console.log(response);
      });
      }
      else {
        this.$router.push({ name: 'login' });
      }
      
    },
     capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
},
    editItem(item) {
      this.editedIndex = this.employees.indexOf(item);

      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.employees.indexOf(item);

      this.editedItem = Object.assign({}, item);

      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.app.req.delete("employee/" + this.editedItem.id).then((response) => {
        console.log(response);
      });
      this.employees.splice(this.editedIndex, 1);
      this.closeDelete();
      this.init();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        this.employee = Object.assign(
          this.employees[this.editedIndex],
          this.editedItem
        );
        this.employee.name = this.capitalizeFirstLetter(this.employee.name);
        this.employee.surname = this.capitalizeFirstLetter(this.employee.surname);
       
        this.app.req
          .put("employee/" + this.editedItem.id, this.employee)
          .then((response) => {
            console.log(response);
          });
      } else {
        this.employee = this.editedItem;
        this.employee.name = this.capitalizeFirstLetter(this.employee.name);
        this.employee.surname = this.capitalizeFirstLetter(this.employee.surname);
         
        this.app.req.post("employee/new", this.employee).then((response) => {
          console.log(response);
        });
        this.employees.push(this.editedItem)
      }
      this.employee = [];
      this.init();
      this.close();
    },
   
  },
};
</script>

<style>
</style>