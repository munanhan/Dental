const path = require('path');
const srcPath = path.resolve(__dirname, './src');

console.log(srcPath);

module.exports = {
    chainWebpack: (config) => {
        config.resolve.alias
            .set('@src', `${srcPath}`)
            .set('@assets', `${srcPath}/assets`)
            .set('@components', `${srcPath}/components`)
            .set('@views', `${srcPath}/views`)
            .set('@css', `${srcPath}/assets/css`)
            .set('@common', `${srcPath}/common`)
    }
}

//删除了"@vue/prettier"，关闭了eslint
// "extends": [
//   "plugin:vue/essential",
//   "@vue/prettier"
// ],