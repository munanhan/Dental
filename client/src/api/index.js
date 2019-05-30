import * as base from "./base";
import * as home from "./home";
import * as user from "./user";
import * as appointment from "./appointment";
import * as operation_log from "./operation_log";
import * as patient_recycling_bin from "./patient_recycling_bin";
import * as patient from "./patient";
import * as disposal from "./disposal";
import * as cost_category from "./cost_category";
import * as disposal_combo from "./disposal_combo";
import * as disposal_combo_menu from "./disposal_combo_menu";
import * as patient_member from "./patient_member";
import * as member from "./member";
import * as staff from "./staff";
import * as resource from "./patient_resource";
import * as category from "./patient_category";
import * as patient_allergy from "./patient_allergy";
import * as patient_anamneses from "./patient_anamneses";
import * as patient_teeth_habits from "./patient_teeth_habits";
import * as patient_impressions from "./patient_impressions";
import * as clinic from './clinic'
import * as area from './area'
import * as company from './company'
import * as chain_store from './chain_store'
import * as case_template_menu from './case_template_menu'


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
    staff,
    resource,
    clinic,
    area,
    category,
    patient_allergy,
    patient_anamneses,
    patient_teeth_habits,
    patient_impressions,
    company,
    chain_store,
    case_template_menu
};

const install = function(Vue) {
    if (install.installed) return;
    install.installed = true;
    Object.defineProperties(Vue.prototype, {
        $api: {
            get() {
                return apis;
            }
        }
    });
};

export default install;
