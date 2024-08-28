'use client'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { API_ROUTES } from '@/components/apiRoutes'
import SearchForm from '@/components/forms/SearchForm'

export default function Page({ params }) {
    return (
        <SearchForm header="Список продуктов" itemName="name" apiRoute={API_ROUTES.GET_PRODUCTS} categoriesRoute={API_ROUTES.GET_PRODUCTS_CATEGORIES}/>
    );
}
