const path = require('path');

module.exports = {
    entry: '/assets/import.js', // Chemin de votre fichier principal
    output: {
        filename: 'bundle.js', // Nom du fichier de sortie
        path: path.resolve(__dirname, 'dist'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
};
