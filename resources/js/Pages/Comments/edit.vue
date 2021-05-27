<template>
    
</template>

<script>
import mainLayout from "@/Layouts/main";
import { Inertia } from '@inertiajs/inertia'
export default {
    components: {
            mainLayout,
        },
        props:{comment:Object},
        data(){
            return{
                form:Inertia.form({
                    body:'',
                    comment_id:this.comment.id
                })
            }
        },
        methods:{
            submit(){
                this.form.put(route('comment.update',this.comment.id))
            }
        }
}
</script>