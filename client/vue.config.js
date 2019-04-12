const path = require("path");
const srcPath = path.resolve(__dirname, "./src");

console.log(srcPath);

module.exports = {
    chainWebpack: config => {
        config.resolve.alias
            .set("@src", `${srcPath}`)
            .set("@assets", `${srcPath}/assets`)
            .set("@components", `${srcPath}/components`)
            .set("@views", `${srcPath}/views`)
            .set("@css", `${srcPath}/assets/css`)
            .set("@common", `${srcPath}/common`);
    },
    pwa: {
        iconPaths: {
            favicon32: "favicon-32x32",
            favicon16: "favicon.ico",
            appleTouchIcon: "favicon-32x32",
            maskIcon: "favicon-32x32",
            msTileImage: "favicon-32x32"
        }
    }
};

//删除了"@vue/prettier"，关闭了eslint
// "extends": [
//   "plugin:vue/essential",
//   "@vue/prettier"
// ],
