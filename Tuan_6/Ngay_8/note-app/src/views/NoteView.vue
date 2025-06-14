<template>
  <div>
    <NoteForm />
    <NoteList :notes="notes" @delete="deleteNote" />
  </div>
</template>

<script setup>
import { useNotes } from '../composables/useNotes';
import NoteForm from '../components/NoteForm.vue';
import NoteList from '../components/NoteList.vue';

const { notes, deleteNote } = useNotes();
</script>
