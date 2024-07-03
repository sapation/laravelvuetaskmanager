<template>
    <div class="row mt-5">
        <div class="row">
            <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="text-center">Login</h2><br><br>
                            <form @submit.prevent="submitLogin">
                                <div class="from-group mb-3">
                                    <Error label="E-mail" :errors="v$.email.$errors">
                                        <BaseInput type="email" v-model="loginInput.email"/>
                                    </Error>
                                </div>
                                <div class="from-group mb-3">
                                    <Error label="Password" :errors="v$.password.$errors">
                                         <BaseInput type="password" v-model="loginInput.password"/>
                                    </Error>
                                </div >
                                <div class="from-group mb-3">
                                    <BaseBtn label="Login" :loading="loading" />
                                </div>

                                <div class="from-group mb-3">
                                    <router-link to="/register">Create an account</router-link>
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
    import { loginInput, useLoginUser } from './actions/login'
    import { useVuelidate } from '@vuelidate/core'
    import {required, email} from '@vuelidate/validators'

    const rules ={
        email: { required, email },
        password: { required }
    }

    const v$ = useVuelidate(rules, loginInput);
    const { loading, login } = useLoginUser();

    async function submitLogin() {
        const result = await v$.value.$validate();
        if(!result) return;

        await login();
        v$.value.$reset();
    }

</script>
