'use client'
import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { API_ROUTES } from '@/components/apiRoutes'
import SearchForm from '@/components/forms/SearchForm'

export default function Page({ params }) {
    return (
        <SearchForm header="Мои продукты" itemName="name" itemRoute={"/products/"} apiRoute={API_ROUTES.GET_MY_PRODUCTS}/>
    );
}
