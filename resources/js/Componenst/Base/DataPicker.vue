<script setup lang="ts">

import { defineEmits, defineProps, withDefaults } from 'vue'
interface DataPickerProps {
    currentDate?: string
    inputName?: string
    inputId?: string
    inputClass?: string
};

const props = withDefaults(defineProps<DataPickerProps>(), {
    currentDate: () => new Date().toISOString().slice(0, 10),
    inputName: 'date',
    inputId: 'date',
    inputClass: ''
});

const emit = defineEmits<{
    (e: 'update:input', value: string): void
}>()

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement
    emit('update:input', target.value)
}

</script>

<template>
    <div class="datapicker-wrap">
        <input
            :class="`form-control ${inputClass}`"
            :name="inputName"
            @input="handleInput"
            type="date"
            :value="currentDate"
            :id="inputId"
        />
    </div>
</template>
