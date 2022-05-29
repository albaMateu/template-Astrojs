//dirección API
const API_ENDPOINT =
  "https://api-eu-central-1.graphcms.com/v2/cl2lr8yh91nv601xu02rmdomq/master";

/* llamada a GRAPHQL*/
export const queryGraphQL = ({ query }) => {
  return fetch(API_ENDPOINT, {
    method: "POST",
    headers: { "Content-Type": "aplication/json" },
    body: JSON.stringify({ query }),
  }).then((res) => res.json());
};
