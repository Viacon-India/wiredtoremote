/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],

  theme: {
    fontFamily: {
      icomoon: "icomoon",
      Supreme: ["Supreme"],
      Fredoka: ["Fredoka"],
    },

    extend: {
      screens: {
        sm: "640px",
        md: "769px",
        lg: "1025px",
        xl: "1281px",
        "2xl": "1537px",
        "3xl": "1681px",
      },

      colors: {
        primary: "#000080",
        primary_accent: "#DAEAF7",
        secondary: "#091A27",
        tertiary: "#F5F9FC",
        quaternary: "#EAF4FC",
        quinary: "#ECF2F6",
        // senary: "#2476BB",
      },
    },
  },

  plugins: [require("daisyui")],

  daisyui: {
    themes: false,
    darkTheme: "light",
    base: true,
    styled: true,
    utils: true,
    rtl: false,
    prefix: "",
    logs: true,
    themes: ["light", "cupcake"],
  },
};
