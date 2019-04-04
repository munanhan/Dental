import * as dashboard from './dashboard'
import * as user from './user'

const apis = {
    dashboard,
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