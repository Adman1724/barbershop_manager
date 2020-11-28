<template>




    <v-list>
      <v-list-group
        v-for="item in items"
        :key="item.title"
        v-model="item.active"
        :prepend-icon="item.action"
        no-action
      >
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item
          v-for="child in item.items"
          :key="child.title"
        >
          <v-list-item-content>
            <v-list-item-title v-text="child.title"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>


</template>

<script>
export default {
    props:["app"],

     data()  {
         return{
        item:
            {
                action:'',
                items:[],
                title:'',
            }
        ,
        items: [

      ],
      defaultItem:
            {
                action:'',
                items:[],
                title:'',
            }
        ,
        defaultItems:[],
    }},
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
        var x;
        this.items=this.defaultItems;
        this.app.req.get("employee/init").then((response) => {
        this.employees = response.data.employees;
        console.log(response);
         for (x in this.employees) {
                this.item.action='';
                this.item.items=[];
                this.item.title=this.employees[x].name + ' '+this.employees[x].surname;
                this.items.push(this.item);
                this.item = Object.assign({}, this.defaultItem);


                };

      });




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

}
</script>

<style>

</style>
