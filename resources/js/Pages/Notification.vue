<template>
    <main-layout>
            <div class="container">
        <p class="my-4 font-weight-bold">جميع الإشعارات</p>
        <div class="row">
            <div v-if="notifications.length>0" class="">
                <div v-for="notification in notifications" :key="notification.id" class="notification_body">
                    <div class="card mb-2" style="width: 56rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">
                                    <div class="icon-circle bg-secondary">
                                        <i class="far fa-bell text-white"></i>
                                    </div>
                                </div>
                                <div class="col-10"> 
                                    <i class="far fa-clock"></i> <span class="comment_date text-secondary">{{notification.created_at}}</span>
                                    
                                    
                                    <p class="mt-3" v-if="notification.type=='App\\Notifications\\VideoSuccess'">تهانينا لقد تم معالجة مقطع الفيديو <inertia-link :href="route('videos.show',notification.data.video.id)">{{notification.data.video.title}}</inertia-link> بنجاح</p>

                                       <p class="mt-3" 
                                       v-else-if="notification.type=='App\\Notifications\\CommentNotification'">لقد قام <inertia-link :href="route('channel.videos',notification.data.user.name)">{{notification.data.user.name}}</inertia-link>
                                        بوضع تعليق على 
                                        <inertia-link :href="route('videos.show',notification.data.video.id)">{{notification.data.video.title}}</inertia-link> </p>

                                       <p class="mt-3" v-else>لقد قام <inertia-link :href="route('channel.videos',notification.data.user.name)">{{notification.data.user.name}}</inertia-link> بالإعجاب بالفيديو الخاص بك <inertia-link :href="route('videos.show',notification.data.video.id)">{{notification.data.video.title}}</inertia-link> </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
                <div v-else class="mx-auto col-8">
                    <div class="alert alert-primary text-center" role="alert">
                         لا يوجد إشعارات      
                    </div>
                </div>

        </div>
    </div>
    </main-layout>
</template>

<script>
    import mainLayout from "@/Layouts/main";
    import {
        Inertia
    } from '@inertiajs/inertia'
    export default {
        components: {
            mainLayout,
        },
        props: {
            notifications:Object
        },
        data() {
            return {
                
            }
        },
        
    }

</script>

<style scoped>


</style>