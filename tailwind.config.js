/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

export default {
  content: [
    './resources/js/**/*.{js,ts,jsx,tsx}',  // Memindai file React dan TypeScript
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: '#0fa683',
        secondary: '#380FA6',
        tertiary: '#A60F32',
        quaternary: '#7EA60F',
        base: '#ffffff',
        'base-2': '#808080',
        'light-background': '#ffffff', 
        'dark-background': '#1a202c',
        'light-text': '#333333',       
        'dark-text': '#f7fafc',
      },
      screens: {
        xsm: '480px',
      },
    },
  },
  plugins: [require('daisyui')],
  daisyui: {
    themes: ["light", "dark", "cupcake","night","cyberpunk","synthwave"],
  },
};
