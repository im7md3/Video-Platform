<template>
        <!-- Sidebar -->
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
      <li class="nav-item" :class="{'active':route().current('welcome') }">
        <inertia-link class="nav-link text-right" href="/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>الإحصائيات</span></inertia-link>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">


      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item" :class="{'active':route().current('welcome') }">
        <inertia-link class="nav-link text-right" href="{{ route('welcome') }}">
        <i class="fas fa-user-lock"></i>
          <span>الصلاحيات</span>
        </inertia-link>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item " :class="{'active':route().current('welcome') }">
        <inertia-link class="nav-link text-right" :href="route('welcome')">
        <i class="fas fa-lock"></i>
          <span>القنوات المحظورة</span>
        </inertia-link>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item" :class="{'active':route().current('welcome') }">
        <inertia-link class="nav-link text-right" :href="route('welcome')">
        <i class="fas fa-film"></i>
          <span>القنوات</span>
        </inertia-link>
      </li>



      <!-- Nav Item - Charts -->
      <li class="nav-item" :class="{'active':route().current('welcome') }">
        <inertia-link class="nav-link text-right" :href=" route('welcome')">
        <i class="fas fa-table"></i>
          <span>الفيديوهات الأكثر مشاهدة</span></inertia-link>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
</template>

<script>
import JetApplicationMark from '@/Jetstream/ApplicationMark'
export default {
    components:{
        JetApplicationMark,
    }
}
</script>