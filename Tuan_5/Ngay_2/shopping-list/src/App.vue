<template>
  <div>
    <AppNavbar />
    <FilterTabs :activeFilter="filter" @change-filter="filter = $event" />

    <button @click="openAddForm">➕ Thêm mặt hàng</button>

    <keep-alive>
      <component
        :is="currentView"
        v-bind="currentView === 'ItemList' 
          ? { items: filteredItems } 
          : { initialData: editingItem, isEditing: !!editingItem }"
        @submit="handleSubmit"
        @cancel="cancelEdit"
        @toggle="toggleItem"
        @edit="editItem"
        @delete="deleteItem"
      >
        <template #default>
          <h2>Shopping List</h2>
        </template>
        <template #empty>
          <p>No items to show</p>
        </template>
      </component>
    </keep-alive>
  </div>
</template>

<script>
import AppNavbar from './components/AppNavbar.vue';
import FilterTabs from './components/FilterTabs.vue';
import ItemList from './components/ItemList.vue';
import ItemForm from './components/ItemForm.vue';

export default {
  name: 'App',
  components: {
    AppNavbar,
    FilterTabs,
    ItemList,
    ItemForm
  },
  data() {
    return {
      items: [],
      filter: 'all',
      currentView: 'ItemList',
      editingItem: null
    };
  },
  computed: {
    filteredItems() {
      if (this.filter === 'purchased') return this.items.filter(i => i.purchased);
      if (this.filter === 'not-purchased') return this.items.filter(i => !i.purchased);
      return this.items;
    }
  },
  methods: {
    openAddForm() {
      this.editingItem = null;
      this.currentView = 'ItemForm';
    },
    handleSubmit(item) {
      if (this.editingItem) {
        const index = this.items.findIndex(i => i.id === this.editingItem.id);
        if (index !== -1) this.items.splice(index, 1, { ...item, id: this.editingItem.id });
      } else {
        this.items.push({ ...item, id: Date.now() });
      }
      this.editingItem = null;
      this.currentView = 'ItemList';
    },
    toggleItem(id) {
      const item = this.items.find(i => i.id === id);
      if (item) item.purchased = !item.purchased;
    },
    editItem(item) {
      this.editingItem = { ...item };  // clone để tránh sửa trực tiếp trong mảng
      this.currentView = 'ItemForm';
    },
    deleteItem(id) {
      this.items = this.items.filter(i => i.id !== id);
    },
    cancelEdit() {
      this.editingItem = null;
      this.currentView = 'ItemList';
    }
  },
  watch: {
    items: {
      handler(newItems) {
        localStorage.setItem('shopping-items', JSON.stringify(newItems));
      },
      deep: true
    }
  },
  mounted() {
    const saved = localStorage.getItem('shopping-items');
    if (saved) this.items = JSON.parse(saved);
  }
};
</script>

<style scoped>
div {
  max-width: 600px;
  margin: 0 auto;
  padding: 16px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

button {
  margin: 16px 0 24px 0;
  padding: 10px 16px;
  background-color: #2563eb; 
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  box-shadow: 0 3px 6px rgba(37, 99, 235, 0.4);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
  background-color: #1d4ed8; 
  box-shadow: 0 5px 10px rgba(29, 78, 216, 0.6);
}

button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.5);
}
</style>
