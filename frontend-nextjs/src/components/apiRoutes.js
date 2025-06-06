// src/apiRoutes.js

import Axios from 'axios'

const DOMAIN = process.env.NEXT_PUBLIC_BACKEND_URL;
const API_BASE_URL = `${DOMAIN}/api`;
export const API_ROUTES = {
    DOMAIN_NAME: `${DOMAIN}`,
    GET_CSRF_COOKIE: `${DOMAIN}/sanctum/csrf-cookie`,
    GET_MY_PROFILE: `${API_BASE_URL}/profile/my`,
    GET_PROFILE:(id) => `${API_BASE_URL}/profile/${id}`,
    UPLOAD_PROFILE_PICTURE: `${API_BASE_URL}/profile/upload-avatar`,
    GET_PRODUCTS: `${API_BASE_URL}/products`,
    GET_PRODUCTS_CATEGORIES: `${API_BASE_URL}/products/all_categories`,
    GET_TREATMENTS: (id) => `${API_BASE_URL}/products/${id}/treatments`,
    GET_NE_VALUE: (ttk) => `${API_BASE_URL}/ttks/${ttk}/ne_value`,
    ORG_CHARACTERISTICS: (ttk) => `${API_BASE_URL}/ttks/${ttk}/org_characteristics`,
    PHYS_CHEM_PARAMS: (ttk) => `${API_BASE_URL}/ttks/${ttk}/phys_chem_params`,
    MICROBIO_PARAMS: (ttk) => `${API_BASE_URL}/ttks/${ttk}/microbio_params`,
    PUT_FORMULATION: (ttk, formulation) => `${API_BASE_URL}/ttks/${ttk}/formulations/${formulation}`,
    DELETE_FORMULATION: (ttk, formulation) => `${API_BASE_URL}/ttks/${ttk}/formulations/${formulation}`,
    GET_PACKAGES: `${API_BASE_URL}/packages`,
    GET_MY_PRODUCTS: `${API_BASE_URL}/products/my`,
    POST_REGISTRATION: `${API_BASE_URL}/register`,
    POST_LOGIN: `${API_BASE_URL}/login`,
    GET_MY_ALL_TTKS: `${API_BASE_URL}/ttks/my`,
    TTKS: `${API_BASE_URL}/ttks`,
    TTKS_CATEGORIES: `${API_BASE_URL}/ttks/all_categories`,
    TTKS_PUBLIC: `${API_BASE_URL}/ttks/public`,
    DOWNLOAD_TTK_PDF: (ttk) =>  `${API_BASE_URL}/ttks/${ttk}/download_pdf`,
    // Добавьте другие пути API по мере необходимости
};
