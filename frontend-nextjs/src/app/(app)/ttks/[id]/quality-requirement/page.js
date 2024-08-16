'use client';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_ROUTES } from '@/components/apiRoutes';
import InputBox from '@/components/Inputs/TtkInputBox';
import WideButton from '@/components/buttons/WideButton';
import '../data.css';
import TrashForm from '@/components/buttons/TrashForm';
import ActionIconButton from '@/components/buttons/ActionIconButton'
import "../ttk.css"
import DescriptionForm from '@/components/forms/DescriptionForm'

export default function Page({ params }) {

    return (
       <DescriptionForm header="Требования к качеству сырья" apiTable="quality-requirements" params={params}/>
    );
}
