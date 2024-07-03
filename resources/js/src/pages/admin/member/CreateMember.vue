<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Create Member</h3>

                <form @submit.prevent="createMember">
                    <div class="from-group mb-3">
                        <Error label="Name" :errors="v$.name.$errors">
                            <BaseInput type="text" v-model="memberStore.memberInput.name"/>
                        </Error>
                    </div>

                    <div class="from-group mb-3">
                        <Error label="E-mail" :errors="v$.email.$errors">
                            <BaseInput type="email" v-model="memberStore.memberInput.email"/>
                        </Error>
                    </div>

                    <div class="from-group mb-3">
                        <BaseBtn 
                            :label="memberStore.edit ? 'Update Member' : 'Create member'" 
                            :class="memberStore.edit ? 'btn btn-warning' : 'btn btn-primary'"
                        :loading="loading" />
                    </div>

                    <div class="form-group">
                        <router-link to="/members"> View members </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useCreateOrUpdateMember } from './actions/createMember'
import { useVuelidate } from '@vuelidate/core'
import {required, email} from '@vuelidate/validators'
import { memberStore } from './store/memberStore'

    const rules ={
        email: { required, email },
        name: { required }
    }

    const v$ = useVuelidate(rules, memberStore.memberInput);
    const { loading, createOrUpdateMember } = useCreateOrUpdateMember();

    async function createMember() {
        const result = await v$.value.$validate();
        if(!result) return;

        await createOrUpdateMember();
        v$.value.$reset();
    }
</script>