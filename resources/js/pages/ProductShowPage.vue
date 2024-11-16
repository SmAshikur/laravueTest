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
  <div class="bg-gray-50 p-8">

    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Product Details</h2>
        <router-link
          to="/products/create"
          class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
        >
          Add Product
        </router-link>
      </div>
    <div v-if="product" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
      <div class="flex items-center space-x-6 mb-6">
        <!-- Product Image -->
        <div class="w-48 h-48 overflow-hidden rounded-lg shadow-lg">
          <img :src="product.image" alt="Product Image" class="object-cover w-full h-full" />
        </div>

        <!-- Product Info -->
        <div class="flex flex-col space-y-4">
          <h3 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h3>

          <div class="space-y-2 text-gray-600">
            <p class="font-medium">Categories:</p>
            <div class="flex flex-wrap space-x-2">
              <span
                v-for="(category, index) in product.categories"
                :key="index"
                class="bg-blue-200 text-blue-800 px-4 py-2 rounded-full text-sm"
              >
                {{ category.name }}
              </span>
            </div>
          </div>

          <div class="space-y-2 text-gray-600">
            <p class="font-medium">Features:</p>
            <div class="flex flex-wrap space-x-2">
              <span
                v-for="(features, index) in product.feature"
                :key="index"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm"
              >
                {{ features.description }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Details -->
      <div class="border-t pt-4 text-gray-600">
        <p><strong>Price:</strong> ${{ product.price }}</p>
        <p><strong>Stock:</strong> {{ product.stock }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      product: null,
    };
  },
  mounted() {
    this.fetchProduct();
  },
  methods: {
    async fetchProduct() {
      try {
        const response = await axios.get(`/api/products/${this.$route.params.id}`);
        this.product = response.data;
      } catch (error) {
        console.error('Error fetching product:', error);
        alert('Failed to load product details.');
      }
    },
  },
};
</script>

<style scoped>
/* You can add custom styling here */
</style>
