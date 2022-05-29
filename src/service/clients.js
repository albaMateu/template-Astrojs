import { queryGraphQL } from "../utils/graphql";

export const getClients = async () => {
  const query = `{
         texts(where: {}, first: 3) {
          id
          title
          frases
        }
    }`;

  const { data } = await queryGraphQL({ query });
  const { texts } = data;
  return texts;
};
