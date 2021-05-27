<template>
    <main-layout>
        <div class="mx-4">
            <div class="row justify-content-center" >
                <form class="form-inline col-md-6 justify-content-center" v-if="videos.length>0">
                    <button type="submit" class="btn btn-danger mb-2" @click.prevent='deleteAll()'>حذف السجل</button>
                </form>
            </div>
            <hr>
            <br>

            <div class="row">
                <div v-for="video in videos" :key="video.id" class="col-sm-6 col-md-4 col-lg-3 w-100">
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
                                            <span>{{ new Date(video.pivot.created_at).toISOString().split('T')[0]}}</span>
                                                            <button  type="submit" class="float-left" @click="deleteOne(video)"><i
                                                                    class="far fa-trash-alt text-danger fa-lg"></i></button>
                                        </small>
                                    </div>
                                </div>
                        </div>

                <div v-show="videos.length==0" class="mx-auto col-8">
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
        },
        data(){
            return {
            }
        },
        methods:{
            deleteOne(video){
                this.$inertia.delete(route('history.destroy',video.pivot.id),{
                    preserveScroll: true,
                })
            },
            deleteAll(){
                this.$inertia.delete(route('history.delete'),{
                    preserveScroll: true,
                })
            },
            },
/* :_.throttle */
            
        
        }
    

</script>
