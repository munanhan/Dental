import * as base from './base'
import * as home from './home'
import * as user from './user'
import * as appointment from './appointment'

const apis = {
    base,
    home,
    user,
    appointment
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