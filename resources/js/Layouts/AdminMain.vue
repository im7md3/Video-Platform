<template>
    <div id="wrapper">
        <ul class="pr-0 navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <inertia-link class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <div class="flex-shrink-0 flex items-center">

                        <jet-application-mark class="block h-9 w-auto p-2" />

                    </div>
                </div>
            </inertia-link>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" :class="{'active':route().current('admin.index') }">
                <inertia-link class="nav-link text-right" :href="route('admin.index')">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>الإحصائيات</span></inertia-link>
            </li>

            <!-- Divider -->



            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item" :class="{'active':route().current('channels.index') }">
                <inertia-link class="nav-link text-right" :href="route('channels.index')">
                    <i class="fas fa-user-lock"></i>
                    <span>الصلاحيات</span>
                </inertia-link>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item " :class="{'active':route().current('channel.blocked') }">
                <inertia-link class="nav-link text-right" :href="route('channel.blocked')">
                    <i class="fas fa-lock"></i>
                    <span>القنوات المحظورة</span>
                </inertia-link>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item" :class="{'active':route().current('channels.all') }">
                <inertia-link class="nav-link text-right" :href="route('channels.all')">
                    <i class="fas fa-film"></i>
                    <span>القنوات</span>
                </inertia-link>
            </li>



            <!-- Nav Item - Charts -->
            <li class="nav-item" :class="{'active':route().current('most.views') }">
                <inertia-link class="nav-link text-right" :href=" route('most.views')">
                    <i class="fas fa-table"></i>
                    <span>الفيديوهات الأكثر مشاهدة</span></inertia-link>
            </li>

            <!-- Divider -->


        </ul>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="mr-4 lead"><b>
                            <slot name="heading"></slot>
                        </b></div>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $page.props.user.name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" style="right:-90px">
                                <inertia-link class="dropdown-item text-right" href="#" @click="logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    تسجيل خروج
                                </inertia-link>
                            </div>
                        </li>

                    </ul>

                </nav>


                <!-- Begin Page Content -->
                <div  class="container-fluid">

                    <div v-if="$page.props.flash.flash_message" class="p-3 mb-2 bg-success text-white rounded text-center">
                        {{ session('flash_message') }}
                    </div>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            <slot name="title"></slot>
                        </h1>
                    </div>
        <div v-if="$page.props.flash.success" class="p-3 mb-2 bg-success text-white rounded mx-auto col-8">
            <span class="text-center">{{ $page.props.flash.success }}</span>
        </div>
        <div v-if="$page.props.flash.fail" class="p-3 mb-2 bg-danger text-white rounded mx-auto col-8">
            <span class="text-center">{{ $page.props.flash.fail }}</span>
        </div>
                    <slot></slot>
                </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>جميع الحقوق محفوظة &copy; {{ new Date().getFullYear() }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
        <inetia-link class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </inetia-link>
    </div>

</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'

    export default {

        components: {
            JetApplicationMark,
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }

</script>

<style scoped>
    @import url(https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i);

</style>
