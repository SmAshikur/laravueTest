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
    <!-- Form Section -->
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
       <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Products</h3>
        <router-link
          to="/products/create"
          class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
        >
          Add Product
        </router-link>
      </div>
      <form @submit.prevent="addProduct" class="space-y-6">
        <!-- Product Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
          <input
            type="text"
            id="name"
            v-model="product.name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            placeholder="Enter product name"
            required
          />
          <p v-if="errors.name" class="text-sm text-red-500 mt-1">{{ errors.name }}</p>
        </div>

        <!-- Product Image -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
          <input
            type="file"
            id="image"
            ref="imageInput"
            @change="onImageChange"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            accept="image/*"
            required
          />
          <p v-if="errors.image" class="text-sm text-red-500 mt-1">{{ errors.image }}</p>
          <div v-if="product.imagePreview" class="mt-4">
            <img :src="product.imagePreview" alt="Preview" class="w-32 h-32 object-cover rounded-md" />
          </div>
        </div>

        <!-- Categories -->
        <div>
          <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
          <select
            id="categories"
            v-model="product.categories"
            multiple
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
          >
            <option v-for="category in availableCategories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Features -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Features</label>
          <div v-for="(feature, index) in product.features" :key="index" class="flex space-x-2 mt-1">
            <input
              type="text"
              v-model="product.features[index]"
              class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
              placeholder="Enter feature"
            />
            <button
              type="button"
              @click="removeFeature(index)"
              class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md"
            >
              Remove
            </button>
          </div>
          <button
            type="button"
            @click="addFeature"
            class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm"
          >
            Add More
          </button>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md shadow-sm"
        >
          Add Product
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
      product: {
        name: '',
        image: null,
        imagePreview: null,
        categories: [],
        features: [],
      },
      availableCategories: [],
      errors: {
        name: '',
        image: '',
        categories: '',
      },
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/categories');
        this.availableCategories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
        alert('Failed to load categories. Please try again later.');
      }
    },
    onImageChange(event) {
      const file = event.target.files[0];
      if (file) {
        if (!file.type.startsWith('image/')) {
          this.errors.image = 'Invalid file type. Please upload an image.';
          return;
        }
        this.errors.image = '';
        const reader = new FileReader();
        reader.onload = (e) => {
          this.product.imagePreview = e.target.result;
          this.product.image = file;
        };
        reader.readAsDataURL(file);
      }
    },
    addFeature() {
      this.product.features.push('');
    },
    removeFeature(index) {
      this.product.features.splice(index, 1);
    },
    async addProduct() {
      // Validate name, image, and categories
      if (!this.product.name.trim()) {
        this.errors.name = 'Product name is required.';
        return;
      }
      if (!this.product.image) {
        this.errors.image = 'Product image is required.';
        return;
      }
      if (this.product.categories.length === 0) {
        this.errors.categories = 'Please select at least one category.';
        return;
      }

      const productData = {
        name: this.product.name,
        image: this.product.image,
        categories: this.product.categories,
        features: this.product.features,
      };

      try {
        const response = await axios.post('/api/products', productData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        if (response.data) {
          this.$router.push('/products'); // Navigate to product list page after success
        }
      } catch (error) {
        console.error('Error adding product:', error);
        alert('Failed to add product. Please try again later.');
      }
    },
  },
};
</script>

<style scoped>
/* Add any specific styles if needed */
</style>
