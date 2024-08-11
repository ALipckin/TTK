module.exports = {
  plugins: {

  },
    async rewrites() {
        return [
            {
                source: '/ttks/:slug*',
                destination: '/ttks/[slug]'
            }
        ];
    },
}
