/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#f0f7ff',
          100: '#e0effe',
          200: '#b9dffd',
          300: '#7cc4fc',
          400: '#36a5f8',
          500: '#0c87e8',
          600: '#0069c4',
          700: '#0154a0',
          800: '#064884',
          900: '#0b3d6e',
          950: '#072849',
        },
        navy: {
          800: '#0f2744',
          900: '#0a1f38',
          950: '#061528',
        },
        accent: {
          400: '#22d3ee',
          500: '#06b6d4',
          600: '#0891b2',
        },
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
        display: ['"DM Sans"', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 2px 15px -3px rgba(6, 37, 72, 0.08), 0 4px 6px -4px rgba(6, 37, 72, 0.06)',
        card: '0 4px 24px -4px rgba(6, 37, 72, 0.12)',
        elevated: '0 12px 40px -12px rgba(6, 37, 72, 0.18)',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-out forwards',
        'slide-up': 'slideUp 0.5s ease-out forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
};
