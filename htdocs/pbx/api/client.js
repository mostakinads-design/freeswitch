// FreeSWITCH PBX API Handler
// This file provides API endpoints for the PBX system

const API_BASE_URL = '/api';
const XMLRPC_URL = '/api/xmlrpc';

// API Client class
class PBXApiClient {
    constructor(baseUrl = API_BASE_URL) {
        this.baseUrl = baseUrl;
        this.token = this.getAuthToken();
    }

    // Get authentication token from storage
    getAuthToken() {
        return localStorage.getItem('pbx_auth_token') || '';
    }

    // Set authentication token
    setAuthToken(token) {
        localStorage.setItem('pbx_auth_token', token);
        this.token = token;
    }

    // Generic API request method
    async request(endpoint, options = {}) {
        const url = `${this.baseUrl}${endpoint}`;
        const headers = {
            'Content-Type': 'application/json',
            ...options.headers
        };

        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }

        try {
            const response = await fetch(url, {
                ...options,
                headers
            });

            if (!response.ok) {
                throw new Error(`API Error: ${response.status} ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('API Request Error:', error);
            throw error;
        }
    }

    // GET request
    async get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    }

    // POST request
    async post(endpoint, data) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    // PUT request
    async put(endpoint, data) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    // DELETE request
    async delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    }

    // Authentication
    async login(username, password) {
        const response = await this.post('/auth/login', { username, password });
        if (response.token) {
            this.setAuthToken(response.token);
        }
        return response;
    }

    async logout() {
        await this.post('/auth/logout');
        localStorage.removeItem('pbx_auth_token');
        this.token = null;
    }

    // Dashboard APIs
    async getDashboardStats() {
        return this.get('/dashboard/stats');
    }

    // User Management APIs
    async getUsers() {
        return this.get('/users');
    }

    async getUser(userId) {
        return this.get(`/users/${userId}`);
    }

    async createUser(userData) {
        return this.post('/users', userData);
    }

    async updateUser(userId, userData) {
        return this.put(`/users/${userId}`, userData);
    }

    async deleteUser(userId) {
        return this.delete(`/users/${userId}`);
    }

    // Extension Management APIs
    async getExtensions() {
        return this.get('/extensions');
    }

    async getExtension(extensionId) {
        return this.get(`/extensions/${extensionId}`);
    }

    async createExtension(extensionData) {
        return this.post('/extensions', extensionData);
    }

    async updateExtension(extensionId, extensionData) {
        return this.put(`/extensions/${extensionId}`, extensionData);
    }

    async deleteExtension(extensionId) {
        return this.delete(`/extensions/${extensionId}`);
    }

    // Gateway Management APIs
    async getGateways() {
        return this.get('/gateways');
    }

    async getGateway(gatewayId) {
        return this.get(`/gateways/${gatewayId}`);
    }

    async createGateway(gatewayData) {
        return this.post('/gateways', gatewayData);
    }

    async updateGateway(gatewayId, gatewayData) {
        return this.put(`/gateways/${gatewayId}`, gatewayData);
    }

    async deleteGateway(gatewayId) {
        return this.delete(`/gateways/${gatewayId}`);
    }

    // Call Management APIs
    async getActiveCalls() {
        return this.get('/calls/active');
    }

    async getCall(callId) {
        return this.get(`/calls/${callId}`);
    }

    async hangupCall(callId) {
        return this.post(`/calls/${callId}/hangup`);
    }

    async transferCall(callId, destination) {
        return this.post(`/calls/${callId}/transfer`, { destination });
    }

    // CDR APIs
    async getCDRRecords(filters = {}) {
        const queryString = new URLSearchParams(filters).toString();
        return this.get(`/cdr${queryString ? '?' + queryString : ''}`);
    }

    // Queue Management APIs
    async getQueues() {
        return this.get('/queues');
    }

    async getQueue(queueId) {
        return this.get(`/queues/${queueId}`);
    }

    async getQueueStats(queueId) {
        return this.get(`/queues/${queueId}/stats`);
    }

    // Conference APIs
    async getConferences() {
        return this.get('/conferences');
    }

    async getConference(conferenceId) {
        return this.get(`/conferences/${conferenceId}`);
    }

    async createConference(conferenceData) {
        return this.post('/conferences', conferenceData);
    }

    // Recording APIs
    async getRecordings(type = 'call') {
        return this.get(`/recordings?type=${type}`);
    }

    async getRecording(recordingId) {
        return this.get(`/recordings/${recordingId}`);
    }

    async downloadRecording(recordingId) {
        const url = `${this.baseUrl}/recordings/${recordingId}/download`;
        window.open(url, '_blank');
    }

    async deleteRecording(recordingId) {
        return this.delete(`/recordings/${recordingId}`);
    }

    // System APIs
    async getSystemHealth() {
        return this.get('/system/health');
    }

    async getSystemLogs(limit = 100) {
        return this.get(`/system/logs?limit=${limit}`);
    }

    async createBackup() {
        return this.post('/system/backup');
    }

    async getBackups() {
        return this.get('/system/backups');
    }

    async restoreBackup(backupId) {
        return this.post(`/system/backups/${backupId}/restore`);
    }

    // FreeSWITCH Command Execution
    async executeCommand(command) {
        return this.post('/freeswitch/command', { command });
    }

    // WebSocket for real-time updates
    connectWebSocket(onMessage, onError) {
        const wsProtocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
        const wsUrl = `${wsProtocol}//${window.location.host}/ws`;
        
        const ws = new WebSocket(wsUrl);
        
        ws.onopen = () => {
            console.log('WebSocket connected');
        };
        
        ws.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                onMessage(data);
            } catch (error) {
                console.error('WebSocket message parse error:', error);
            }
        };
        
        ws.onerror = (error) => {
            console.error('WebSocket error:', error);
            if (onError) onError(error);
        };
        
        ws.onclose = () => {
            console.log('WebSocket disconnected');
            // Attempt to reconnect after 5 seconds
            setTimeout(() => {
                this.connectWebSocket(onMessage, onError);
            }, 5000);
        };
        
        return ws;
    }
}

// Export API client
const pbxApi = new PBXApiClient();

// Make it available globally
if (typeof window !== 'undefined') {
    window.pbxApi = pbxApi;
    window.PBXApiClient = PBXApiClient;
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { PBXApiClient, pbxApi };
}
