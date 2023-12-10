<script setup lang="ts">
useHead({
  bodyAttrs: {
    class: 'horizontal-layout'
  }
})
import '/public/plugins/switchery/switchery.min.css'
import '/public/css/bootstrap.min.css'
import '/public/css/icons.css'
import '/public/css/flag-icon.min.css'
import '/public/css/style.css'
</script>

<template>
  <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
    <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
    </div>
    <div class="infobar-settings-sidebar-overlay"></div>
    <MenuComponent/>
    <div id="containerbar" class="container-fluid">
      <div class="contentbar">
        <slot/>
      </div>
      <div class="footerbar">
        <footer class="footer">
          <p class="mb-0">© 2020 Orbiter - All Rights Reserved.</p>
        </footer>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>