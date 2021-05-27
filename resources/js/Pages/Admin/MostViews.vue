<template>
    <admin-main>
        <template #heading>الفيديوهات الاكثر مشاهدة</template>
        <div class="row justify-content-center">

            <div class="col-md-12">
                <table id="videos-table" class="table table-stribed text-right" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>اسم الفيديو</th>
                            <th>اسم القناة</th>
                            <th>عدد المشاهدات</th>
                            <th>تاريخ النشر</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr v-for="view in mostVideos" :key="view.id">
                            <td>
                                <inertia-link :href="route('videos.show',view.video.id)">{{ view.video.title }}
                                </inertia-link>
                            </td>
                            <td>
                                <inertia-link :href="route('channel.videos',view.user.name)">{{ view.user.name }}
                                </inertia-link>
                            </td>
                            <td>{{ view.views_number }}</td>
                            <td>
                                <p>{{ view.video.created_at }}</p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>



        </div>

        <div>
            <canvas id="myChart" class="mt-4"></canvas>
        </div>
    </admin-main>
</template>

<script>
    import adminMain from "@/Layouts/AdminMain";
    export default {
        components: {
            adminMain
        },
        props: {
            mostVideos: Array,
            names: Array,
            videoViews: Array
        },
        data() {
            return {}
        },
        mounted() {

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: this.names,
                    datasets: [{
                        label: 'الفيديوهات الأكثر مشاهدة',
                        backgroundColor: 'rgb(0, 33, 47)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: this.videoViews
                    }]
                },

                // Configuration options go here
                options: {}
            });

        }
    }

</script>
