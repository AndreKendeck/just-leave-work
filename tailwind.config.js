module.exports = {
    theme: {
        extend: {
            colors: {
                jean: "#0b3954",
                seaweed: "#087E8B",
                aqua: "#BFD7EA",
                anger: "#C81D25",
                love: "#FF5A5F"
            }
        },
        minWidth: {
            "0": "0",
            "1/4": "25%",
            "1/2": "50%",
            "3/4": "75%",
            full: "100%"
        }, 
        minHeight: {
            "0": "0",
            "1/4": "25%",
            "1/2": "50%",
            "3/4": "75%",
            full: "100%"
        }
    },
    variants: {},
    plugins: [require("@tailwindcss/custom-forms")]
};
