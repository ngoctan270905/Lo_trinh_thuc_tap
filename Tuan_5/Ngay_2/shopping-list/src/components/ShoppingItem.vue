<template>
  <div :class="{ purchased: item.purchased }" class="item">
    <label class="item-label">
      <input
        type="checkbox"
        :checked="item.purchased"
        @change="$emit('toggle', item.id)"
        class="checkbox"
      />
      <span class="item-name">{{ item.name }} (x{{ item.quantity }})</span>
    </label>
    <div class="actions">
      <button @click="$emit('edit', item)" class="btn edit-btn">Edit</button>
      <button @click="$emit('delete', item.id)" class="btn delete-btn">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ShoppingItem",
  props: {
    item: {
      type: Object,
      required: true,
      validator: (item) =>
        "id" in item && "name" in item && "purchased" in item,
    },
  },
};
</script>

<style scoped>
.item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 12px;
  border-bottom: 1px solid #ddd;
  background-color: #fff;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}

.item:hover {
  background-color: #f0f4f8;
}

.item-label {
  display: flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
  gap: 8px;
}

.checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.item-name {
  font-size: 1rem;
  color: #333;
}

.purchased .item-name {
  text-decoration: line-through;
  color: #888;
}

.actions {
  display: flex;
  gap: 8px;
}

.btn {
  padding: 4px 10px;
  font-size: 0.9rem;
  border: 1px solid transparent;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s ease, border-color 0.2s ease;
}

.edit-btn {
  background-color: #e0f2fe;
  border-color: #60a5fa;
  color: #2563eb;
}

.edit-btn:hover {
  background-color: #bae6fd;
  border-color: #3b82f6;
}

.delete-btn {
  background-color: #fee2e2;
  border-color: #f87171;
  color: #b91c1c;
}

.delete-btn:hover {
  background-color: #fecaca;
  border-color: #ef4444;
}
</style>
