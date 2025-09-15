<script lang="ts">
import {defineComponent} from 'vue'
import DataPicker from "../Base/DataPicker.vue";
import UploadFiles from "../Base/UploadFiles.vue";
import DownloadFileIcon from "../Icon/DownloadFileIcon.vue";
import WordIcon from "../Icon/WordIcon.vue";
import { downloadFile } from '../../Utils/fileDownload'

export default defineComponent({
    name: "ElsprFormPage",
    components: {
        DataPicker,
        UploadFiles,
        DownloadFileIcon,
        WordIcon,
    },
    props: {
        generateLink: {
            type: String,
            required: true
        },
        downloadExampleLink: {
            type: String,
            required: true
        },
        defaultCurrentDate: {
            type: String,
            required: true
        }
    },
    data() {
        return{
            a: 0,
            errors: [],
            files: [],
            currentDate: this.defaultCurrentDate,
        }
    },
    methods: {
        async downloadExample() {
            try {
                await downloadFile(this.downloadExampleLink, 'my-file.pdf')
                console.info('Файл скачан успешно')
            } catch (error) {
                console.error('Ошибка скачивания:', error)
            }
        },
        async submitForm(fileType) {
            this.errors = []
            const formData = new FormData(document.querySelector('#form'));
            formData.append('doc_type', fileType);
            try {
                if (this.files.length === 0) {
                    this.errors.push('Выберите файл!');
                    return false;
                }
                const response = await fetch(this.generateLink, {
                    method: 'POST',
                    body: formData
                });
                if (!response.ok) {
                    this.errors.push('Ошибка при отправке формы');
                    return false;
                }
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'document.doc'; // Можно динамически задать имя файла
                document.body.appendChild(a);
                a.click();

                // Очищаем
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            } catch (error) {
                console.error('Ошибка:', error);
                this.errors.push('Произошла ошибка при отправке формы')
            }

        }
    }
})
</script>

<template>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-6 bg-light border p-4 shadow-sm">
            <div v-if="errors.length">
                <div v-for="error in errors" :key="error" class="alert alert-danger">{{ error }}</div>
            </div>
            <form :action="generateLink" id="form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-12 mb-3">
                        <label for="formFile" class="form-label">Загрузите EXCEL форму с данными</label>
                        <upload-files
                            :input-id="`formFile`"
                            :name="`file`"
                            @update:input="(values) => files = values" />
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
                        <button @click.prevent="submitForm(`word`)"
                                type="submit"
                                name="doc_type"
                                value="word"
                                class="btn btn-primary me-2">
                            <word-icon />
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
