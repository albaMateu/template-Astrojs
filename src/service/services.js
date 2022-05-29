import { queryGraphQL } from "../utils/graphql";

export const getServices = async () => {
  const query = `{
        texts {
            id
            title
            parrafo
        }
    }`;
  const { data } = await queryGraphQL({ query });
  const { texts } = data;
  return texts;
};
