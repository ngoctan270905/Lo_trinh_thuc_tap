<template>
  <form @submit.prevent="handleSubmit" class="item-form">
    <h3>{{ isEditing ? 'Sửa mặt hàng' : 'Thêm mặt hàng' }}</h3>

    <input
      v-model="form.name"
      placeholder="Tên mặt hàng"
      required
      class="input-text"
    />
    <input
      v-model.number="form.quantity"
      type="number"
      min="1"
      class="input-number"
    />

    <button type="submit" :class="['btn-save', isEditing ? 'btn-update' : 'btn-add']">
      {{ isEditing ? 'Cập nhật' : 'Thêm' }}
    </button>
    <button v-if="isEditing" type="button" class="btn-cancel" @click="$emit('cancel')">Hủy</button>
  </form>
</template>

<script>
export default {
  name: "ItemForm",
  props: {
    initialData: {
      type: Object,
      default: () => ({ name: '', quantity: 1, purchased: false })
    },
    isEditing: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: { ...this.initialData }
    };
  },
  watch: {
    initialData(newVal) {
      this.form = { ...newVal };
    }
  },
  methods: {
    handleSubmit() {
      this.$emit('submit', { ...this.form });
      if (!this.isEditing) {
        this.form = { name: '', quantity: 1, purchased: false };
      }
    }
  }
};
</script>

<style scoped>
.item-form {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 24px;
  max-width: 400px;
}

h3 {
  margin: 0 0 8px 0;
  font-weight: 700;
  color: #333;
}

.input-text, .input-number {
  padding: 8px 12px;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  transition: border-color 0.3s;
  width: 100%;
}

.input-text:focus, .input-number:focus {
  outline: none;
  border-color: #2563eb; /* Blue */
  box-shadow: 0 0 5px rgba(37, 99, 235, 0.5);
}

.btn-save {
  padding: 10px 18px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s;
  color: white;
}

.btn-add {
  background-color: #2563eb;
}
.btn-add:hover {
  background-color: #1e40af;
}

.btn-update {
  background-color: #10b981; /* xanh lá cho nút cập nhật */
}
.btn-update:hover {
  background-color: #047857;
}

.btn-cancel {
  background-color: #ef4444; /* đỏ cho nút hủy */
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s;
}
.btn-cancel:hover {
  background-color: #b91c1c;
}
</style>
