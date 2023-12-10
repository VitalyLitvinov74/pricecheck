<script setup lang="ts">
const title = "Создать новый тип товаров"
useHead({
  title: title
})
</script>

<template>
  <div class="row">
    <div class="col-lg-12">
      <h5 class="card-title font-18">{{ title}}</h5>
    </div>
    <div class="col-lg-4">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">Text</h5>
        </div>
        <div class="card-body">
          <h6 class="card-subtitle">Usage <code>type="text"</code></h6>
          <div class="form-group mb-0">
            <input type="text" class="form-control" name="inputText" id="inputText" placeholder="Text Input">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>