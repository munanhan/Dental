const path = require("path");
const srcPath = path.resolve(__dirname, "./src");
const config = require("./config");
const webpack = require("webpack");
const compressionWebpackPlugin = require("compression-webpack-plugin");

let plugins = [];

//如果当前是测试的，就开启
plugins.push(
    new webpack.DefinePlugin({
        //设置全局的变量
        apiBaseURL:
            process.env.NODE_ENV === "development"
                ? JSON.stringify(config.apiBaseURL)
                : JSON.stringify("")
    })
);

if (process.env.NODE_ENV === "production") {
    plugins.push(
        new compressionWebpackPlugin({
            algorithm: "gzip",
            test: /\.js$|\.html$|.\css/, //匹配文件名
            threshold: 10240,
            minRatio: 0.8
        })
    );
}

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
    },

    configureWebpack: {
        plugins: plugins
    }
};

//删除了"@vue/prettier"，关闭了eslint
// "extends": [
//   "plugin:vue/essential",
//   "@vue/prettier"
// ],
