<template>
    <main-layout>
        <div class=" latest-download">
            <div class="container">
                <div class="row justify-content-center">
                    <form class="form-inline col-md-6 justify-content-center">
                        <input type="text" class="form-control mx-sm-3 mb-2" v-model="term" @keyup.prevent="search()">
                        <button type="submit" class="btn btn-info mb-2" @click.prevent="search()">ابحث</button>
                    </form>
                </div>
                <hr>
                <br>
                <p class="my-4">جميع القنوات</p>
                <div class="row">

                    <div v-for="channel in myChannels" :key="channel.id" class="col-sm-6 col-md-4 col-lg-3">
                        <div class="m-4">
                            <img class="rounded-full mx-auto" :src="channel.profile_photo_url">

                            <div class="card-body p-0">
                                <p class="text-center mt-4">{{ channel.name }}</p>
                            </div>
                            <div class="text-center">
                                <inertia-link :href="route('channel.videos', channel.name) "
                                    class="btn btn-info ">تصفح القناة</inertia-link>
                            </div>
                        </div>
                    </div>

                    <div v-if="myChannels.length==0" class="mx-auto">
                        <p>لا يوجد قنوات</p>
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
            channels: Object
        },
        data() {
            return {
                term: '',
                myChannels: this.channels
            }
        },
        methods: {
            search() {
                 axios.get(route('search.channels'),{params:{
       term: this.term
    }}).then((res) => {
                    this.myChannels = res.data
                }); 
 /*                axios({
    method: 'GET',
    url: route('search.channels'),
    params: {
       term: 123123
    }
}) */
            }
        }
    }

</script>

<style scoped>
img{
    width: 120px;
    height: 120px;
}
</style>