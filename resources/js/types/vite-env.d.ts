/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_APP_NAME: string
  readonly VITE_APP_URL: string
  
  readonly VITE_DISABLE_VIEW_CRUD_COMPONENT: string
}


interface ImportMeta {
  readonly env: ImportMetaEnv
}