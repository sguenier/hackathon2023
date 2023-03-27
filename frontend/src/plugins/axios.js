import axios from 'axios'

const axiosConfig = {
  baseURL: import.meta.env.VITE_API,
};

if (import.meta.env.VITE_API_TIMEOUT && parseInt(import.meta.env.VITE_API_TIMEOUT, 10)) {
  axiosConfig.timeout = parseInt(import.meta.env.VITE_API_TIMEOUT, 10);
}

// Set api url
const apiCall = axios.create(axiosConfig);

apiCall.defaults.headers.post['Content-Type'] = 'application/json';

export default apiCall;
