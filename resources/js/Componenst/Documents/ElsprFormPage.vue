<script lang="ts">
import {defineComponent} from 'vue'
import DataPicker from "../Base/DataPicker.vue";
import UploadFiles from "../Base/UploadFiles.vue";
import { downloadFile } from '../../Utils/fileDownload'

export default defineComponent({
    name: "ElsprFormPage",
    components: {
        DataPicker,
        UploadFiles
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
        async submitForm() {
            const params = {

            }
        }
    }
})
</script>

<template>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-6 bg-light border p-4 shadow-sm">
            <div class="alert alert-danger"
                 v-if="errors.length">
            </div>
            <form :action="generateLink" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-12 mb-3">
                        <label for="formFile" class="form-label">Загрузите EXCEL форму с данными</label>
<!--                        <input class="form-control" name='file' type="file" id="formFile" required>-->
                        <upload-files :input-id="`formFile`" @update:input="(values) => files = values"></upload-files>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-3">
                        <label for="document_date" class="form-label">Дата создания документов</label>
                        <data-picker
                            :input-id="`document_date`"
                            :input-name="`document_date`"
                            :current-date="currentDate"
                            v-model:input="currentDate">
                        </data-picker>
                    </div>
                    <div class="col-md-12 col-lg-12 mb-3 d-md-flex">
                        <button type="submit" name="doc_type" value="word"  class="btn btn-primary me-2"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                      <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                      <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                    </svg></span>
                            Сгенерировать WORD
                        </button>
                        <a class="btn align-middle me-2" @click="downloadExample"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                        <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                    </svg></span> Скачать форму EXCEL документа</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
