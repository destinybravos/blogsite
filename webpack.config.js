const path = require('path');

module.exports = {
  entry: './src/scripts.js',
  output: {
    filename: 'app.js',
    path: path.resolve(__dirname, 'public/js'),
  },
};