module.exports = {
    content: [
      "./assets/**/*.js",
      "./templates/**/*.html.twig",
      "./node_modules/flowbite/**/*.js"
    ],
    darkMode: 'class',
    // purge: [],
    theme: {
      extend: {},
    },
    variants: {
      extend: {},
    },
    plugins: [
      require('flowbite/plugin')
    ],
  }

