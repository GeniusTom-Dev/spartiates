/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./view/**/*.php', "./node_modules/flowbite/**/*.js",'./view/play.php'],
    theme: {
        extend: {
            colors: {
                'customBlue': '#ABD3E6',
                'customBlueDark': '#2C5788',
                'customYellow': '#FFC107',
                'customRed': '#DC3545',
                'customGreen': '#28A745',
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
