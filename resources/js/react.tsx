import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
        // console.log(pages); // Log untuk memastikan bahwa komponen ditemukan
        return pages[`./Pages/${name}.tsx`];

    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />)
    },
})