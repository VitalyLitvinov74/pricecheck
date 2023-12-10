<script setup lang="ts">
useHead({
  bodyAttrs: {
    class: 'horizontal-layout'
  },
  script: [
    {src: "/assets/js/jquery.min.js", body: true},
    {src: "/assets/js/popper.min.js", body: true},
    {src: "/assets/js/bootstrap.min.js", body: true},
    {src: "/assets/js/modernizr.min.js", body: true},
    {src: "/assets/js/detect.js", body: true},
    {src: "/assets/js/jquery.slimscroll.js", body: true},
    {src: "/assets/js/horizontal-menu.js", body: true},
    {src: "/assets/plugins/switchery/switchery.min.js", body: true},
    {src: "/assets/js/core.js", body: true},
  ],

  link: [
    {rel: 'stylesheet', href: '/assets/plugins/switchery/switchery.min.css'},
    {rel: 'stylesheet', href: '/assets/css/bootstrap.min.css'},
    {rel: 'stylesheet', href: '/assets/css/icons.css'},
    {rel: 'stylesheet', href: '/assets/css/flag-icon.min.css'},
    {rel: 'stylesheet', href: '/assets/css/style.css'},
  ]
})

</script>

<template>
  <div>
    <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
      <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
        <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close"></a>
      </div>
      <div class="infobar-settings-sidebar-body">
        <div class="custom-mode-setting">
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Payment Reminders</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-first" checked /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Stock Updates</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-second" checked /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Open for New Products</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-third" /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Enable SMS</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Newsletter Subscription</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">Show Map</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-sixth" /></div>
          </div>
          <div class="row align-items-center pb-3">
            <div class="col-8"><h6 class="mb-0">e-Statement</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
          </div>
          <div class="row align-items-center">
            <div class="col-8"><h6 class="mb-0">Monthly Report</h6></div>
            <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
          </div>
        </div>
      </div>
    </div>
    <Menu/>
    <div id="containerbar" class="container-fluid">

      <div class="breadcrumbbar">
        <div class="row align-items-center">
          <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Basic Elements</h4>
            <div class="breadcrumb-list">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
              </ol>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
              <button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Actions</button>
            </div>
          </div>
        </div>
      </div>
      <div class="contentbar">
        <slot/>
      </div>
      <div class="footerbar">
        <footer class="footer">
          <p class="mb-0">© 2024 Литвинов Виталий.</p>
        </footer>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>