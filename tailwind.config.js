const { colors } = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        './resources/**/*.jsx',
    ],
    variants: {},
    plugins: [
        require("@tailwindcss/custom-forms"),
        require("tailwindcss-tables")(),
    ],
    corePlugins: {
        container: false,
        boxSizing: false,
        float: false,
        clear: false,
        objectFit: false,
        objectPosition: false,
        backgroundAttachment: false,
        backgroundClip: false,
        backgroundPosition: false,
        backgroundRepeat: false,
        backgroundSize: false,
        backgroundImage: false,
        gradientColorStops: false,
        borderOpacity: false,
        borderStyle: false,
        gridTemplateColumns: false,
        gridColumn: false,
        gridColumnStart: false,
        gridColumnEnd: false,
        gridRow: false,
        gridRowStart: false,
        gridRowEnd: false,
        gridAutoFlow: false,
        gap: false
    },
};
