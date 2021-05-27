<template>
    <main-layout>
        <div class="mx-4">
            <div class="row justify-content-center">
                <form class="form-inline col-md-6 justify-content-center">
                    <input type="text" class="form-control mx-sm-3 mb-2" v-model="term" @keyup.prevent="search()">
                    <button type="submit" class="btn btn-secondary mb-2" @click.prevent="search()">ابحث</button>
                </form>
            </div>
            <hr>
            <br>

            <p class="my-4">{{this.search==1?"عرض نتائج البحث عن ":"آخر الفيديوهات المرفوعة"}}</p>


            <div class="row">
                <div v-for="video in myVideos" :key="video.id" class="col-sm-6 col-md-4 col-lg-3 w-100">
                    <div class="card">
                        <div class="card-icons">

                                        <inertia-link :href="route('videos.show',video.id)">
                                            <img :src="$page.props.asset+video.image_path" class="card-img-top"
                                                alt="...">
                                            <time>{{ video.hours>0?video.hours+":":'' }}{{video.minutes}}:{{video.seconds}}</time>
                                            <i class="fas fa-play fa-2x"></i>
                                        </inertia-link>
                                    </div>
                                    <inertia-link :href="route('videos.show',video.id)">
                                        <div class="card-body px-3 py-2">
                                            <p class="card-title">{{ video.title.substring(0,60) }}</p>
                                        </div>
                                    </inertia-link>
                                    <div class="card-footer">
                                        <small class="text-muted">
                                            
                                                <span v-if="video.views.length>0" class="d-block"><i class="fas fa-eye"></i>
                                                    {{video.views[0].views_number}} مشاهدة</span>
                                            <span v-else class="d-block"><i class="fas fa-eye"></i>
                                                    0 مشاهدة</span>

                                            <i class="fas fa-clock"></i>
                                            <span>{{ video.created_at }}</span>
                                                        <span v-if="$page.props.user">
                                                            <button v-if="$page.props.user.id==video.user_id" type="submit" class="float-left" @click="deleteVideo(video)"><i
                                                                    class="far fa-trash-alt text-danger fa-lg"></i></button>
                                                                    
                                                            <button  v-if="$page.props.user.id==video.user_id" type="submit" class="float-left" @click="editVideo(video)"><i
                                                                    class="far fa-edit text-success fa-lg ml-3"></i></button>
                                                        </span>
                                                
                                        </small>
                                    </div>
                                </div>
                        </div>


                <div v-show="myVideos.length==0" class="mx-auto col-8">
                        <div class="alert alert-primary text-center" role="alert">
                            لا يوجد فيديوهات
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
        props: {
            videos: Array,
            searchState:Number
        },
        data(){
            return {
                myVideos:this.videos,
                    term:''
            }
        },
        methods:{
            deleteVideo($video){
                this.$inertia.delete(route('videos.destroy',$video.id),{
                    preserveScroll: true,
                })
            },
            editVideo($video){
                this.$inertia.get(route('videos.edit',$video.id),{
                    preserveScroll: false,
                })
            },
/* :_.throttle */
            search(){
                axios.post(route('searchInMyVideos'),{term:this.term}).then((res)=>{
                    this.myVideos=res.data
                });
            }
                
            
        },
        
        }
    

</script>
