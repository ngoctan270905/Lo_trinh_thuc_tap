<template>
  <md-card role="article" class="note-card">
    <md-card-header>
      <div class="md-title">{{ note.title }}</div>
    </md-card-header>
    <md-card-content>{{ note.content.slice(0, 100) }}...</md-card-content>
    <md-card-actions>
      <md-button @click="$emit('edit', note)">Sửa</md-button>
      <md-button @click="$emit('delete', note.id)" aria-label="Delete note">Xóa</md-button>
    </md-card-actions>
  </md-card>
</template>

<script setup>
defineProps(['note']);
defineEmits(['edit', 'delete']);
</script>
