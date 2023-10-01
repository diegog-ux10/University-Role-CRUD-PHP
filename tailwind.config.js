/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        "inter": ["'Inter', 'sans-serif'"]
      }
    },
  },
  plugins: [],
  darkMode: "class"
}