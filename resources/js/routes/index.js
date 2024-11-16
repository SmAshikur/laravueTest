
import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(),  // Use createWebHistory() here
  routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('@/pages/Home.vue'),  // Default route to products
        },
        {
            path: '/categories',
            name: 'categories',
            component: () => import('@/pages/categoryList.vue'),  // Route for category list
        },
        {
            path: '/categories/create',
            name: 'categories_create',
            component: () => import('@/pages/category.vue'),  // Route for category list
        },

        {
            path: '/products',
            name: 'products',
            component: () => import('@/pages/productList.vue'),  // Route for product list
        },

        {
            path: '/products/create',
            name: 'products_create',
            component: () => import('@/pages/product.vue'),  // Route for product list
        },
        {
            path: '/products/edit/:id',
            name: 'ProductEdit',
            component: () => import('@/pages/ProductEditPage.vue'),  // Dynamically import ProductEditPage
            props: true,  // Pass the route parameters (id) as props to the component
          },
          {
            path: '/products/show/:id',
            name: 'ProductShow',
            component: () => import('@/pages/ProductShowPage.vue'),  // Dynamically import ProductShowPage
            props: true,  // Pass the route parameters (id) as props to the component
          },

    ],
});


export default router;
