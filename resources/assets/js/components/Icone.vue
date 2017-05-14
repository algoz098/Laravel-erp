<template>
    <i :class="'fa fa-' + icon + ' level' + level"></i>
</template>

<script>
    export default {
      props: {
        level: {
          default: 0
        },
        icon: {
          default: 'user'
        }
      },
    }
</script>
