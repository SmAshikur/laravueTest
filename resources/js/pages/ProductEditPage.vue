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
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Product</h3>
      <form @submit.prevent="updateProduct" class="space-y-6">
        <!-- Product Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
          <input
            id="name"
            v-model="product.name"
            type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            required
          />
          <p v-if="errors.name" class="text-sm text-red-500 mt-1">{{ errors.name }}</p>
        </div>

        <!-- Product Image -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
          <input
            id="image"
            ref="imageInput"
            type="file"
            @change="onImageChange"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            accept="image/*"
          />
          <p v-if="errors.image" class="text-sm text-red-500 mt-1">{{ errors.image }}</p>
          <div v-if="product.imagePreview || product.existingImage" class="mt-4">
            <img
              :src="product.imagePreview || product.existingImage"
              alt="Product Preview"
              class="w-32 h-32 object-cover rounded-md"
            />
          </div>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md shadow-sm"
        >
          Update Product
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["id"],  // The product id will be passed via route params
  data() {
    return {
      product: {
        name: "",
        image: null,
        imagePreview: null,
        existingImage: null,
      },
      errors: {
        name: "",
        image: "",
      },
    };
  },
  mounted() {
    this.fetchProduct();  // Fetch product data when component is mounted
  },
  methods: {
    // Fetch product data from the server
    async fetchProduct() {
      try {
        const response = await axios.get(`/api/products/${this.id}`);
        const product = response.data;

        // Set the form fields with fetched data
        this.product.name = product.name || "";
        this.product.existingImage = product.image || null; // If no image, use null
      } catch (error) {
        console.error("Error fetching product:", error);
        alert("Failed to load product details.");
      }
    },

    // Handle image change and preview
    onImageChange(event) {
      const file = event.target.files[0];
      if (!file) return;

      if (!file.type.startsWith("image/")) {
        this.errors.image = "Invalid file type. Please upload an image.";
        return;
      }

      this.errors.image = "";  // Clear error if valid image
      const reader = new FileReader();
      reader.onload = (e) => {
        this.product.imagePreview = e.target.result;
        this.product.image = file;
      };
      reader.readAsDataURL(file);
    },

    // Update product data with FormData
    async updateProduct() {
      // Basic validation
      if (!this.product.name.trim()) {
        this.errors.name = "Product name is required.";
        return;
      }

      const formData = new FormData();
      formData.append("name", this.product.name);  // Append the product name

      // Only append the image if it's new
      if (this.product.image) {
        formData.append("image", this.product.image);
      }

      try {
        // Log the FormData to see its content before sending
        formData.forEach((value, key) => {
          console.log(`${key}: ${value}`);
        });

        // Send the PUT request with FormData
       const response = await axios.put(`/api/products/${this.id}`, formData, {
        headers: {
            "Content-Type": "multipart/form-data",  // Only specify Content-Type here, not the method
        },
        });


        if (response.data) {
          alert("Product updated successfully!");
          console.log(response.data); // Log the response data

          // Optionally navigate after success
          // this.$router.push("/products");  // Uncomment if you're using Vue Router
        }
      } catch (error) {
        console.error("Error updating product:", error);
        alert("Failed to update product. Please try again later.");
      }
    }
  },
};
</script>

<style scoped>
/* Custom styles for the component */
</style>
