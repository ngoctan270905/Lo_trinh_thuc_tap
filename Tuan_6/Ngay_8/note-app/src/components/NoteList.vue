<template>
  <md-layout md-gutter>
    <md-layout md-flex-small="100" md-flex-medium="50" md-flex-large="33" v-for="n in notes" :key="n.id">
      <NoteItem :note="n" @delete="$emit('delete', $event)" @edit="$emit('edit', $event)" />
    </md-layout>
  </md-layout>
</template>

<script setup>
import NoteItem from './NoteItem.vue';

defineProps(['notes']);
defineEmits(['delete', 'edit']);
</script>
