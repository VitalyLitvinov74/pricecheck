<script setup lang="ts">

import {useBreadcrumbs} from "~/composables/useBreadcrumbs";
import {useProperties} from "~/composables/properties";
import {useFetch} from "#app";
import {da} from "@faker-js/faker";
import {$fetch} from "ofetch";

const title = "Свойства товаров"

const breadcrumbs = useBreadcrumbs();
breadcrumbs.renameButton('Редактировать')
breadcrumbs.changePageTitle(title);

useSeoMeta({
  title: title
})

const { data:result, error } = await useFetch(
    'http://api.pricecheck.my:82/api/product/all-properties-list',
)
console.log(result)
function save() {

}
</script>

<template>
  <div class="row">
<!--    <code>Это список свойств на основе которых создаются и обрабатываются товары</code>-->

    <div class="col-lg-12">
      <table class="table table-striped table-bordered" id="edit-btn">
        <thead>
        <tr>
          <th>#</th>
          <th>Название свойства</th>
          <th class="tabledit-toolbar-column"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(val, key) in result">
          {{val}}
        </tr>
        <!--        <tr v-for="(val, key, index) in props">-->
        <!--          <td>-->
        <!--            <span-->
        <!--                class="tabledit-span tabledit-identifier"-->
        <!--            >{{ key + 1 }}</span>-->
        <!--          </td>-->
        <!--          <td class="tabledit-view-mode" @click="updateProperty(key)">-->
        <!--            <span class="tabledit-span" :style="nowIsUpdating(key) ? `display: none;` : ``">{{ val.name }}</span>-->
        <!--            <input-->
        <!--                :ref="function(el){refs['property-'+key] = el}"-->
        <!--                class="tabledit-input form-control input-sm" type="text" v-model="val.name"-->
        <!--                :style="nowIsUpdating(key) ? `` : `display: none;`"-->
        <!--                :disabled="!nowIsUpdating(key)">-->
        <!--          </td>-->
        <!--          <td style="white-space: nowrap; width: 15%;">-->
        <!--            <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">-->
        <!--              <div class="btn-group btn-group-sm" style="float: none;">-->
        <!--                <button type="button" class="tabledit-edit-button btn btn-sm btn-info active"-->
        <!--                        style="float: none; margin: 5px; z-index:0" @click="updateProperty(key)">-->
        <!--                  <span class="ti-pencil"></span>-->
        <!--                </button>-->
        <!--                <button type="button" class="tabledit-delete-button btn btn-sm btn-info"-->
        <!--                        style="float: none; margin: 5px;" @click="removeProperty(key)"><span class="ti-trash"></span>-->
        <!--                </button>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--          </td>-->
        <!--        </tr>-->


        </tbody>
      </table>
      <!--      <div class="icon-box-list mb-3" @click="addProperty()">-->
      <!--        <div>-->
      <!--          <p class="m-0"><i class="ti-plus"></i></p>-->
      <!--        </div>-->
      <!--      </div>-->
    </div>

  </div>
</template>

<style scoped>

</style>