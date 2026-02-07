<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-2xl font-bold text-indigo-600">VoIP Panel</h1>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link
                to="/dashboard"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Dashboard
              </router-link>
              <router-link
                v-if="isAdmin"
                to="/extensions"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Extensions
              </router-link>
              <router-link
                v-if="isAdmin"
                to="/dids"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                DIDs
              </router-link>
              <router-link
                to="/cdr"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                CDR
              </router-link>
              <router-link
                to="/campaigns"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Campaigns
              </router-link>
              <router-link
                v-if="isAgent"
                to="/agent"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Agent
              </router-link>
            </div>
          </div>
          <div class="flex items-center">
            <span class="text-sm text-gray-700 mr-4">{{ userName }}</span>
            <button @click="logout" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Stats Overview -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Active Calls</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">{{ stats.activeCalls }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Online Agents</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">{{ stats.onlineAgents }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Calls Today</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">{{ stats.callsToday }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Revenue Today</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">${{ stats.revenueToday }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Live Calls -->
      <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Live Calls</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To</th>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="call in liveCalls" :key="call.uuid">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ call.from }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ call.to }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ call.duration }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      {{ call.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button @click="hangupCall(call.uuid)" class="text-red-600 hover:text-red-900">Hangup</button>
                  </td>
                </tr>
                <tr v-if="liveCalls.length === 0">
                  <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No active calls</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';

export default {
  name: 'Dashboard',
  setup() {
    const stats = ref({
      activeCalls: 0,
      onlineAgents: 0,
      callsToday: 0,
      revenueToday: 0,
    });

    const liveCalls = ref([]);
    const userName = ref('Admin User');
    const userRole = ref('admin');
    let refreshInterval = null;

    const isAdmin = computed(() => userRole.value === 'admin');
    const isAgent = computed(() => userRole.value === 'agent');

    const fetchStats = async () => {
      try {
        const response = await axios.get('/api/dashboard/stats');
        stats.value = response.data;
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    const fetchLiveCalls = async () => {
      try {
        const response = await axios.get('/api/calls/live');
        liveCalls.value = response.data;
      } catch (error) {
        console.error('Error fetching live calls:', error);
      }
    };

    const hangupCall = async (uuid) => {
      try {
        await axios.post(`/api/calls/${uuid}/hangup`);
        await fetchLiveCalls();
      } catch (error) {
        console.error('Error hanging up call:', error);
      }
    };

    const logout = () => {
      localStorage.removeItem('token');
      window.location.href = '/login';
    };

    onMounted(() => {
      fetchStats();
      fetchLiveCalls();
      
      // Refresh every 2 seconds
      refreshInterval = setInterval(() => {
        fetchStats();
        fetchLiveCalls();
      }, 2000);
    });

    onUnmounted(() => {
      if (refreshInterval) {
        clearInterval(refreshInterval);
      }
    });

    return {
      stats,
      liveCalls,
      userName,
      isAdmin,
      isAgent,
      hangupCall,
      logout,
    };
  },
};
</script>
