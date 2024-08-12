module.exports = {
  plugins: {

  },
    async rewrites() {
        return [
            {
                source: '/ttks/menu/:slug*',
                destination: '/ttks/menu/[slug]'
            }
        ];
    },
}
