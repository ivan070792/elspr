<script setup lang="ts">
import {defineProps, ref} from 'vue';
import UploadFiles from '../Base/UploadFiles.vue';
import {downloadFile} from '../../Utils/fileDownload';
import downloadFileIcon from '../Icon/DownloadFileIcon.vue';
import wordIcon from '../Icon/WordIcon.vue';
import {FileType} from "../../Types/FileTypes";
import DataPicker from "../Base/DataPicker.vue";

interface ElsprFormPageProps {
    generateLink: string,
    downloadExampleLink: string,
    defaultCurrentDate: string
}

const props = defineProps<ElsprFormPageProps>();

const errors = ref<string[]>([]);
const files = ref<File[]>([]);
const currentDate = ref(props.defaultCurrentDate);
const isSubmitFormProcessing = ref(false);

const formRef = ref<HTMLFormElement | null>(null);

const downloadExample = async () => {
    try {
        await downloadFile(props.downloadExampleLink, 'example.xlsx')
        console.info('Файл скачан успешно')
    } catch (error) {
        console.error('Ошибка скачивания:', error)
    }
}

const submitForm = async (fileType: FileType) => {
    errors.value = [];
    if (!formRef.value){
        console.error('Форма не найдена');
        return;
    }
    const formData = new FormData(formRef.value);
    formData.append('doc_type', fileType.valueOf());
    if (files.value.length === 0) {
        errors.value.push('Выберите файл!');
        return;
    }
    isSubmitFormProcessing.value = true;
    try {
        const response = await fetch(props.generateLink, {
            method: 'POST',
            body: formData
        });
        if (!response.ok) {
            errors.value.push('Ошибка при отправке формы');
            isSubmitFormProcessing.value = false;
            return;
        }
        const blob = await response.blob();
        const contentDisposition = response.headers.get('Content-Disposition');
        let filename = 'document.pdf'; // значение по умолчанию
        if (contentDisposition) {
            const matches = contentDisposition.match(/filename="?(.+)"?/);
            if (matches?.[1]) {
                filename = matches[1].split(';')[0]
            }
        }
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename; // Устанавливаем имя файла
        document.body.appendChild(a);
        a.click();

        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        isSubmitFormProcessing.value = false;
    } catch (error) {
        console.error('Ошибка:', error);
        errors.value.push('Произошла ошибка при отправке формы');
        isSubmitFormProcessing.value = false;
    }
}


</script>

<template>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-6 bg-light border p-4 shadow-sm">
            <div v-if="errors.length">
                <div v-for="error in errors" :key="error" class="alert alert-danger">{{ error }}</div>
            </div>
            <form :action="generateLink" id="form" ref="formRef" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-12 mb-3">
                        <label for="formFile" class="form-label">Загрузите EXCEL форму с данными</label>
                        <upload-files
                            :input-id="`formFile`"
                            :name="`file`"
                            v-model:input="files" />
                    </div>
                    <div class="col-lg-4 col-md-12 mb-3">
                        <label for="document_date" class="form-label">Дата создания документов</label>
                        <data-picker
                            :input-id="`document_date`"
                            :input-name="`document_date`"
                            :current-date="currentDate"
                            v-model:input="currentDate" />
                    </div>
                    <div class="col-md-12 col-lg-12 mb-3 d-md-flex">
                        <button @click.prevent="submitForm(FileType.DOC)"
                                type="button"
                                class="btn btn-primary me-2"
                                :disabled="isSubmitFormProcessing">
                            <word-icon v-if="!isSubmitFormProcessing" />
                            <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Сгенерировать WORD
                        </button>
                        <a class="btn align-middle me-2"
                           @click="downloadExample">
                            <download-file-icon />
                            Скачать форму EXCEL документа
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
