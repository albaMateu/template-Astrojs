module.exports = {
  content: ["./src/**/*.{html,js,astro,svelte}"],
  theme: {
    extend: {
      colors: {
        transparent: "transparent",
        current: "currentColor",
        "violeta-oscuro": "#4c1451",
        "violeta-claro": "#826383",
        naranja: "#f06b40",
        "rosa-plata": "#ccb0b3",
      },
      fontFamily: {
        quicksand: ["Quicksand"],
      },
      screens: {
        sm: "200px",
        // => @media (min-width: 200px) { ... }
      },
    },
  },

  plugins: [],
};
