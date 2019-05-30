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
import * as source from "./patient_source";
import * as category from "./patient_category";
import * as allergy from "./patient_allergy";
import * as anamnesis from "./patient_anamnesis";
import * as teethHabit from "./patient_teeth_habit";
import * as impressions from "./patient_impression";
import * as clinic from './clinic'
import * as area from './area'
import * as company from './company'


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
    source,
    clinic,
    area,
    category,
    allergy,
    anamnesis,
    teethHabit,
    impressions,
    company,

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
