import { defineStore } from 'pinia'

export const useInventoryStore = defineStore('inventory', {
  state: () => ({
    products: []
  }),
  getters: {
    productCount: (state) => state.products.length,
    totalValue: (state) => state.products.reduce((sum, p) => sum + p.price * p.quantity, 0),
  },
  actions: {
    fetchProducts() {
      const saved = localStorage.getItem('products')
      this.products = saved ? JSON.parse(saved) : []
    },
    addProduct(product) {
      const newProduct = { id: Date.now(), ...product }
      this.products.push(newProduct)
      this.saveToStorage()
    },
    updateProduct(id, data) {
      const index = this.products.findIndex(p => p.id === id)
      if (index !== -1) {
        this.products[index] = { ...this.products[index], ...data }
        this.saveToStorage()
      }
    },
    deleteProduct(id) {
      this.products = this.products.filter(p => p.id !== id)
      this.saveToStorage()
    },
    saveToStorage() {
      localStorage.setItem('products', JSON.stringify(this.products))
    }
  }
})
