/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.html',  // HTML files in the public folder
    './src/**/*.php',      // PHP files in the src folder
    './public/assets/js/**/*.js', // JavaScript files
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ['"Poppins"', 'sans-serif']
      }
    },
  },
  plugins: [],
}