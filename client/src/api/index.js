import * as base from './home'
import * as home from './home'
import * as user from './user'

const apis = {
    base,
    home,
    user
}

const install = function (Vue) {
    if (install.installed) return
    install.installed = true
    Object.defineProperties(Vue.prototype, {
        $api: {
            get() {
                return apis;
            }
        }
    })
};

export default install;