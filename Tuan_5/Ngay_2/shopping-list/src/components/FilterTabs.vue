<template>
  <div class="tabs">
    <button
      v-for="filter in filters"
      :key="filter.value"
      :class="{ active: activeFilter === filter.value }"
      @click="$emit('change-filter', filter.value)"
      type="button"
    >
      {{ filter.label }}
    </button>
  </div>
</template>

<script>
export default {
  name: "FilterTabs",
  props: {
    activeFilter: String
  },
  emits: ['change-filter'],
  data() {
    return {
      filters: [
        { label: "Tất cả", value: "all" },
        { label: "Đã mua", value: "purchased" },
        { label: "Chưa mua", value: "not-purchased" }
      ]
    };
  }
};
</script>

<style scoped>
.tabs {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
  justify-content: center;
}

button {
  background: none;
  border: none;
  padding: 8px 16px;
  font-size: 1rem;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  color: #555;
  transition: all 0.3s ease;
  font-weight: 500;
  border-radius: 4px 4px 0 0;
}

button:hover {
  color: #2563eb;
  border-bottom-color: #2563eb;
}

button.active {
  font-weight: 700;
  color: #2563eb;
  border-bottom: 3px solid #2563eb;
}
</style>
