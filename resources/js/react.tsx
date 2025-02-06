import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true })
    console.log('props')
    return pages[`./Pages/${name}.jsx`]
  },
  setup({ el, App, props }) {
      createRoot(el).render(<App {...props} />)
  },
})