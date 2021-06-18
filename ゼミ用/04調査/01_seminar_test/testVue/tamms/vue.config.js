module.exports = {
  publicPath: './',
  devServer: {
    port: 9000,
    proxy: {
      '/api/': {
        target: 'http://localhost:9000',
      },
    },
  },
};
