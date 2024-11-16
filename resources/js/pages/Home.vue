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
  <div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="flex space-x-12">
      <router-link to="/categories">
        <div class="p-8 bg-white shadow-lg rounded-lg text-center hover:bg-blue-100 cursor-pointer">
          <h2 class="text-2xl font-semibold">Categories</h2>
          <p class="mt-4">Explore all product categories.</p>
        </div>
      </router-link>

      <router-link to="/products">
        <div class="p-8 bg-white shadow-lg rounded-lg text-center hover:bg-green-100 cursor-pointer">
          <h2 class="text-2xl font-semibold">Products</h2>
          <p class="mt-4">Browse all our available products.</p>
        </div>
      </router-link>
    </div>
  </div>
</template>
