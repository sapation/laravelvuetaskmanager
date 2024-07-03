<template>
    <label for="">{{ label }}</label>
    <div :class="{error: props.errors.length}">
        <slot></slot>
        <div class="input-errors" v-for="error of props.errors" :key="error.$uid">
            <div class="error-msg">{{ error.$message }}</div>
        </div>
    </div>
</template>

<script lang='ts' setup>
    import { ErrorObject } from '@vuelidate/core';

    const props = defineProps<{
        label:string,
        errors: ErrorObject[];
    }>();
</script>

<style scoped>
    .input-errors{
        color: red;
    }
</style>