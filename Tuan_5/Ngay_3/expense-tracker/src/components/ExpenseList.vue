<template>
  <div class="expense-list">
    <div class="header">
      <slot name="header"></slot>
    </div>

    <div v-if="sortedExpenses.length === 0" class="empty-slot">
      <slot name="empty">Không có khoản chi nào.</slot>
    </div>

    <div v-else class="items-container" role="list">
      <ExpenseItem
        v-for="expense in sortedExpenses"
        :key="expense.id"
        :expense="expense"
        @delete="$emit('delete', $event)"
      />
    </div>
  </div>
</template>

<script>
import ExpenseItem from "./ExpenseItem.vue";

export default {
  name: "ExpenseList",
  components: { ExpenseItem },
  props: {
    expenses: {
      type: Array,
      required: true,
    },
  },
  emits: ["delete"],
  computed: {
    sortedExpenses() {
      return [...this.expenses].sort(
        (a, b) => new Date(b.date) - new Date(a.date)
      );
    },
  },
};
</script>

<style scoped>
.expense-list {
  background-color: #f7fafc;
  border-radius: 12px;
  padding: 16px 20px;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
  max-height: 400px;
  overflow-y: auto;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #2d3748;
}

.header {
  margin-bottom: 12px;
  font-size: 1.25rem;
  font-weight: 700;
  color: #2b6cb0;
  border-bottom: 2px solid #bee3f8;
  padding-bottom: 6px;
}

.empty-slot {
  padding: 40px 0;
  text-align: center;
  font-style: italic;
  color: #718096;
  font-size: 1rem;
}

.items-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
</style>
