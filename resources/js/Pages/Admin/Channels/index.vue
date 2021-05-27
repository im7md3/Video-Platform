<template>
    <admin-main>
        <template #heading>صلاحيات القنوات</template>
<div class="row">
    <div class="col-md-12">
        <table id="videos-table" class="table table-stribed text-right" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>اسم القناة</th>
                    <th>البريد الإلكتروني</th>
                    <th>نوع القناة</th>
                    <th>تعديل</th>
                    <th>حذف</th>
                    <th>حظر</th>

                </tr>
            </thead>

            <tbody>

                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.admin_level==2 ? 'مدير عام' : user.admin_level==1 ? 'مدير' : 'مستخدم' }}</td>
                        <td>
                            <form class="ml-4 form-inline" style="display:inline-block">
                                <select class="form-control form-control-sm" @change="set_admin_level($event)">
                                    <option  disabled>اختر نوعًا</option>
                                    <option value="0" :selected="user.admin_level==0">مستخدم</option>
                                    <option value="1" :selected="user.admin_level==1">مدير</option>
                                    <option value="2" :selected="user.admin_level==2">مدير عام</option>
                                </select>
                                <button type="submit" class="btn btn-info btn-sm"  @click.prevent="updatePermission(user.id)"><i class="fa fa-edit"></i> تعديل</button> 
                            </form>
                        </td>
                        <td>
                            <form style="display:inline-block">
                                    <button v-if="$page.props.user.id!=user.id && $page.props.permission.update_users" type="submit" class="btn btn-danger btn-sm" @click.prevent="deleteChannel(user.id)"><i class="fa fa-trash"></i> حذف</button> 
                                
                                    <div v-else class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> حذف </div>
                                
                            </form>
                        </td>
                        <td>
                            <form style="display:inline-block">
                                
                                    <span v-if="$page.props.user.id!=user.id && $page.props.permission.update_users">
                                        <div v-if="user.block==1" class="btn btn-warning btn-sm disabled"><i class="fas fa-lock"></i> محظور </div> 
                                        
                                        <button v-else type="submit" class="btn btn-warning btn-sm" @click.prevent="blockChannel(user.id)"><i class="fa fa-lock"></i> حظر</button> 
                                    </span>
                                    
                                    <div v-else class="btn btn-warning btn-sm disabled"><i class="fas fa-lock"></i> حظر </div>

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
            set_admin_level(event){
                this.admin_level=event.target.value;
            },
            updatePermission(id){
                this.$inertia.put(route('update.permission'),{method:'PATCH','user_id':id,'admin_level':this.admin_level},{
                    preserveScroll: true
                })
            },
            blockChannel(id){
                this.$inertia.put(route('update.block'),{method:'PATCH','user_id':id},{
                    preserveScroll: true
                })
            },
            deleteChannel(id){
                this.$inertia.delete(route('delete.channel',id),{
                    preserveScroll: true
                })
            },
        }
    }

</script>

<style scoped>

</style>