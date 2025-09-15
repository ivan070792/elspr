<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "DataPicker",
    emits: ['update:input'],
    props: {
        currentDate: {
            type: String,
            default: () => {
                return new Date().toISOString().slice(0, 10)
            }
        },
        inputName: {
            type: String,
            default: () => {
                return 'date'
            }
        },
        inputId: {
            type: String,
            default: () => {
                return 'date'
            }
        },
        inputClass: {
            type: String,
            default: () => {
                return '';
            }
        }
    },

})
</script>

<template>
    <div class="datapicker-wrap">
        <input :class="`form-control ${inputClass}`"
               :name="inputName"
               @input="$emit('update:input', $event.target.value)"
               type="date"
               :value="currentDate"
               :id="inputId">
    </div>
</template>
