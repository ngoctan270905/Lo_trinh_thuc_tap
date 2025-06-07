<template>
  <form @submit.prevent="submitForm" class="expense-form">
    <div class="form-group">
      <label for="name">Tên khoản chi</label>
      <input
        id="name"
        type="text"
        v-model="form.name"
        @keyup.enter="submitForm"
        placeholder="Nhập tên khoản chi"
        autocomplete="off"
      />
      <span v-if="errors.name" class="error">{{ errors.name }}</span>
    </div>

    <div class="form-group">
      <label for="amount">Số tiền (VND)</label>
      <input
        id="amount"
        type="number"
        v-model.number="form.amount"
        placeholder="Nhập số tiền"
        min="0"
      />
      <span v-if="errors.amount" class="error">{{ errors.amount }}</span>
      <span v-if="amountWarning" class="warning">{{ amountWarning }}</span>
    </div>

    <div class="form-group">
      <label for="category">Danh mục</label>
      <select id="category" v-model="form.category">
        <option disabled value="">Chọn danh mục</option>
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
      <span v-if="errors.category" class="error">{{ errors.category }}</span>
    </div>

    <div class="form-group">
      <label for="date">Ngày chi</label>
      <input id="date" type="date" v-model="form.date" />
      <span v-if="errors.date" class="error">{{ errors.date }}</span>
    </div>

    <button type="submit" :disabled="hasErrors" @click.stop>
      Thêm / Cập nhật
    </button>
  </form>
</template>

<script>
export default {
  name: "ExpenseForm",
  props: {
    categories: {
      type: Array,
      required: true,
    },
  },
  emits: ["submit"],
  data() {
    return {
      form: {
        name: "",
        amount: null,
        category: "",
        date: "",
      },
      errors: {},
      amountWarning: "",
    };
  },
  watch: {
    "form.amount"(newVal) {
      if (newVal > 1000000) {
        this.amountWarning = "Số tiền vượt quá 1,000,000 VND!";
      } else {
        this.amountWarning = "";
      }
    },
  },
  computed: {
    hasErrors() {
      // Kiểm tra validation lỗi hoặc form chưa đầy đủ
      return (
        Object.keys(this.errors).length > 0 ||
        !this.form.name ||
        this.form.amount === null ||
        !this.form.category ||
        !this.form.date
      );
    },
  },
  methods: {
    validate() {
      this.errors = {};
      if (!this.form.name || this.form.name.length < 3) {
        this.errors.name = "Tên khoản chi phải có ít nhất 3 ký tự.";
      }
      if (this.form.amount == null || this.form.amount <= 0) {
        this.errors.amount = "Số tiền phải là số dương.";
      }
      if (!this.form.category) {
        this.errors.category = "Vui lòng chọn danh mục.";
      }
      if (!this.form.date) {
        this.errors.date = "Vui lòng chọn ngày chi.";
      } else if (new Date(this.form.date) > new Date()) {
        this.errors.date = "Ngày không được lớn hơn ngày hiện tại.";
      }
    },
    submitForm() {
      this.validate();
      if (!this.hasErrors) {
        this.$emit("submit", { ...this.form, id: Date.now() });
        this.form = { name: "", amount: null, category: "", date: "" };
      }
    },
  },
};
</script>

<style scoped>
.expense-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
  background: #ffffff;
  padding: 24px 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgb(0 0 0 / 0.05);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  font-weight: 600;
  color: #4a5568;
  margin-bottom: 6px;
  font-size: 1rem;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid #cbd5e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.2s ease;
  box-sizing: border-box;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
select:focus {
  border-color: #3182ce;
  outline: none;
  box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
}

.error {
  color: #e53e3e;
  font-size: 0.85em;
  margin-top: 4px;
  font-weight: 600;
}

.warning {
  color: #d69e2e;
  font-size: 0.85em;
  margin-top: 4px;
  font-weight: 600;
}

button {
  align-self: flex-start;
  background-color: #3182ce;
  color: white;
  padding: 12px 28px;
  border: none;
  font-weight: 700;
  font-size: 1rem;
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:disabled {
  background-color: #a0aec0;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  background-color: #2c5282;
}
</style>
