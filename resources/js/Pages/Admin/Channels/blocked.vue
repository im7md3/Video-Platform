<template>
    <admin-main>
        <template #heading>القنوات المحظورة</template>
<div class="row">
    <div class="col-md-12">
        <table id="videos-table" class="table table-stribed text-right" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>اسم القناة</th>
                    <th>البريد الإلكتروني</th>
                    <th>تاريخ الإنشاء</th>
                    <th>فك الحظر</th>

                </tr>
            </thead>

            <tbody>

                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.created_at }}</td>
                        <td>
                            <form style="display:inline-block">
                                    <button v-if="user.block==1" type="submit" class="btn btn-warning btn-sm" @click.prevent="updateBlock(user.id)"><i class="fa fa-lock-open"></i> فك الحظر</button>  
                            </form>
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
            users:Object
        },
        data(){
            return{
                admin_level:''
            }
        },
        methods:{
            
            updateBlock(id){
                this.$inertia.put(route('update.block'),{method:'PATCH','user_id':id},{
                    preserveScroll: true
                })
            },
           
            

        }
    }

</script>

<style scoped>

</style>