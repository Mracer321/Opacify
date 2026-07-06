/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#0F172A',
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0F172A',
          950: '#0F172A',
        },
        brand: {
          50: '#f3f5fe',
          100: '#e7eafd',
          200: '#c9d0fa',
          300: '#a6b1f6',
          400: '#8492f2',
          500: '#6377EE',
          600: '#4557d8',
          700: '#3a47b8',
          800: '#323d93',
          900: '#2e3874',
          950: '#1c2044',
        },
        accent: {
          300: '#a6b1f6',
          400: '#8492f2',
          500: '#6377EE',
          600: '#4557d8',
        },
        surface: '#F8FAFC',
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
        display: ['"DM Sans"', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 2px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.06)',
        card: '0 4px 24px -4px rgba(15, 23, 42, 0.1)',
        elevated: '0 12px 40px -12px rgba(15, 23, 42, 0.16)',
        'card-hover': '0 8px 30px -8px rgba(99, 119, 238, 0.15), 0 4px 24px -4px rgba(15, 23, 42, 0.1)',
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
