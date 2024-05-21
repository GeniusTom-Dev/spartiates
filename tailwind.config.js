/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./view/**/*.php', "./node_modules/flowbite/**/*.js"],
    theme: {
        extend: {
            colors: {
                'customBlue': '#00D5FF',
                'customBlueDark': '#001a3a',
            },
        },
    },
    variants: {},
    plugins: [
        require('flowbite/plugin')
    ],
}
