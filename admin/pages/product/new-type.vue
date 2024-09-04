<script setup lang="ts">
import {fakerRU as faker} from "@faker-js/faker";
import {nextTick} from "vue";
import Joi from "joi";

const title = "Создать новый тип товаров"
const props = reactive([])
const schema = Joi.object({
  props: Joi.array().items(
      Joi.object(
      { name: Joi.string().required().messages({
          'string.empty': 'Название свойства не может быть пустым'
        })
      }
  ))
})
const refs = ref({})
const currentUpdatingPropertyKey = ref(0);

function nowIsUpdating(key){
  return key == currentUpdatingPropertyKey.value;
}

function addProperty() {
  props.push({name: ""})
  currentUpdatingPropertyKey.value = props.length - 1
  updateProperty(props.length - 1)
}

function removeProperty(key) {
  props.splice(key, 1)
}

function updateProperty(key) {
  currentUpdatingPropertyKey.value = key;

  //фокусировка на input
  nextTick(() => {
    refs.value['property-' + key].focus();
  });
}
const config = useRuntimeConfig();
async function save() {
  const validateResult = schema.validate(props);
  if(validateResult.hasOwnProperty('error')){
    console.log(validateResult.error?.message, validateResult)
    return;
  }
  await $fetch(
      'http://api.pricecheck.my:82/api/product/product-type',
      {
        method: 'POST',
        body: props
      }
  )
}
</script>

<template>
  <div class="row">
    <div class="col-lg-12">
      <h5 class="card-title font-18">{{ title }}</h5>
      <h6 class="card-subtitle"><code>Это поля, для фильтра поиска, далее по этим унифицированным полям можно будет
        осуществлять поиск</code></h6>
    </div>
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
        <tr v-for="(val, key, index) in props">
          <td>
            <span
                class="tabledit-span tabledit-identifier"
            >{{ key + 1 }}</span>
          </td>
          <td class="tabledit-view-mode" @click="updateProperty(key)">
            <span class="tabledit-span" :style="nowIsUpdating(key) ? `display: none;` : ``">{{ val.name }}</span>
            <input
                :ref="function(el){refs['property-'+key] = el}"
                class="tabledit-input form-control input-sm" type="text" v-model="val.name"
                :style="nowIsUpdating(key) ? `` : `display: none;`"
                :disabled="!nowIsUpdating(key)">
          </td>
          <td style="white-space: nowrap; width: 15%;">
            <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
              <div class="btn-group btn-group-sm" style="float: none;">
                <button type="button" class="tabledit-edit-button btn btn-sm btn-info active"
                        style="float: none; margin: 5px; z-index:0" @click="updateProperty(key)">
                  <span class="ti-pencil"></span>
                </button>
                <button type="button" class="tabledit-delete-button btn btn-sm btn-info"
                        style="float: none; margin: 5px;" @click="removeProperty(key)"><span class="ti-trash"></span>
                </button>
              </div>
            </div>
          </td>
        </tr>


        </tbody>
      </table>
      <div class="icon-box-list mb-3" @click="addProperty()">
        <div>
          <p class="m-0"><i class="ti-plus"></i></p>
        </div>
      </div>
    </div>
    <div class="col-lg-12 mb-5">
      <button type="button" class="btn btn-outline-success" @click="save">Сохранить</button>
    </div>
  </div>
</template>

<style scoped>

</style>