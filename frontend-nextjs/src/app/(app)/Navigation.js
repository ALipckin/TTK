import ResponsiveNavLink, {
    ResponsiveNavButton,
} from '@/components/ResponsiveNavLink'
import { useAuth } from '@/hooks/auth'
import { usePathname } from 'next/navigation'
import { useState } from 'react'
import './Navigation.css'
import Sidebar from '@/components/Sidebar'
import React from "react"
import DropDown from '@/components/dropdowns/dropdown'

const Navigation = ({ user }) => {
    const { logout } = useAuth()

    const [open, setOpen] = useState(false)

    return (
        <nav className="w-100 d-flex align-items-center">
            {/* Primary Navigation Menu */}
            <div className="layout-background w-100 d-flex align-items-center">
                <div className="logo">
                    <button className="icon-button logo-img" />
                </div>

                <div className="d-flex justify-content-between align-items-center w-100" style={{ marginRight: '20px'}}>
                    <div className="d-flex">
                        <Sidebar style={{ backgroundImage: 'url(\'/images/menu.svg\')' }} />
                        {/*<button className="icon-button"*/}
                        {/*        style={{ backgroundImage: 'url(\'/images/back-arrow.svg\')' }} />*/}
                        {/*<button className="icon-button"*/}
                        {/*        style={{ backgroundImage: 'url(\'/images/save.svg\')' }} />*/}
                    </div>
                    <div className="d-flex align-items-center">
                        {/*<button className="icon-button"
                        //         style={{ backgroundImage: 'url(\'/images/edit.svg\')' }} />
                        // <button className="icon-button"
                        //         style={{ backgroundImage: 'url(\'/images/document.svg\')' }} />
                        // <button className="icon-button"
                        //         style={{ backgroundImage: 'url(\'/images/help.svg\')' }} />*/}

                    </div>
                    <DropDown/>
                </div>
            </div>
        </nav>
    )
}

export default Navigation
