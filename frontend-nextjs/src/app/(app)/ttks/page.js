"use client"
import { API_ROUTES } from "@/components/apiRoutes"
import React, { useEffect, useState } from 'react'
import SearchForm from '@/components/forms/SearchForm'

const Page = () => {
    return (
    <SearchForm header="Опубликованные работы" itemName="name" apiRoute={API_ROUTES.TTKS} categoriesRoute={API_ROUTES.TTKS_CATEGORIES}/>
    );
};

export default Page;
