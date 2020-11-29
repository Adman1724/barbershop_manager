<template>
<div>
    <div class="flex items-center justify-center mt-6 text-left">
        <v-card elevation="2" width="80%">
            <v-data-table data-app :headers="headers" :items="users" :items-per-page="10" class="elevation-1" loading loading-text="Loading... Please wait">
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title>Users</v-toolbar-title>
                        <v-divider class="mx-4" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                    New User
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
                                                <v-text-field v-model="editedItem.username" label="Username"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field v-model="editedItem.password"  :rules="[rules.required, rules.min]" type="password" name="input-10-1" label="Password" hint="At least 8 characters"></v-text-field>
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
                                    User?</v-card-title>
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
    props: {
        app: Object,
        nameRules: [
            (v) => !!v || "Name is required",
            (v) => (v && v.length <= 10) || "Name must be less than 10 characters",
        ],

        usernameRules: [
            (v) => !!v || "Name is required",
            (v) => (v && v.length <= 10) || "Userame must be less than 10 characters",
        ],
    },

    data() {
        return {
            dialog: false,
            dialogDelete: false,
            rules: {
                required: (value) => !!value || "Required.",
                min: (v) => v.length >= 8 || "Min 8 characters",
                emailMatch: () => `The email and password you entered don't match`,
                valid: true,
            },
            headers: [{
                    align: "start",
                    sortable: true,
                },
                {
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Username",
                    value: "username"
                },


                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                },
            ],
            users: [],
            user: Object,
            editedIndex: -1,
            editedItem: {
                name: "",
                username: "",
                password: "",

            },
            defaultItem: {
                name: "",
                username: "",
                password: "",
            },
        };
    },
    computed: {
        formTitle() {
            return "New User";
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
                this.app.req.get("auth/all").then((response) => {
                    this.users = response.data.users;
                    console.log(response);
                });
            } else {
                this.$router.push({
                    name: 'login'
                });
            }

        },

        editItem(item) {
            this.editedIndex = this.employees.indexOf(item);

            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.users.indexOf(item);

            this.editedItem = Object.assign({}, item);

            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.app.req.delete("auth/" + this.editedItem.id).then((response) => {
                console.log(response);
            });
            this.users.splice(this.editedIndex, 1);
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

        onSubmit( user) {
            const data = {
                name: this.user.name,
                username: this.user.username,
                password: this.user.password,
            };
            console.log(data);
            this.app.req
                .post("auth/register", data)
                .then((response) => {
                    console.log(response.data) ;


                })
                .catch((error) => {
                    this.error.push(error.response.data.error);
                    console.log(this.error);
                });
        },

        save() {

            this.user = this.editedItem;
            console.log(this.user)
            this.onSubmit(this.user);
            //this.users.push(this.editedItem)

            this.user = [];
            this.init();
            this.close();
        },
    },

};
</script>

<style>
</style>
