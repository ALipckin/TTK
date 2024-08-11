
    import Link from 'next/link'
import { Menu } from '@headlessui/react'
import React from 'react'

const DropdownLink = ({ children, ...props }) => (
    <Menu.Item>
        {({ active }) => (
            <Link
                {...props}
                className={`${active ? 'bg-gray-100' : ''} col-12 text-left px-4 py-2 text-sm leading-5 text-gray-700`}
            >
                {children}
            </Link>
        )}
    </Menu.Item>
)

export const DropdownButton = ({ children, ...props }) => (
    <Menu.Item>
        {({ active }) => (
            <button
                className={`${active ? 'bg-gray-100' : ''} col-12 text-left px-4 py-2 text-sm leading-5 text-gray-700`}
                {...props}>
                {children}
                <img />
            </button>
        )}
    </Menu.Item>
)

export default DropdownLink
