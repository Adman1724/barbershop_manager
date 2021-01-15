<template>
<v-data-table data-app :headers="headers" :items="empPayouts" sort-by="date" class="elevation-1">
    <template v-slot:top>
        <v-toolbar flat>
            <v-toolbar-title>{{actualPayout.date}}</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary" class="mb-2">
                Calculate Payouts
            </v-btn>
            <v-dialog v-model="dialog" min-width="400px">

                <v-card>
                    <v-card-title>
                        <span class="headline">{{ editedItem.name }}</span>
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

            <v-dialog v-model="dialogEmployeeInfo" min-width="400px">

                <v-card>
                    <v-card-title>
                        <div class="flex">
                            <div class="block w-3/4">
                                <span class="headline">{{editedItemInfo.name}}</span>
                            </div>
                            <div class="block w-1/4 text-right ">
                                <span class="headline">{{actualPayout.date}}</span>
                            </div>

                        </div>

                    </v-card-title>

                    <v-card-text>

                        <v-container>
                            <div class="flex">
                                <div class="block w-3/4">
                                    <div class="flex ">
                                        <div class="block w-1/3 border-solid border-2 border-black m-2.5 p-1 text-center ">
                                            Hodiny volna
                                            <p>
                                                {{editedItemInfo.holiday}} h
                                            </p>
                                            </div>
                                        <div class="block w-1/3 border-solid  border-2 border-black m-2.5 p-1 text-center">
                                            Odpracovane hodiny
                                            <p>
                                                {{editedItemInfo.workedHour}} h
                                            </p>
                                            </div>
                                        <div class="block w-1/3 border-solid  border-2 border-black m-2.5 p-1  text-center">
                                            Povinne hodiny
                                            <p>
                                                {{dayToHour}} h
                                            </p>
                                             </div>
                                    </div>
                                    <template>
                                        <v-simple-table height="400px">
                                            <template v-slot:default>
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            Nazov
                                                        </th>
                                                        <th class="text-left">
                                                            Trvanie
                                                        </th>
                                                        <th class="text-left">
                                                            Pocet
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in empServices" :key="item.service.name">
                                                        <td>{{ item.service.name }}</td>
                                                        <td>{{ item.service.duration }}</td>
                                                        <td>{{ item.multiplicity }}</td>
                                                    </tr>
                                                </tbody>
                                            </template>
                                        </v-simple-table>
                                    </template>
                                </div>
                                <div class="block w-1/4">

                                    <v-simple-table height="400px">
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Polozka
                                                    </th>
                                                    <th class="text-left">
                                                        Suma
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Prvá časť</td>
                                                    <td>{{editedItemInfo.firstPart}} €</td>
                                                </tr>
                                                <tr>
                                                    <td>Druhá časť</td>
                                                    <td>{{editedItemInfo.secondPart}} €</td>
                                                </tr>
                                                <tr>
                                                    <td>Nadčas</td>
                                                    <td>{{editedItemInfo.overtimePrice}} €</td>
                                                </tr>
                                                <tr>
                                                    <td>Stravne listky</td>
                                                    <td>{{editedItemInfo.lunchCard}} €</td>
                                                </tr>
                                                <tr>
                                                    <td>Dovolenka</td>
                                                    <td>{{editedItemInfo.holiday}} €</td>
                                                </tr>
                                                <tr>

                                                    <td>Celkovo:</td>
                                                    <td>{{editedItemInfo.wage}} €</td>

                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>

                                </div>

                            </div>

                           

                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeEmployeeInfo">
                            Close
                        </v-btn>
                        <v-btn color="blue darken-1" text @click="saveEmployeeInfo">
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
                id: 0,
                date: 'default',
                workedDays: 100

            },

            modal: false,
            dialog: false,
            dialogDelete: false,
            dialogDownloadPdf: false,
            dialogEmployeeInfo: false,
            headers: [{
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
            original:[],
            empPayouts: [],
            empServices: [],
            empPayout: {},
            chosenFile: null,
            dayToHour:0,
            editedIndex: -1,
            editedItemInfo: {
                name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour: 0,
                overtimePrice: 0,
                wage: 0,

            },
            editedItem: {
                name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour: 0,

            },
            defaultItem: {
                name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour: 0,

            },
            defaultItemInfo: {
                name: '',
                holiday: 0,
                firstPart: 0,
                secondPart: 0,
                lunchCard: 0,
                overtime: 0,
                workedHour: 0,
                overtimePrice: 0,
                wage: 0,
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
        dialogEmployeeInfo(val) {

            val || this.closeEmployeeInfo();
        }

    },

    created() {

        this.$root.$refs.EmployeesListComponent = this;

    },

    methods: {
        init() {
            var x;
            this.empPayouts = [];
            this.app.req.get("employees_payouts/init/" + this.actualPayout.id).then((response) => {
                //this.empPayouts = response.data.payouts;
                console.log(response.data);
                this.original=response.data;
                for (x in response.data) {

                    let employee = {};
                    employee.id = response.data[x].id;
                    employee.name = response.data[x].employee.name + ' ' + response.data[x].employee.surname;
                    employee.firstPart = response.data[x].first_part;
                    employee.secondPart = response.data[x].second_part;
                    employee.overtime = response.data[x].overtime;
                    employee.holiday = response.data[x].holiday;
                    employee.lunchCard = response.data[x].lunch_card;
                    employee.workedHour = response.data[x].worked_hour;
                    this.empPayouts.push(employee);
                }
              
                console.log("original")
                console.log(this.original)

            });

        },
        info(item) {
            this.editedIndex = this.empPayouts.indexOf(item);
            this.editedItemInfo = Object.assign({}, item);
            this.editedItemInfo.overtimePrice = this.editedItemInfo.overtime * 9;
            this.empServices=[];
            this.editedItemInfo.wage = Number(this.editedItemInfo.firstPart) + Number(this.editedItemInfo.secondPart) + Number(this.editedItemInfo.overtimePrice)+ Number(this.editedItemInfo.lunchCard);
            console.log(this.editedItemInfo.wage)
            this.dayToHour= Number(this.actualPayout.works_days)*7.5
            this.app.req.get("employees_payouts_services/init/" + this.editedItemInfo.id).then((response) => {
                //this.empPayouts = response.data.payouts;
                
                this.empServices = response.data;
                
                console.log(this.empServices);
                 this.dialogEmployeeInfo = true;
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
        closeEmployeeInfo() {
            this.dialogEmployeeInfo = false;
            this.$nextTick(() => {
                this.editedItemInfo = Object.assign({}, this.defaultItemInfo);
                this.editedIndex = -1;
            });
        },

        save() {
            if (this.editedIndex > -1) {
                console.log('original item ')
                console.log(this.original[this.editedIndex])
                this.empPayout = Object.assign(this.original[this.editedIndex], this.editedItem);
               
                let obj=[];
                obj.payout_id=this.empPayout.payout_id;
                obj.employee_id=this.empPayout.employee_id
                obj.holiday=Number(this.empPayout.holiday)
                obj.first_part=Number(this.empPayout.firstPart)
                obj.second_part=Number(this.empPayout.secondPart)
                obj.lunch_card=Number(this.empPayout.lunchCard)
                obj.overtime=Number(this.empPayout.overtime)
                obj.worked_hour=Number(this.empPayout.workedHour)
                let obj1={};
                obj1= Object.assign(obj1,obj)
                this.app.req
                    .put("employees_payouts/" + this.editedItem.id, obj1)
                    .then((response) => {
                        

                    });
                this.init();

            }

            this.empPayout = [];
            //init

            this.close();
        },
        saveEmployeeInfo() {
            this.closeEmployeeInfo();
        }
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
</style><style scoped>
.headlineRight {}
</style>
