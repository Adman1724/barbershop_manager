<template>
  <div>
    <div class="flex items-center justify-center mt-6 text-left">
      <v-card elevation="2" width="30%">
        <v-data-table
          data-app
          :headers="headers"
          :items="payouts"
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>Payouts</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" min-width="400px" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    New Payout
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                      
                        <div class="block p-0">
                          <v-date-picker
                            v-model="editedItem.date"
                            :show-current="true"
                            type="month"
                            
                          ></v-date-picker>
                        </div>
                        
                    <v-container>
                      
                        <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field
                            v-model="editedItem.works_days"
                            label="Works Days"
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
                    >Are you sure you want to delete this item?</v-card-title
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
            <v-btn color="primary" @click="init"> Reset </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <v-card elevation="2" width="60%" class="ml-20">
          <payouts-detail-component :app='this'></payouts-detail-component>
      </v-card>
    </div>
  </div>
</template>

<script>
import payoutsDetailComponent from '../components/PayoutsDetailComponent';
import PayoutsDetailComponent from '../components/PayoutsDetailComponent.vue';
export default {
  components: { PayoutsDetailComponent },
    component:{
        payoutsDetailComponent,
    },
    props: ["app"],
  data() {
      return{
    
    modal: false,
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        align: "start",
        sortable: false,
        value: "name",
      },
      { text: "date", value: "date" },
      { text: "Works Days", value: "works_days" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    payouts: [],
    payout:[],
    editedIndex: -1,
    editedItem: {
      date: '',
      works_days: 0,
    },
    defaultItem: {
      date: '',
      works_days: 0,
    },
  }
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
    if(this.app.user){
this.init();
    }
    
    else {
        this.$router.push({ name: 'login' });
      }
  },

  methods: {
    init() {
        var x;
      this.app.req.get("payout/init").then((response) => {
        this.payouts = response.data.payouts;
        console.log(response);
          for (x in this.payouts) {
        this.payouts[x].date=this.payouts[x].date.substr(0, 7);
        console.log(this.payouts[x].date)
}
        
      });
    
    },
    

    editItem(item) {
      this.editedIndex = this.payouts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.payouts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
        this.app.req.delete("payout/" + this.editedItem.id).then((response) => {
        console.log(response);
      });
      this.payouts.splice(this.editedIndex, 1);
      this.closeDelete();
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
          this.payout= Object.assign(this.payouts[this.editedIndex], this.editedItem);
          this.payout.date=this.payout.date+'-01';
          this.app.req
          .put("payout/" + this.editedItem.id, this.payout)
          .then((response) => {
            console.log(response);

          });
           
      } else {
          this.payout= this.editedItem;
          this.payout.date=this.payout.date+'-01';
          this.app.req.post("payout/new", this.payout).then((response) => {
          console.log(response);
        });
        
        this.payouts.push(this.editedItem);
      }
      
      this.payout= [];
      this.init();
      console.log(this.editedItem);
      this.close();
    },
  },
};
</script>

<style>
.v-dialog>.v-card>.v-card__subtitle, .v-dialog>.v-card>.v-card__text{
    padding: 0!important;
}
.v-picker__title{
    background-color: goldenrod;
}

</style>