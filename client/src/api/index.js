import * as base from './base'
import * as home from './home'
import * as user from './user'
import * as appointment from './appointment'
<<<<<<< Updated upstream
import * as operation_log from './operation_log'
=======
import * as patient from './patient'
>>>>>>> Stashed changes

const apis = {
    base,
    home,
    user,
    appointment,
<<<<<<< Updated upstream
    operation_log
=======
    patient
>>>>>>> Stashed changes
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