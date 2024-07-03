<template>
    <div class="container ">
        <RouterView/>
    </div>
</template>

<script lang="ts" setup>
    import Vue, { ref } from 'vue'
    const count = ref<number>(0);
</script>