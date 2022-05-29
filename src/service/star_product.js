import { queryGraphQL } from "../utils/graphql";

export const getBeneficios = async () => {
  const query = `{
         texts {
          id
          frase
        }
    }`;

  const { data } = await queryGraphQL({ query });
  const { texts } = data;
  return texts;
};

export const getSingleInfo = async () => {
  const query = `{
         texts(where: {}, first: 1) {
          id
          frase
          parrafo
          title
          frases
        }
    }`;

  const { data } = await queryGraphQL({ query });
  const { texts } = data;
  return texts;
};
