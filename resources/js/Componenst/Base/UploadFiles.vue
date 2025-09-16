<script setup lang="ts">
import {defineProps, withDefaults, ref, watchEffect, defineEmits, computed} from 'vue';
import {FileType} from "../../Types/FileTypes";
interface  UploadFilesProps{
    inputClass?: string
    name?: string
    inputId?: string
    isMultifile?: boolean
    accept?: FileType[]
};

const props = withDefaults(defineProps<UploadFilesProps>(), {
    inputClass: '',
    name: 'file',
    inputId: 'file-upload-input',
    isMultifile: false,
    accept: () => []
})

const calculateAccept = computed(() => {
    return props.accept.join(',');
});

const emit = defineEmits<{
    (e: 'update:input', value: File[]): void
}>();``

const files = ref<File[]>([]);

watchEffect(() => {
    emit('update:input', files.value);
});

const onFileChanged = ($event: Event) => {
    const target = $event.target as HTMLInputElement;
    if (target && target.files){
        if (!props.isMultifile){
            files.value = [];
            files.value.push(target.files[0])
        } else {
            clearFiles();
            files.value = Array.from(target.files);
        }
    }
}

const clearFiles = () => {
    files.value = [];
}
</script>

<template>
    <input :class="`form-control ${inputClass}`"
           :id="inputId"
           :name="name"
           type="file"
           :multiple="isMultifile"
           @change="onFileChanged($event)"
    >
</template>

<style scoped>

</style>
