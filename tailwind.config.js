/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./view/**/*.php', "./node_modules/flowbite/**/*.js",'./view/play.php'],
    theme: {
        extend: {
            colors: {
                'customBlue': '#00D5FF',
                'customBlueDark': '#001a3a',
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
