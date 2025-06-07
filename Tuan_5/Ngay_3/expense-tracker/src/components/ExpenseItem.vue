<template>
  <div class="expense-item" role="listitem">
    <div class="expense-info">
      <strong class="expense-name">{{ expense.name }}</strong>
      <span class="expense-category">- {{ expense.category }}</span>
      <span class="expense-date">- {{ formattedDate }}</span>
    </div>
    <div class="expense-actions">
      <span class="expense-amount">{{ formattedAmount }}</span>
      <button
        @click.stop="emitDelete"
        aria-label="Xóa khoản chi"
        class="btn-delete"
        title="Xóa khoản chi"
      >
        Xóa
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ExpenseItem",
  props: {
    expense: {
      type: Object,
      required: true,
      validator(obj) {
        return (
          obj.id &&
          obj.name &&
          obj.amount != null &&
          obj.category &&
          obj.date
        );
      },
    },
  },
  emits: ["delete"],
  computed: {
    formattedAmount() {
      return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
      }).format(this.expense.amount);
    },
    formattedDate() {
      return new Date(this.expense.date).toLocaleDateString();
    },
  },
  methods: {
    emitDelete() {
      this.$emit("delete", this.expense.id);
    },
  },
};
</script>

<style scoped>
.expense-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  margin-bottom: 8px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgb(0 0 0 / 0.07);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #2d3748;
  transition: background-color 0.3s ease;
}

.expense-item:hover {
  background-color: #edf2f7;
}

.expense-info {
  display: flex;
  gap: 8px;
  align-items: center;
  font-size: 1rem;
  flex-wrap: wrap;
  color: #4a5568;
}

.expense-name {
  font-weight: 700;
  color: #2b6cb0;
}

.expense-category,
.expense-date {
  font-style: italic;
  color: #718096;
}

.expense-actions {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 600;
  font-size: 1rem;
  color: #2c5282;
}

.btn-delete {
  background-color: #e53e3e;
  border: none;
  color: white;
  padding: 6px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
  user-select: none;
}

.btn-delete:hover {
  background-color: #9b2c2c;
}
</style>
