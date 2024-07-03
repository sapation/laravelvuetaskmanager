<template>
    <div class="row mt-5">
        <div class="row">
            <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center">Register</h2><br><br>
                            <form @submit.prevent="submitRegister">
                                <div class="from-group mb-3">
                                    <Error label="E-mail" :errors="v$.email.$errors">
                                        <BaseInput type="email" v-model="registerInput.email"/>
                                    </Error>
                                </div>
                                <div class="from-group mb-3">
                                    <Error label="Password" :errors="v$.password.$errors">
                                         <BaseInput type="password" v-model="registerInput.password"/>
                                    </Error>
                                </div >
                               
                                <div class="from-group mb-3">
                                    <BaseBtn label="Register" :loading="loading" />
                                </div>

                                 <div class="from-group mb-3">
                                    <router-link to="/login">Login into your account</router-link>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</template>

<script lang='ts' setup>
    import { registerInput, useRegisterUser } from './actions/register'
    import { useVuelidate } from '@vuelidate/core'
    import {required, email} from '@vuelidate/validators'
    import Error from "../../components/Error.vue"
    import BaseInput from "../../components/BaseInput.vue"
    import BaseBtn from "../../components/BaseBtn.vue"

    const rules ={
        email: { required, email },
        password: { required }
    }

    const v$ = useVuelidate(rules, registerInput);
    const { loading, register } = useRegisterUser();
    async function submitRegister() {
        const result = await v$.value.$validate();
        if(!result) return;

        await register();
        v$.value.$reset();
    }

</script>
