<template>
<div>
    <div class="flex items-center justify-center mt-6 text-left">
        <v-card elevation="2" width="80%">
            <v-data-table data-app :headers="headers" :items="services" :items-per-page="10" class="elevation-1" loading loading-text="Loading... Please wait">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title>Services</v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                    New service
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
                                                <v-text-field v-model="editedItem.name" label="Name" class="capitalize"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field v-model="editedItem.price" label="Price" class="capitalize"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field v-model="editedItem.duration" label="Duration"></v-text-field>
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
                                <v-card-title class="headline">Are you sure you want to delete this
                                    service?</v-card-title>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
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
            headers: [{
                    align: "start",
                    sortable: true,
                },
                { text: "Name", value: "name" },
                { text: "Price", value: "price" },
                { text: "Duration", value: "duration" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            services: [],
            service: Object,
            editedIndex: -1,
            editedItem: {
                name: "",
                price: 0,
                duration: 0,

            },
            defaultItem: {
                name: "",
                price: 0,
                duration: 0,
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
            if (this.app.user) {
                this.app.req.get("service/init").then((response) => {
                    this.services = response.data.services;
                    console.log(response);
                });
            } else {
                this.$router.push({ name: 'login' });
            }

        },

    
    editItem(item) {
        this.editedIndex = this.services.indexOf(item);

        this.editedItem = Object.assign({}, item);
        this.dialog = true;
    },

    deleteItem(item) {
        this.editedIndex = this.services.indexOf(item);

        this.editedItem = Object.assign({}, item);

        this.dialogDelete = true;
    },

    deleteItemConfirm() {
        this.app.req.delete("service/" + this.editedItem.id).then((response) => {
            console.log(response);
        });
        this.services.splice(this.editedIndex, 1);
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
            this.service = Object.assign(
                this.services[this.editedIndex],
                this.editedItem
            );

            this.app.req
                .put("service/" + this.editedItem.id, this.service)
                .then((response) => {
                    console.log(response);
                });
        } else {
            this.service = this.editedItem;
            console.log(this.service);

            this.app.req.post("service/new", this.service).then((response) => {
                console.log(response);
            });
            this.services.push(this.editedItem);
        }
        this.service = [];
        this.init();
        this.close();
    },
  },

}
</script>

<style>
</style>
