// postcss.config.js
const postCssPurge = require("@fullhuman/postcss-purgecss");

const purgecss = postCssPurge({
    // Specify the paths to all of the template files in your project
    content: [
        "./resources/views/*.php",
        "./resources/components/*.js"
    ],

    // Include any special characters you're using in this regular expression
    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
});

module.exports = {
    plugins: [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
        ...(process.env.NODE_ENV === "production" ? [purgecss] : [])
    ]
};
