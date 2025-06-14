// src/composables/useNotes.js
import { reactive, watch } from 'vue';

const notes = reactive(JSON.parse(localStorage.getItem('notes')) || []);

watch(notes, () => {
  localStorage.setItem('notes', JSON.stringify(notes));
}, { deep: true });

export function useNotes() {
  const addNote = (note) => {
    notes.push({ ...note, id: Date.now() });
  };

  const updateNote = (id, updated) => {
    const idx = notes.findIndex(n => n.id === id);
    if (idx !== -1) notes[idx] = { ...notes[idx], ...updated };
  };

  const deleteNote = (id) => {
    const idx = notes.findIndex(n => n.id === id);
    if (idx !== -1) notes.splice(idx, 1);
  };

  const getNote = (id) => notes.find(n => n.id === id);

  return { notes, addNote, updateNote, deleteNote, getNote };
}
