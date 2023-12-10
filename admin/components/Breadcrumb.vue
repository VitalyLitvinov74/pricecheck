<script setup lang="ts">
    const route = useRoute()
    const crumbs = function () {
      const crumbs = []
      route.matched.forEach((item, i, {length}) => {
        const crumb = {}
        crumb.path = item.path
        crumb.name = routes[item.path]

        // is last item?
        if (i === length - 1) {
          // is param route? .../.../:id
          crumbs.push({
            path: item.path.replace(/\/:[^/:]*$/, ''),
            name: item.name.replace(/-[^-]*$/, '')
          })
          crumb.classes = 'active'
        }

        crumbs.push(crumb)
      })
      return crumbs
    }

    const routes = {
        '/product/new-type': 'Новый тип продукта'
    }

</script>

<template>
  <div class="breadcrumbbar">
    <div class="row align-items-center">
      <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Basic Elements</h4>
        <div class="breadcrumb-list">
          <ol class="breadcrumb">
            <li v-for="(item, i) in crumbs()" :key="i" class="breadcrumb-item">
              <NuxtLink :to="item.path">
                {{ item.name }}
              </NuxtLink>
            </li>
<!--            <li class="breadcrumb-item"><a href="">Home</a></li>-->
<!--            <li class="breadcrumb-item"><a href="">Forms</a></li>-->
<!--            <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>-->
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
</template>

<style scoped>

</style>