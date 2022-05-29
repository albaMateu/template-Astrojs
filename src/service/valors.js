import { queryGraphQL } from "../utils/graphql";

export const getValors = async () => {
  const query = `{
       texts(first: 4) {
        id
        title
        frases
        icono
      }
    }`;

  const { data } = await queryGraphQL({ query });
  const { texts } = data;
  return texts;
};
