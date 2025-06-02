<template>

    <Head title="API Keys" />

  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mes clés API
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-4 flex justify-between items-center">
              <h3 class="text-lg font-semibold">Liste de vos clés API</h3>
              <Link
                :href="route('api-keys.create')"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
              >
                Créer une nouvelle clé
              </Link>
            </div>

            <div v-if="$page.props.flash?.success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
              {{ $page.props.flash.success }}
            </div>

            <table class="min-w-full bg-white">
              <thead>
                <tr>
                  <th class="py-2 px-4 border-b">Nom</th>
                  <th class="py-2 px-4 border-b">Clé</th>
                  <th class="py-2 px-4 border-b">Créée le</th>
                  <th class="py-2 px-4 border-b">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="apiKey in apiKeys" :key="apiKey.id">
                  <td class="py-2 px-4 border-b">{{ apiKey.name }}</td>
                  <td class="py-2 px-4 border-b">{{ apiKey.key }}</td>
                  <td class="py-2 px-4 border-b">{{ formatDate(apiKey.created_at) }}</td>
                  <td class="py-2 px-4 border-b">
                    <Link
                      :href="route('api-keys.destroy', apiKey.id)"
                      method="delete"
                      as="button"
                      type="button"
                      class="text-red-500 hover:text-red-700"
                      @click="confirmDeletion"
                    >
                      Supprimer
                    </Link>
                  </td>
                </tr>
                <tr v-if="apiKeys.length === 0">
                  <td colspan="4" class="py-4 px-4 text-center">Aucune clé API trouvée.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
  components: {
    AppLayout,
      Head,
    Link,
  },
  props: {
    apiKeys: Array,
  },
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
    },
    confirmDeletion(e) {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cette clé?')) {
        e.preventDefault();
      }
    }
  }
};
</script>
