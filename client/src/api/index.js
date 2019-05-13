import * as base from './base'
import * as home from './home'
import * as user from './user'
import * as appointment from './appointment'
import * as operation_log from './operation_log'
import * as patient_recycling_bin from './patient_recycling_bin'                                                   
import * as patient from './patient'

const apis = {
    base,
    home,
    user,
    appointment,
    operation_log,
    patient_recycling_bin,
    patient
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