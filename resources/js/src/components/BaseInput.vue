<template>
    <input 
        :value="modelValue"
        :type="typeof type==='undifined' ? 'text' :  type" 
        class="form-control" 
        @input="updateValue"
        placeholder=""
        >
</template>

<script lang="ts" setup>
    defineProps<{
        type?: string,
        modelValue: string
    }>();

    const emit = defineEmits<{
        (e:'update:modelValue', val:any):void
    }>();

    function updateValue(event:any) {
        const val=event.target.value;
        emit('update:modelValue', val);
    }
</script>
