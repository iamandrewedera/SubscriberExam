<script>
import axios from 'axios';
import { handleApiError } from '../helper';

export default {
  name: 'SubscriberForm',
  data() {
    return {
      form: {
        email: '',
      },
      isSubmitting: false,
      message: '',
      subscribed: '',
    };
  },
  mounted() {
    if (localStorage.getItem('subscribed')) {
      try {
        this.subscribed = localStorage.getItem('subscribed');
        this.form.email = this.subscribed;
      } catch (e) {
        localStorage.removeItem('subscribed');
      }
    }
  },
  methods: {
    async submitForm() {
      if (this.form.email && !this.subscribed) {
        this.isSubmitting = true;
        this.message = '';

        try {
          const response = await axios.post(`${import.meta.env.VITE_BACKEND_URL}/api/subscriber`, this.form);
          this.message = response.data.message;
          localStorage.setItem('subscribed', this.form.email);
          this.subscribed = this.form.email
        } catch (error) {
          this.message = handleApiError(error);
        } finally {
          this.isSubmitting = false;
        }
      }
    },
    async unsubscribe() {
      if (this.form.email) {
        this.isSubmitting = true;
        this.message = '';

        try {
          const response = await axios.patch(`${import.meta.env.VITE_BACKEND_URL}/api/subscriber/unsubscribe`, this.form);
          this.message = response.data.message;
          this.resetForm();
        } catch (error) {
          this.message = handleApiError(error);
        } finally {
          this.isSubmitting = false;
        }
      }
    },
    resetForm() {
      this.subscribed = '';
      localStorage.removeItem('subscribed');
      this.form = {
        email: '',
      };
    }
  }
}
</script>

<template>
  <div>
    <h1>Subscription</h1>

    <div v-if="message" class="message">{{ message }}</div>
    <div v-if="subscribed" style="opacity: 0.5;font-style: italic;margin-bottom: 1rem;">{{ subscribed }}</div>

    <form class="card" @submit.prevent="submitForm" v-if="!subscribed">
      <input type="email" name="email" id="email" v-model="form.email" placeholder="test@email.com">
      <button type="button" @click.prevent="submitForm" :disabled="isSubmitting">{{ isSubmitting ? 'Processing...' : 'Subscribe' }}</button>
    </form>
    <button v-else type="button" @click.prevent="unsubscribe">{{ isSubmitting ? 'Processing...' : 'Unsubscribe' }}</button>
    <!-- <a href="#" @click.prevent="unsubscribe" style="color:red" :disabled="!subscribed">Unsubscribe</a> -->
  </div>
</template>

<style scoped>
.read-the-docs {
  color: #888;
}

.message {
  margin: 1rem 0;
  padding: 0.5rem;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.2);
  border-radius: 4px;
}

input[type="email"] {
  margin-right: 1rem;
  border-radius: 8px;
  border: 1px solid transparent;
  padding: 0.6em 1.2em;
  font-size: 1em;
  font-weight: 500;
  font-family: inherit;
  background-color: #1a1a1a;
  color: #fff;
  cursor: pointer;
  transition: border-color 0.25s;
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
