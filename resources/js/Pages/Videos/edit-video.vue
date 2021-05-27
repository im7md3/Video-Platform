<template>
    <main-layout>
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="card mb-2 col-md-8">
                    <div class="card-header text-center">
                        عدّل بيانات الفيديو
                    </div>


                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="submit">

                            <div class="form-group ">
                                <label for="title">عنوان الفيديو</label>
                                <input type="text" id="title" class="form-control" v-model="form.title" >

                                <span v-if="form.errors.title" class="text-bolder text-danger text-sm">
                                    <strong>{{ form.errors.title }}</strong>
                                </span>

                            </div>

                            <div class="form-group file-area">
                                <label for="image">صورة الغلاف</label>
                                <input type="file" class="form-control" @change="fileAdded()" id="image"
                                    accept="image/*">
                                <div class="input-title">اسحب الصورة إلى هنا أو انقر للاختيار يدويًا</div>
                                <img  v-if="form.image">
                                <span v-if="form.errors.image" class="text-bolder text-danger text-sm">
                                    <strong>{{ form.errors.image }}</strong>
                                </span>

                            </div>
                            <div class="row ">
                                <img id="cover-image-thumb" class="col-2" width="100" height="100" :src="this.src">
                                <span class="input-name col-6" v-html="content_image"></span>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary">عدل</button>
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
        props:{my_video:Object},
        data() {

            return {
                src:this.$page.props.asset+this.my_video.image_path,
                content_image:"",
                form: this.$inertia.form({
                    title:this.my_video.title,
                    id: this.my_video.id,
                    image: '',
                    _method: 'put',
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

            submit() {
                this.form.post(route('videos.update',this.my_video.id),{
                    preserveScroll: true,
                })
            },
        },

    }

</script>
