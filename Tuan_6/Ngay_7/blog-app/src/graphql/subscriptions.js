// Đây là giả lập - có thể bỏ nếu không dùng đến
import { gql } from '@apollo/client/core'

export const POST_ADDED = gql`
  subscription {
    postAdded {
      id
      title
      body
    }
  }
`
