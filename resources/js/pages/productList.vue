<template>
<nav class="bg-blue-600 p-4">
      <div class="max-w-7xl mx-auto flex justify-between items-center text-white">
        <a href="/" class="text-xl font-semibold">My App</a>
        <div class="space-x-4">
          <router-link to="/" class="hover:bg-blue-500 p-2 rounded-md">Home</router-link>
          <router-link to="/categories" class="hover:bg-blue-500 p-2 rounded-md">Categories</router-link>
          <router-link to="/products" class="hover:bg-blue-500 p-2 rounded-md">Products</router-link>
        </div>
      </div>
    </nav>
  <div class="p-6 bg-gray-100 min-h-screen">
    <!-- Header with 'Create Product' Button -->
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6 mb-4">
      <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Products</h3>
        <router-link
          to="/products/create"
          class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
        >
          Create Product
        </router-link>
      </div>
    </div>

    <!-- Product Table -->
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6">
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-gray-200">
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Image</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Product Name</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Categories</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Features</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(prod, index) in products"
            :key="prod.id"
            class="border-b border-gray-200"
          >
            <td class="px-4 py-2">
              <img
                :src="prod.image"
                alt="Product Image"
                class="w-16 h-16 object-cover rounded-md"
              />
            </td>
            <td class="px-4 py-2 text-sm text-gray-800">{{ prod.name }}</td>
            <td class="px-4 py-2 text-sm text-gray-600">
              <span v-for="(category, catIndex) in prod.categories" :key="catIndex">
                {{ category.name }}<span v-if="catIndex < prod.categories.length - 1">, </span>
              </span>
            </td>
            <td class="px-4 py-2 text-sm text-gray-600">
              <span v-for="(features, featureIndex) in prod.feature" :key="featureIndex">
                {{ features.description }}<span v-if="featureIndex < prod.feature.length - 1">, </span>
              </span>
            </td>
            <td class="px-4 py-2">
              <div class="flex space-x-4">
                <button
                  @click="editProduct(prod.id)"
                  class="text-blue-500 hover:text-blue-700 text-sm font-semibold"
                >
                  Edit
                </button>
                <button
                  @click="deleteProduct(prod.id)"
                  class="text-red-500 hover:text-red-700 text-sm font-semibold"
                >
                  Delete
                </button>
                <button
                  @click="showProduct(prod.id)"
                  class="text-green-500 hover:text-green-700 text-sm font-semibold"
                >
                  Show
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get('/api/products');
        this.products = response.data;
      } catch (error) {
        console.error('Error fetching products:', error);
        alert('Failed to load products. Please try again later.');
      }
    },
    editProduct(productId) {
      this.$router.push({ name: 'ProductEdit', params: { id: productId } });
    },
    async deleteProduct(productId) {
      const confirmed = window.confirm('Are you sure you want to delete this product?');
      if (confirmed) {
        try {
          await axios.delete(`/api/products/${productId}`);
          this.products = this.products.filter(prod => prod.id !== productId);
          alert('Product deleted successfully.');
        } catch (error) {
          console.error('Error deleting product:', error);
          alert('Failed to delete product. Please try again later.');
        }
      }
    },
    showProduct(productId) {
      this.$router.push({ name: 'ProductShow', params: { id: productId } });
    },
  },
};
</script>

<style scoped>
/* Add any specific styles if needed */
</style>
