<template>
  <div id="app" class="app-container">
    <h1 class="title">Ứng dụng Quản lý Chi tiêu Cá nhân</h1>

    <CategoryFilter v-model="selectedCategory" :categories="categories" />

    <ExpenseForm :categories="categories" @submit="addExpense" />

    <h2 class="total-amount">Tổng chi tiêu: {{ formattedTotal }}</h2>

    <ExpenseList :expenses="filteredExpenses" @delete="deleteExpense">
      <template #header>
        <h2 class="list-header">Danh sách khoản chi</h2>
      </template>
      <template #empty>
        <p class="empty-message">Không có khoản chi nào phù hợp.</p>
      </template>
    </ExpenseList>
  </div>
</template>

<script>
import CategoryFilter from './components/CategoryFilter.vue'
import ExpenseForm from './components/ExpenseForm.vue'
import ExpenseList from './components/ExpenseList.vue'

export default {
  name: 'App',
  components: { CategoryFilter, ExpenseForm, ExpenseList },
  data() {
    return {
      expenses: [],
      categories: ['Food', 'Transport', 'Entertainment', 'Other'],
      selectedCategory: ''
    }
  },
  computed: {
    filteredExpenses() {
      if (!this.selectedCategory) return this.expenses
      return this.expenses.filter(exp => exp.category === this.selectedCategory)
    },
    totalAmount() {
      return this.filteredExpenses.reduce((sum, exp) => sum + exp.amount, 0)
    },
    formattedTotal() {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(this.totalAmount)
    }
  },
  methods: {
    addExpense(expense) {
      this.expenses.push(expense)
    },
    deleteExpense(id) {
      this.expenses = this.expenses.filter(exp => exp.id !== id)
    }
  },
  watch: {
    expenses: {
      handler(newVal) {
        localStorage.setItem('expenses', JSON.stringify(newVal))
      },
      deep: true
    }
  },
  mounted() {
    const saved = localStorage.getItem('expenses')
    if (saved) {
      this.expenses = JSON.parse(saved)
    }
  }
}
</script>

<style scoped>
.app-container {
  max-width: 600px;
  margin: 40px auto;
  padding: 20px 24px;
  background-color: #fefefe;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #2d3748;
}

.title {
  text-align: center;
  color: #2b6cb0;
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 24px;
  user-select: none;
}

.total-amount {
  margin-top: 24px;
  text-align: right;
  font-weight: 600;
  font-size: 1.25rem;
  color: #38a169; /* green */
  user-select: none;
}

.list-header {
  color: #2c5282;
  font-weight: 700;
  margin-bottom: 12px;
  user-select: none;
}

.empty-message {
  color: #718096;
  font-style: italic;
  text-align: center;
  margin-top: 32px;
  user-select: none;
}
</style>
