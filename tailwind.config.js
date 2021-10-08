const {blueGray, sky, orange, black, white, blue, teal } = require('tailwindcss/colors');

module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      black: black,
      white: white,
      bluegray: blueGray,
      orange: orange,
      teal: teal,
      sky: sky,
      blue: blue
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
