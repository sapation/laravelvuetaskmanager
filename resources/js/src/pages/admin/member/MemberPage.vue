<template>
   <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Members
                        <router-link to="/create-member" class="btn btn-primary float-end">Create Member</router-link>
                    </div>
                    <div class="card-body">
                        <MemberTable 
                        @editMember="editMember"
                        :loading="loading"
                        @getMember="getMembers"
                        :members="memberData" >

                        <template #pagination>
                            <Bootstrap5Pagination 
                                v-if="memberData?.data"
                                :data="memberData?.data"
                                @pagination-change-page="getMembers"
                            />
                        </template>
                    </MemberTable>
                    </div>
                </div>
            </div>
        </div>
   </div>

</template>

<script lang="ts" setup>
import { onMounted } from "vue";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import MemberTable from "./components/MemberTable.vue";
import { MemberType, useGetMembers } from './actions/getMember';
import { useRouter } from "vue-router";
import { memberStore } from "./store/memberStore";
import { MemberInputType } from './actions/createMember'


const {getMembers, memberData, loading} = useGetMembers();


async function showListOfMembers() {
    await getMembers();
}

const router = useRouter();

function editMember(member:MemberType) {
    memberStore.memberInput = member;
    memberStore.edit = true;
    router.push('/create-member')
}

onMounted(async () => {
    showListOfMembers();
    memberStore.edit = false;
    memberStore.memberInput = {} as MemberInputType;
})

</script>