<template>
<v-data-table data-app :headers="headers" :items="payouts" sort-by="date" class="elevation-1">
    <template v-slot:top>
        <v-toolbar flat>
            <v-toolbar-title>Payouts</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" min-width="400px">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                        New Payout
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>

                        <div class="block p-0">
                            <v-date-picker v-model="editedItem.date" :show-current="true" type="month"></v-date-picker>
                        </div>

                        <v-container>

                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="editedItem.works_days" label="Works Days"></v-text-field>
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
                    <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogUploadCSV" max-width="500px">
                <v-card>
                    <v-card-title class="headline">Upload CSV</v-card-title>
                    <v-card-text>

                        <v-file-input v-model="chosenFile" label="File input"></v-file-input>

                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeUploadCSV">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="saveUploadCSV">OK</v-btn>
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
        <v-icon small @click="updateCSVItem(item)"> mdi-cloud-upload </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
        <v-icon small @click="info(item)">mdi-information</v-icon>


    </template>
    <template v-slot:no-data>
        <v-btn color="primary" @click="init"> Reset </v-btn>
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
            actualDetail:[],

            modal: false,
            dialog: false,
            dialogDelete: false,
            dialogUploadCSV: false,
            headers: [{
                    align: "start",
                    sortable: false,
                    value: "name",
                },
                {
                    text: "date",
                    value: "date"
                },
                {
                    text: "Days",
                    value: "works_days"
                },
                {
                    text: "JSON",
                    value: "json_check"
                },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                },
            ],
            payouts: [],
            payout: [],
            chosenFile: null,
            editedIndex: -1,
            editedItem: {
                date: '',
                works_days: 0,
                json: null,
                json_check: null,
            },
            defaultItem: {
                date: '',
                works_days: 0,
                json: null,
                json_check: null,
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
        dialogUploadCSV(val) {

            val || this.closeUploadCSV();
        }
    },

    created() {

        this.init();

    },

    methods: {
        init() {
            var x;
            this.app.req.get("payout/init").then((response) => {
                this.payouts = response.data.payouts;
                console.log(this.payouts)
                for (x in this.payouts) {
                    this.payouts[x].date = this.payouts[x].date.substr(0, 7);

                    if (this.payouts[x].json !== null) {
                        this.payouts[x].json_check = 'true';

                    } else {
                         this.payouts[x].json_check = 'false';

                    }
                }

            });

        },

        async loadCSV() {
            const reader = new FileReader();
            reader.readAsText(this.chosenFile);
            const result = await new Promise((resolve, reject) => {
                reader.onload = function (event) {
                    resolve(reader.result)
                }
            });

            var a = result.toString();
            const lines = a.split('\n')
            const result1 = []
            const headers = lines[0].split(';')

            for (let i = 1; i < lines.length; i++) {
                if (!lines[i])
                    continue
                const obj = {}
                const currentline = lines[i].split(';')

                for (let j = 0; j < headers.length; j++) {
                    obj[headers[j]] = currentline[j]
                }
                result1.push(obj)
            }
            this.editedItem.json = result1;
            return result1;

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
        updateCSVItem(item) {
            this.editedIndex = this.payouts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.editedItem.json = null;
            this.dialogUploadCSV = true;
        },

        deleteItemConfirm() {
            this.app.req.delete("payout/" + this.editedItem.id).then((response) => {

            });
            this.payouts.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        info(item){

            this.actualDetail= item;
            console.log('item***', item)


            this.$root.$refs.EmployeesListComponent.actualPayout.id = this.actualDetail.id;
            this.$root.$refs.EmployeesListComponent.actualPayout.date =this.actualDetail.date;
            this.$root.$refs.EmployeesListComponent.actualPayout.works_days=this.actualDetail.works_days;
            this.$root.$refs.EmployeesListComponent.init();
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
        closeUploadCSV() {
            this.dialogUploadCSV = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        async saveUploadCSV(file) {
            this.payout = Object.assign(this.payouts[this.editedIndex], this.editedItem);
            this.payout.date = this.payout.date + '-01';


            await this.loadCSV(file).then(res => {

            });
            console.log(this.editedItem);


                 this.app.req
                .put("payout/json/" + this.editedItem.id, this.editedItem.json)
                .then((response) => {
                    console.log(response);

                });



            //this.payout = [];
            this.init();

            this.closeUploadCSV();
        },

        save() {
            if (this.editedIndex > -1) {
                this.payout = Object.assign(this.payouts[this.editedIndex], this.editedItem);
                this.payout.date = this.payout.date + '-01';
                this.app.req
                    .put("payout/" + this.editedItem.id, this.payout)
                    .then((response) => {

                    });

            } else {
                this.payout = this.editedItem;
                this.payout.date = this.payout.date + '-01';
                this.app.req.post("payout/new", this.payout).then((response) => {

                });

                this.payouts.push(this.editedItem);
            }

            this.payout = [];
            this.init();

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
