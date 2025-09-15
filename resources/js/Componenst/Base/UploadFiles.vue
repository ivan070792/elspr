<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "UploadFiles",
    emits: ['update:input'],
    props: {
        inputClass: {
            type: String,
            default: () => {
                return '';
            }
        },
        name: {
            type: String,
            default: () => {
                return 'file';
            }
        },
        inputId: {
            type: String,
            default: () => {
                return 'file-upload-input';
            }
        },
        isMultifile: {
            type: Boolean,
            default: () => {
                return false;
            }
        },
        accept: {
            type: Array,
            default: () => {
                return [];
            }
        }
    },
    data() {
        return {
            files: [],
        }
    },
    methods: {
        onFileChanged($event: Event) {
            const target = $event.target as HTMLInputElement;
            if (target && target.files){
                if (!this.isMultifile){
                    this.files = [];
                } else {
                    this.clearFiles();
                    this.files.push(target.files[0]);
                }
            }
        },
        clearFiles() {
            this.files = [];
        }
    },
    computed:{
        calculateAccept(){
            return this.accept.join(',');
        },
    },
    watch: {
        files: {
            handler(newVal: File[]) {
                console.log(newVal)
                this.$emit('update:input', newVal);
            },
            deep: true,
            immediate: true // Эмитить значение при создании компонента
        }
    }

})
</script>

<template>
    <input :class="`form-control ${inputClass}`"
           :id="inputId"
           :name="name"
           type="file"
           :multiple="isMultifile"
           @change="onFileChanged($event)"
           :accept="calculateAccept"
    >
</template>

<style scoped>

</style>
