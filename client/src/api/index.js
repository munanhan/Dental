import * as base from './base'
import * as home from './home'
import * as user from './user'
import * as appointment from './appointment'
import * as operation_log from './operation_log'
import * as patient_recycling_bin from './patient_recycling_bin'                                                   
import * as patient from './patient'
import * as disposal from './disposal'
import * as cost_category from './cost_category'
import * as disposal_combo from './disposal_combo'
import * as disposal_combo_menu from './disposal_combo_menu'
import * as patient_member from './patient_member'
import * as member from './member'
import * as staff from './staff'

const apis = {
    base,
    home,
    user,
    appointment,
    operation_log,
    patient_recycling_bin,
    patient,
    cost_category,
    disposal,
    disposal_combo,
    disposal_combo_menu,
    patient_member,
    member,
    staff
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