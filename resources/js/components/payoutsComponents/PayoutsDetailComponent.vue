<template>
<div>


    <div class="block">
        <employees-list-component :app="this.app"></employees-list-component>
    </div>
</div>
</template>

<script>
import EmployeesListComponent from '../payoutsComponents/EmployeesListComponent.vue'

export default {
    components: {
        EmployeesListComponent,

    },
    props: ["app"],

}
</script>

<style>

</style>
