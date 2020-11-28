<template>
<div>
    <div class="flex justify-center items-center">
        <div class="block w-1/2 ">
            Input file
        </div>

        <div class="block w-1/2">
            <template>
                <v-file-input accept="image/*" label="File input"></v-file-input>


            </template>
        </div>

    </div>
    <div class="block text-lg">
        Employees

    </div>
    <v-divider></v-divider>
    <div class="block">
        <employees-list-component :app="this.app"></employees-list-component>
    </div>
</div>
</template>

<script>

import EmployeesListComponent from '../payoutsComponents/EmployeesListComponent.vue'

export default {
    components:{
        EmployeesListComponent,


    },
    props:["app"],

}
</script>

<style>

</style>
