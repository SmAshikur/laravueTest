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
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Categories</h3>
                <router-link
                to="/categories/create"
                class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
                >
                Create Category
                </router-link>
            </div>
      <table class="min-w-full table-auto border-collapse">
        <thead>
          <tr>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Category Name</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cat in categories" :key="cat.id" class="border-t">
            <td class="px-4 py-2 text-sm text-gray-800">{{ cat.name }}</td>
            <td class="px-4 py-2">
              <button
                @click="deleteCategory(cat.id)"
                class="bg-red-500 text-white text-sm py-1 px-3 rounded-md hover:bg-red-600 focus:outline-none"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- No categories message -->
      <div v-if="categories.length === 0" class="mt-4 text-center text-gray-600">
        No categories available.
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [], // Array to store categories
    };
  },
  mounted() {
    // Fetch the categories when the component is mounted
    this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/categories');
        this.categories = response.data;  // Populate the categories array with data from the API
      } catch (error) {
        console.error('Error fetching categories:', error);
        alert('Failed to load categories. Please try again later.');
      }
    },
    async deleteCategory(id) {
      if (confirm('Are you sure you want to delete this category?')) {
        try {
          await axios.delete(`/api/categories/${id}`);
          // After deleting, remove the category from the local array
          this.categories = this.categories.filter(cat => cat.id !== id);
          alert('Category deleted successfully!');
        } catch (error) {
          console.error('Error deleting category:', error);
          alert('Failed to delete category. Please try again later.');
        }
      }
    },
  },
};
</script>
