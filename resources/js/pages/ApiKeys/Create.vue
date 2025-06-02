<template>

    <Head title="Create API" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Créer une nouvelle clé API
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submit">
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la clé</label>
                <input
                  type="text"
                  v-model="form.name"
                  id="name"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                  required
                />
                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                  {{ form.errors.name }}
                </div>
              </div>

              <div class="flex items-center justify-between mt-6">
                <Link
                  :href="route('api-keys.index')"
                  class="text-gray-500 hover:text-gray-700"
                >
                  Annuler
                </Link>
                <button
                  type="submit"
                  class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                  :disabled="form.processing"
                >
                  Créer la clé API
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
  components: {
    AppLayout,
      Head,
    Link,
  },
  setup() {
    const form = useForm({
      name: '',
    });

    return { form };
  },
  methods: {
    submit() {
      this.form.post(route('api-keys.store'));
    },
  },
};
</script>
