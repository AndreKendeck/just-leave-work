module.exports = {
    theme: {
        customForms: theme => ({
            default: {
                checkbox: {
                    icon: `<svg xmlns="http://www.w3.org/2000/svg" width="9.211" height="6.802" viewBox="0 0 9.211 6.802">
            <path id="Path_379" data-name="Path 379" d="M10.383,6.5,5.995,10.888,4,8.894" transform="translate(-2.586 -5.086)" fill="none" stroke="#0b3954" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
          </svg>`
                }
            }
        }),
        extend: {
            colors: {
                jean: "#0b3954",
                seaweed: "#087E8B",
                aqua: "#BFD7EA",
                anger: "#C81D25",
                love: "#FF5A5F"
            }
        }
    },
    variants: {},
    plugins: [require("@tailwindcss/custom-forms")]
};
