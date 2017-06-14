<template>
  <b-collapse id="busca-mais">
    <div class="row">

      <div class="col-1" v-if="1!=''">
        <slot name="1">
        </slot>
      </div>

      <div class="col-1" v-if="2!=''">
        <slot name="2">
        </slot>
      </div>

      <div class="col pull-right text-right" v-if="ultimo!=''">
        <slot name="ultimo"></slot>
      </div>

    </div>
  </b-collapse>
</template>

<script>
    export default {
      props: {
        1: '',
        2: '',
        ultimo: ''
      }
    }
</script>
