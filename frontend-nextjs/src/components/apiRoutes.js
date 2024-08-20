// src/apiRoutes.js

import Axios from 'axios'

const DOMAIN = process.env.NEXT_PUBLIC_BACKEND_URL;
const API_BASE_URL = `${DOMAIN}/api`;
export const API_ROUTES = {
    DOMAIN_NAME: `${DOMAIN}`,
    GET_CSRF_COOKIE: `${DOMAIN}/sanctum/csrf-cookie`,
    GET_PROFILE: `${API_BASE_URL}/profile`,
    GET_PRODUCTS: `${API_BASE_URL}/products`,
    POST_REGISTRATION: `${API_BASE_URL}/register`,
    POST_LOGIN: `${API_BASE_URL}/login`,
    GET_MY_ALL_TTKS: `${API_BASE_URL}/ttks/my`,
    TTKS: `${API_BASE_URL}/ttks`,
    TTKS_PUBLIC: `${API_BASE_URL}/ttks/public`,
    // Добавьте другие пути API по мере необходимости
};
