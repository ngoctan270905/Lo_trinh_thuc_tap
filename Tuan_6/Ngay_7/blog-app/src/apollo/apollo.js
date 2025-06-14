import { ApolloClient, InMemoryCache, createHttpLink } from '@apollo/client/core'

const httpLink = createHttpLink({
  uri: process.env.VUE_APP_GRAPHQL_URL, // ✅ CHÍNH XÁC CHO VUE CLI
})

const apolloClient = new ApolloClient({
  link: httpLink,
  cache: new InMemoryCache()
})
console.log('GraphQL URL:', process.env.VUE_APP_GRAPHQL_URL)

export default apolloClient
