/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./view/**/*.php', "./node_modules/flowbite/**/*.js",'./view/play.php'],
    theme: {
        extend: {
            colors: {
                'customBlue': '#ABD3E6',
                'customBlueDark': '#2C5788',
            },
            fontFamily: {
                'sans': ['ui-sans-serif', 'Lilita One'],
            }
        },
    },
    variants: {},
    plugins: [
        require('flowbite/plugin')
    ],
}
