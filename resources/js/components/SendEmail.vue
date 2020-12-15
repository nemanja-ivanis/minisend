<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Send Email
                        <a href="/" class="btn btn-primary">Go Back</a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="success">
                            You have successfully sent the email.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="failed">
                            There were errors when trying to send the email. Please try again later.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <form @submit.prevent="submit">

                            <div class="mb-3">
                                <label for="from" class="form-label">From(Sender):</label>
                                <div class="input-group has-validation">
                                    <input :class="{ 'is-invalid': form.errors.has('from') }" type="email" class="form-control" id="from" aria-describedby="from" v-model="form.from" required>
                                    <span
                                        class="invalid-feedback "
                                        v-if="form.errors.has('from')"
                                        v-text="form.errors.first('from')"
                                    ></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="to" class="form-label">To(Recipient):</label>
                                <div class="input-group has-validation">
                                    <input :class="{ 'is-invalid': form.errors.has('to') }" type="email" class="form-control" id="to" aria-describedby="to" v-model="form.to" required>
                                    <span
                                        class="invalid-feedback "
                                        v-if="form.errors.has('to')"
                                        v-text="form.errors.first('to')"
                                    ></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject:</label>
                                <div class="input-group has-validation">
                                    <input :class="{ 'is-invalid': form.errors.has('subject') }" v-model="form.subject" type="text" class="form-control" id="subject" aria-describedby="subject" required>
                                    <span
                                        class="invalid-feedback "
                                        v-if="form.errors.has('subject')"
                                        v-text="form.errors.first('subject')"
                                    ></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="text_content" class="form-label">Text content:</label>
                                <div class="input-group has-validation">
                                    <textarea :class="{ 'is-invalid': form.errors.has('text_content') }" v-model="form.text_content" class="form-control" id="text_content" required>
                                    </textarea>
                                    <span
                                        class="invalid-feedback "
                                        v-if="form.errors.has('text_content')"
                                        v-text="form.errors.first('text_content')"
                                    ></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="html_content" class="form-label">HTML content:</label>
                                <div class="input-group has-validation">
                                    <vue-editor class="form-control editor" :editor-toolbar="modules" v-model="form.html_content" :class="{ 'is-invalid': form.errors.has('html_content') }" required></vue-editor>
                                       <span
                                        class="invalid-feedback "
                                        v-if="form.errors.has('html_content')"
                                        v-text="form.errors.first('html_content')"
                                    ></span>
                                </div>

                            </div>

                            <VueFileAgent
                                ref="vueFileAgent"
                                :theme="'list'"
                                :multiple="true"
                                :deletable="true"
                                :meta="true"
                                :accept="'image/*,.pdf,.doc,.docx'"
                                :maxSize="'10MB'"
                                :maxFiles="4"
                                :helpText="'Choose files to upload'"
                                :errorText="{
      type: 'Invalid file type. Only images, videos, pdf and word files are allowed.',
      size: 'Files should not exceed 10MB in size',
    }"
                                v-model="form.attachments"
                                @beforedelete="onBeforeDelete($event)"
                            ></VueFileAgent>

                            <hr>
                            <button type="submit" class="btn btn-success" :disabled="form.processing">Send Email</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

    import Form from '@imritesh/form';
    import { VueEditor } from "vue2-editor";
    import VueFileAgent from 'vue-file-agent';
    import VueFileAgentStyles from 'vue-file-agent/dist/vue-file-agent.css';

    Vue.use(VueFileAgent);

    export default {
        components: {Form, VueEditor},
        data() {
            return {
                form:new Form({from:'', to:'', subject:'', text_content:'', html_content:'', attachments: []}, {resetOnSuccess: true}),
                success: false,
                failed: false,
                modules:["bold", "italic", "underline",{ list: "ordered" }, { list: "bullet" }, 'link'],
                fileRecordsForUpload: [],
                file:[]
            }
        },
        methods:
        {
            upload($event)
            {
                //this.file = $event[0].file;
            },
            submit()
            {

                this.form.post('/api/send-email',{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {

                        if(response.sent)
                        {
                            this.success = true;
                            this.failed = false;
                        }else{
                            this.success = false;
                            this.failed = true;
                        }

                    }).catch(response => {
                        this.failed = true;
                        this.success = false;
                    }
                );
            },
            onBeforeDelete: function (fileRecord) {
                var i = this.fileRecordsForUpload.indexOf(fileRecord);
                if (i !== -1) {
                    this.fileRecordsForUpload.splice(i, 1);
                    var k = this.form.attachments.indexOf(fileRecord);
                    if (k !== -1) this.form.attachments.splice(k, 1);
                } else {
                    this.$refs.vueFileAgent.deleteFileRecord(fileRecord);
                }
            }
        }
    };
</script>
