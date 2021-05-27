<template>
    <admin-main>
        <template #heading>جميع القنوات</template>
        <div class="row">
            <div class="col-md-12">
                <table id="videos-table" class="table table-stribed text-right" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>اسم القناة</th>
                            <th>البريد الإلكتروني</th>
                            <th>عدد مقاطع الفيديو</th>
                            <th>مجموع المشاهدات</th>
                        </tr>
                    </thead>

                    <tbody>

                            <tr v-for="channel in channels" :key="channel.id">
                                <td><inertia-link
                                        :href="route('channel.videos', channel.name)">{{ channel.name }}</inertia-link>
                                </td>
                                <td>{{ channel.email }}</td>
                                <td>{{ channel.videos.length }}</td>
                                <td>
                                    <p>{{ channel.views_count }}</p>
                                </td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </admin-main>
</template>

<script>
    import adminMain from "@/Layouts/AdminMain";

    export default {
        components: {
            adminMain
        },
        props:{
            channels:Object
        },
       mounted(){
           console.log(this.channels);
       }
    }

</script>

<style scoped>

</style>