<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light bg-white">
            <inertia-link class="navbar-brand" href="#">{{ __('Pegasus Video') }}</inertia-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item  mt-2" :class="route().current('welcome') ? 'active' : ''">
                        <inertia-link class="nav-link" :href="route('welcome')">
                            <i class="fas fa-home"></i>
                            {{ __('Home') }}
                        </inertia-link>
                    </li>

                    <li v-if="$page.props.user" class="nav-item  mt-2" :class="route().current('history.index') ? 'active' : ''">
                        <inertia-link class="nav-link" :href=" route('history.index') ">
                            <i class="fas fa-history"></i>
                            {{ __('History') }}
                        </inertia-link>
                    </li>

                    <li v-if="$page.props.user" class="nav-item  mt-2"
                        :class="route().current('videos.create') ? 'active' : ''">
                        <inertia-link class="nav-link" :href="route('videos.create')">
                            <i class="fas fa-upload"></i>
                            {{ __('Upload Video') }}
                        </inertia-link>
                    </li>

                    <li v-if="$page.props.user" class="nav-item  mt-2"
                        :class="route().current('videos.index') ? 'active' : ''">
                        <inertia-link class="nav-link" :href="route('videos.index')">
                            <i class="far fa-play-circle"></i>
                            {{ __('My Videos') }}
                        </inertia-link>
                    </li>


                    <li class="nav-item  mt-2" :class="route().current('channel.index') ? 'active' : ''">
                        <inertia-link class="nav-link" :href="route('channel.index')">
                            <i class="fas fa-film"></i>
                            {{ __('Chanels') }}
                        </inertia-link>
                    </li>

                </ul>

                <ul class="navbar-nav mr-auto">
                    <div class="topbar" style="z-index:1" v-if="$page.props.user">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow alert-dropdown mx-1  ">
                            <a class="nav-link dropdown-toggle my-a" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="zeroNot">
                                <i class="fas fa-bell fa-fw fa-lg"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter notif-count"
                                        data-count="0" v-if="$page.props.notifCount>0">{{$page.props.notifCount}}<!-- {{ App\Models\Alert::where('user_id', Auth::user()->id)->first()->alert }} --></span> 
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right text-right mt-2"
                                aria-labelledby="alertsDropdown">
                                <div class="alert-body">
                                 <a v-for="msg in messages" :key="msg.id" class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="ml-3">
                                        <div class="icon-circle bg-secondary">
                                            <i class="far fa-bell text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{msg.created_at}}</div>
                                       <inertia-link :href="route('videos.show',msg.data.video.id)" v-if="msg.type=='App\\Notifications\\VideoSuccess'">تهانينا لقد تم معالجة مقطع الفيديو <b>{{msg.data.video.title}}</b> بنجاح</inertia-link>
                                       <inertia-link :href="route('videos.show',msg.data.video.id)"  v-else-if="msg.type=='App\\Notifications\\CommentNotification'">لقد قام <b>{{msg.data.user.name}}</b> بوضع تعليق على <b>{{msg.data.video.title}}</b> </inertia-link>
                                       <inertia-link :href="route('videos.show',msg.data.video.id)" v-else>لقد قام <b>{{msg.data.user.name}}</b> بالإعجاب بالفيديو الخاص بك <b>{{msg.data.video.title}}</b> </inertia-link>
                                       
                                    </div>
                                </a>

                                </div>
                                <inertia-link class="dropdown-item text-center small text-gray-500"
                                    :href="route('all.noti')">عرض جميع الإشعارات</inertia-link>
                            </div>
                        </li>

                    </div>

                    <span v-if="!$page.props.user" class="d-flex">
                        <li class="nav-item mt-2">
                            <inertia-link class="nav-link" :href="route('login')">
                                {{ __('تسجيل الدخول') }}
                            </inertia-link>
                        </li>

                        <li class="nav-item mt-2">
                            <inertia-link class="nav-link" :href="route('register')">
                                {{ __('إنشاء حساب') }}
                            </inertia-link>
                        </li>
                    </span>

                    <span v-else>
                        <li class="nav-item dropdown justify-content-left mt-2">
                            <a id="navbarDropdown" class="nav-link" href="#" data-toggle="dropdown">
                                <img class="h-8 w-8 rounded-full" :src="$page.props.user.profile_photo_url"
                                    :alt=" $page.props.user.name " />
                            </a>
                            <div class="dropdown-menu dropdown-menu-left px-2 text-right mt-2">


                                <div class="pt-1 pb-1 ">
                                    <div class="flex items-center px-4 py-2 ">

                                        <div class="flex-shrink-0 ml-3">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                :src="$page.props.user.profile_photo_url"
                                                :alt=" $page.props.user.name " />
                                        </div>

                                        <div class="ml-3">
                                            <div class="font-medium text-base text-gray-800">
                                                {{ $page.props.user.name }}</div>
                                            <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center px-4 py-2 border-top border-gray-300 pt-2">
                                        <!-- Account Management -->
                                        <inertia-link :href="route('profile.show')"
                                            class="font-medium text-base text-gray-800">

                                            {{ __('profile') }}
                                        </inertia-link>
                                    </div>

                                    <div @click="logout" class="flex items-center  py-2 border-top border-gray-300 pt-2">
                                        <inertia-link class="dropdown-item ">
                                            {{ __('logout') }}
                                        </inertia-link>
                                    </div>

                                    <div class="flex items-center  border-top border-gray-300 pt-2">
                                        <inertia-link v-if="$page.props.permission.update_videos" :href="route('admin.index')"
                                            class="dropdown-item ">لوحة الإدارة
                                        </inertia-link>
                                    </div>

                                </div>
                            </div>
                        </li>
                    </span>
                </ul>
    </div>

    </nav>

    <main class="py-4">


        <div v-if="$page.props.flash.success" class="p-3 mb-2 bg-success text-white rounded mx-auto col-8">
            <span class="text-center">{{ $page.props.flash.success }}</span>
        </div>
        <div v-if="$page.props.flash.fail" class="p-3 mb-2 bg-danger text-white rounded mx-auto col-8">
            <span class="text-center">{{ $page.props.flash.fail }}</span>
        </div>


        <slot></slot>
    </main>
    </div>
</template>

<script>
    import JetNavLink from '@/Jetstream/NavLink'
    export default {
        components: {
            JetNavLink
        },
        data(){
            return{
                messages: this.$page.props.myNotifications,
            }
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
            zeroNot(){
                this.$page.props.notifCount=0
                axios.post(route('readNot'));
            }
        },
        created(){
            var self=this;
            if(this.$page.props.user){
            Echo.private(`App.Models.User.${this.$page.props.user.id}`).notification((notification)=>{
                self.$page.props.notifCount++;
                var not={
                    'created_at':notification.date,
                    'data':{
                        'video':{
                            'title':notification.video.title,
                            'id':notification.video.id
                        },
                        'user':{
                            'name':notification.user.name
                        }
                    },
                    'type':notification.type
                }
                
                            this.messages.unshift(not);

            })
}
        },

    }

</script>

<style scoped>
@import url(https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap);
@import url(https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css);

</style>
