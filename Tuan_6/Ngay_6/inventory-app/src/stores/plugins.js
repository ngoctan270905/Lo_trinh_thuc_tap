export default function autoSavePlugin({ store }) {
  store.$subscribe((_mutation, state) => {
    if (store.$id === 'inventory') {
      localStorage.setItem('products', JSON.stringify(state.products))
    }
  })
}
