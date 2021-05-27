<template>
    <main-layout>
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="card mb-2 col-md-8">
                    <div class="card-header text-center">
                        {{ __('Upload new Video') }}
                    </div>

                    <div v-if="$page.props.user.block==1" class="alert alert-danger" role="alert">
                    للأسف لا تستطيع رفع مقاطع فيديو، يرجى التواصل مع الإدارة لمعرفة السبب
                </div>
                    <div v-else  class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="submit">

                            <div class="form-group ">
                                <label for="title">عنوان الفيديو</label>
                                <input type="text" id="title" class="form-control" v-model="form.title">

                                <span v-if="form.errors.title" class="text-bolder text-danger text-sm">
                                    <strong>{{ form.errors.title }}</strong>
                                </span>

                            </div>

                            <div class="form-group file-area">
                                <label for="image">صورة الغلاف</label>
                                <input type="file" class="form-control" @change="fileAdded()" id="image"
                                    accept="image/*">
                                <div class="input-title">اسحب الصورة إلى هنا أو انقر للاختيار يدويًا</div>
                                <img src="" v-if="form.image">
                                <span v-if="form.errors.image" class="text-bolder text-danger text-sm">
                                    <strong>{{ form.errors.image }}</strong>
                                </span>

                            </div>
                            <div class="row ">
                                <img id="cover-image-thumb" class="col-2" width="100" height="100">
                                <span class="input-name col-6" v-html="content_image"></span>
                            </div>


                            <div class="form-group file-area">
                                <label for="video">مقطع الفيديو</label>
                                <input type="file" id="video" accept="video/*" @change="readVideo" class="form-control">
                                <div class="input-title">اسحب مقطع الفيديو إلى هنا أو انقر للاختيار يدويًا</div>

                                <span v-if="form.errors.video" class="text-bolder text-danger text-sm">
                                    <strong>{{ form.errors.video }}</strong>
                                </span>

                            </div>
                            <div class="row">
                                <span id="video-name mb-4" v-html="content_video"></span>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary">رفع الفيديو</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
    import mainLayout from "@/Layouts/main";
    import { Inertia } from '@inertiajs/inertia'
   
    export default {
        components: {
            mainLayout,
        },
        data() {

            return {
                content_image:"",
                content_video:"",
                form: Inertia.form({
                    title: "",
                    video: "",
                    image: ''
                })
            }
        },

        methods: {
            fileAdded() {
                const input = document.getElementById('image');
                if (input.files && input.files[0]) {
                    this.form.image = input.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('cover-image-thumb').setAttribute('src', e.target.result);
                    };
                    this.content_image=input.files[0].name;
                    reader.readAsDataURL(input.files[0]);
                }

            },
            readVideo() {
                const input = document.getElementById('video');
                this.form.video = input.files[0];
                var reader = new FileReader();
            
            reader.readAsDataURL(input.files[0]);
            this.content_video='<div class="alert alert-primary">تم اختيار مقطع الفيديو بنجاح '+input.files[0].name+ '</div>';
            

            },
            submit() {
                this.form.post(route('videos.store'),{
                    preserveScroll: true,
                    onSuccess: () => {
                        
                    this.form.reset()
                    },
                    onError:()=>{}
                
                })
            },
        }
    }

</script>
