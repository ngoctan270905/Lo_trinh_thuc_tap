<template>
  <section>
    <slot>
      <h2 class="title">Items</h2>
    </slot>

    <div v-if="items.length === 0" class="empty">
      <slot name="empty">
        <p>No items in list</p>
      </slot>
    </div>

    <div v-else class="item-list">
      <ShoppingItem
        v-for="item in items"
        :key="item.id"
        :item="item"
        @toggle="$emit('toggle', $event)"
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
      />
    </div>
  </section>
</template>

<script>
import ShoppingItem from './ShoppingItem.vue';

export default {
  name: 'ItemList',
  components: { ShoppingItem },
  props: {
    items: {
      type: Array,
      required: true
    }
  },
  emits: ['toggle', 'edit', 'delete']
};
</script>

<style scoped>
section {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 16px;
  background-color: #fafafa;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.title {
  margin-bottom: 12px;
  font-weight: 700;
  font-size: 1.5rem;
  color: #333;
}

.empty {
  padding: 16px;
  font-style: italic;
  color: #666;
  text-align: center;
}

.item-list {
  display: flex;
  flex-direction: column;
  gap: 8px; /* tạo khoảng cách giữa các item */
}
</style>
