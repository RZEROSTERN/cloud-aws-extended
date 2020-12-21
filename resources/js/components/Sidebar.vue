<template>
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="../assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
          <use xlink:href="../assets/brand/coreui.svg#signe"></use>
        </svg>
      </div>
      <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-title">My Manager</li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
          <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-inbox"></use>
            </svg> My buckets</a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#"><span class="c-sidebar-nav-icon"></span> Breadcrumb</a></li>
          </ul>
        </li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="../../../node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
            </svg> Users</a></li>
        <li class="c-sidebar-nav-divider"></li>
        <li class="c-sidebar-nav-item mt-auto"></li>
      </ul>
      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
</template>
<script>
export default {
  mounted() {
    this.fetchBuckets()
  },
  methods: {
    fetchBuckets() {
      
    }
  }
}
</script>