

<template>
    <div class="row">
        <div class="row">
            <div class="col-md-4 mb-3">
                <input @keydown="search" v-model="query" type="text" class="form-control" placeholder="Searching...">
                <span class="text-red" v-show="loading? true: false"><b>Searching...</b></span>
            </div>
        </div>
        <div class="row">
             <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Edit</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="member in members?.data?.data" :key="member.id">
                        <td>{{member.id}}</td>
                        <td>{{member.name}}</td>
                        <td>{{member.email}}</td>
                        <td>
                            <button @click="emit('editMember', member)" class="btn btn-outline-primary">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <slot name="pagination"></slot>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { myDebounce } from "../../../../helper/util";
import { GetMemberType, MemberType } from "../actions/getMember"

//Defining props in vue
defineProps<{
    members: GetMemberType,
    loading: boolean
}>()

//Creating Emitting functions in vue
const emit = defineEmits<{
    (e:'editMember', member:MemberType):void;
    (e:'getMember',page:number, query: string): Promise<void>
}>()

//Query parameter
const query = ref('');

// Search functionality
const search = myDebounce(async function() {
    await emit('getMember',1, query.value)
}, 200)
</script>