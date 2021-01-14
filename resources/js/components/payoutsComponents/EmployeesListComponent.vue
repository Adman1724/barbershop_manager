<template>
<v-data-table data-app :headers="headers" :items="empPayouts" sort-by="date" class="elevation-1">
    <template v-slot:top>
        <v-toolbar flat>
            <v-toolbar-title>{{actualPayout.date}}</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary"  class="mb-2" >
                        Calculate Payouts
                    </v-btn>
            <v-dialog v-model="dialog" min-width="400px">
                
                    
                
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>



                        <v-container>

                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="editedItem.holiday" label="Holiday"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="editedItem.firstPart" label="First Part"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="editedItem.lunchCard" label="Lunch Card"></v-text-field>
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



        </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
        <v-icon small @click="info(item)">mdi-information</v-icon>
       
        <v-icon small @click="downloadPdf(item)"> mdi-cloud-download </v-icon>
         <v-icon small class="mr-2" @click="editItem(item)">
            mdi-pencil
        </v-icon>


    </template>


</v-data-table>
</template>

<script>
export default {
    props: {
        app: Object,

    },

    data() {
        return {

        actualPayout: {
                id:0,
                date:'default',
                workedDays:100

            },

            modal: false,
            dialog: false,
            dialogDelete: false,
            dialogDownloadPdf: false,
            headers: [
                {
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Holiday",
                    value: "holiday"
                },
                {
                    text: "First",
                    value: "firstPart"
                },
                 {
                    text: "Second",
                    value: "secondPart"
                },
                   {
                    text: "Card",
                    value: "lunchCard"
                },
                   {
                    text: "Overtime",
                    value: "overtime"
                },
                 {
                    text: "Worked Hours",
                    value: "workedHour"
                },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                },
            ],
            empPayouts: [],
            empPayout: {},
            chosenFile: null,
            editedIndex: -1,
            editedItem: {
                name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour:0,

            },
            defaultItem: {
               name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour:0,
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


    },

    created() {


        this.$root.$refs.EmployeesListComponent = this;


    },

    methods: {
        init() {
            var x;
            this.empPayouts= [];
            this.app.req.get("employees_payouts/init/"+ this.actualPayout.id).then((response) => {
                //this.empPayouts = response.data.payouts;
                console.log(response.data);
                for(x in response.data){
                    
                    let employee = {};
                    employee.id=response.data[x].id;
                    employee.name= response.data[x].employee.name+' '+response.data[x].employee.surname;
                    employee.firstPart=response.data[x].first_part;
                    employee.secondPart=response.data[x].second_part;
                    employee.overtime=response.data[x].overtime;
                    employee.holiday=response.data[x].holiday;
                    employee.lunchCard= response.data[x].lunch_card;
                    employee.workedHour= response.data[x].worked_hour;
                    this.empPayouts.push(employee);
                }
                



            });
            

        },
        info(item){
             this.editedIndex = this.empPayouts.indexOf(item);
            this.editedItem = Object.assign({}, item);
             this.app.req.get("employees_payouts_services/init/"+ this.editedItem.id).then((response) => {
                //this.empPayouts = response.data.payouts;
                console.log(response.data);
             });
                


        },







        editItem(item) {
            this.editedIndex = this.empPayouts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },


        downloadPdf(item) {
            this.editedIndex = this.empPayouts.indexOf(item);
            this.editedItem = Object.assign({}, item);


        },



        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },





        save() {
            if (this.editedIndex > -1) {
                this.empPayout = Object.assign(this.empPayouts[this.editedIndex], this.editedItem);

                this.app.req
                    .put("payout/" + this.editedItem.id, this.empPayout)
                    .then((response) => {

                    });

            }

            this.empPayout = [];
           //init

            this.close();
        },
    },

}

</script>

<style>
.v-dialog:not(.v-dialog--fullscreen) {
    max-height: 100 !important;
}

.v-dialog {
    width: auto !important;
}
</style>
