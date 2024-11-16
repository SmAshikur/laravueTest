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
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">

        <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Add Category</h3>
                <router-link
                to="/categories"
                class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
                >
                Back
                </router-link>
            </div>
      <form @submit.prevent="addCategory" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">
            Category Name
          </label>
          <input
            type="text"
            id="name"
            v-model="category.name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            placeholder="Enter category name"
            required
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md shadow-sm"
        >
          Add Category
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      category: {
        name: '',
      },
    };
  },
  methods: {
    async addCategory() {
      // Check if category name is empty
      if (!this.category.name.trim()) {
        alert('Category name cannot be empty!');
        return;
      }

      // Log category name to check its value before sending it
      console.log('Category Name:', this.category.name);

      // Prepare the category data to send
      const categoryData = {
        name: this.category.name,
      };

      try {
        // Send the data to the backend using Axios
        const response = await axios.post('/api/categories', categoryData);

        // Log success and clear the input field after success
        console.log('Category added:', response.data);

        // Clear the input field
        this.category.name = '';

        // Optionally, display a success message or redirect to the category list
        alert('Category added successfully!');
      } catch (error) {
        // Log the error response
        console.error('Error adding category:', error.response ? error.response.data : error.message);

        // Optionally, display a friendly error message to the user
        alert('Failed to add category. Please try again later.');
      }
    },
  },
};
</script>

<style scoped>
/* Add any specific styles if needed */
</style>
