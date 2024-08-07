import Dropdown from '@/components/Dropdown'
import ResponsiveNavLink, {
    ResponsiveNavButton,
} from '@/components/ResponsiveNavLink'
import { DropdownButton } from '@/components/DropdownLink'
import { useAuth } from '@/hooks/auth'
import { usePathname } from 'next/navigation'
import { useState } from 'react'
import './Navigation.css'
import Sidebar from '@/components/Sidebar'
import Dropdown2 from '@/components/Dropdowns/Dropdown'
const Navigation = ({ user }) => {
    const { logout } = useAuth()

    const [open, setOpen] = useState(false)

    return (
        <nav className="w-100 d-flex align-items-center">
            {/* Primary Navigation Menu */}
            <div className="layout-background w-100 d-flex align-items-center">
                <div className="logo">
                    <button className="icon-button logo-img"></button>
                </div>

                <div className="d-flex justify-content-between align-items-center w-100">
                    <div className="d-flex">
                        <Sidebar style={{ backgroundImage: 'url(\'/images/menu.svg\')' }}></Sidebar>
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

                    {/* Settings Dropdown */}
                    <div className="d-none d-sm-flex sm:items-center sm:ml-6">
                        <button
                            className="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                            <div>{user?.name}</div>
                            <div className="ml-1">
                                <svg className="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fillRule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clipRule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <Dropdown align="right" width="48"
                                  trigger={<button className="dropdown-toggle" data-bs-toggle="dropdown"
                                                   aria-expanded="false" />}>
                            <DropdownButton onClick={logout}>
                                Logout
                            </DropdownButton>
                        </Dropdown>
                    </div>

                    {/* Hamburger */}
                    <div className="-mr-2 d-flex items-center d-sm-none">
                        <button onClick={() => setOpen(open => !open)} className="navbar-toggler" type="button">
                            <span className="navbar-toggler-icon" />
                        </button>
                    </div>
                </div>
            </div>

            {/* Responsive Navigation Menu */}
            {open && (
                <div className="container-fluid d-block d-sm-none">
                    <div className="pt-2 pb-3">
                        <ResponsiveNavLink href="/dashboard" active={usePathname() === '/dashboard'}>
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    {/* Responsive Settings Options */}
                    <div className="pt-4 pb-1 border-top border-gray-200">
                        <div className="d-flex items-center px-4">
                            <svg className="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div className="ml-3">
                                <div className="font-medium text-base text-gray-800">
                                    {user?.name}
                                </div>
                                <div className="font-medium text-sm text-gray-500">
                                    {user?.email}
                                </div>
                            </div>
                        </div>

                        <div className="mt-3">
                            <ResponsiveNavButton onClick={logout}>
                                Logout
                            </ResponsiveNavButton>
                        </div>
                    </div>
                </div>
            )}
        </nav>
    )
}

export default Navigation
