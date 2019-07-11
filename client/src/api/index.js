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
import * as chain_store from './chain_store'
import * as case_template_menu from './case_template_menu'
import * as case_template from './case_template'
import * as medical from './medical'
import * as inspect from './inspect'
import * as diagnose from './diagnose'
import * as treat from './treat'
import * as advice from './advice'
import * as privilege from './privilege'
import * as role from './role'
import * as patient_order from './patient_order'
import * as expenditure from './expenditure'
import * as expenditure_type from './expenditure_type'
import * as expenditure_method from './expenditure_method'
import * as recon_calendar from './recon_calendar'
import * as expenditure_statistics from './expenditure_statistics'
import * as arrearage_statistics from './arrearage_statistics'
import * as flow_sheet from './flow_sheet'
import * as base_demand from "./base_demand";
import * as potential_demand from "./potential_demand";
import * as patient_professional from "./patient_professional";
import * as patient_case_template from "./patient_case_template";
import * as patient_medical from "./patient_medical";
import * as patient_consult from "./patient_consult";
import * as patient_disposal from "./patient_disposal";
import * as patient_charge from "./patient_charge";
import * as patient_visit from  "./patient_visit";
import * as patient_case  from "./patient_case";
import * as visit_combo from "./visit_combo";
import * as visit_items from "./visit_items";


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
    company,
    chain_store,
    case_template_menu,
    case_template,
    medical,
    inspect,
    diagnose,
    treat,
    advice,
    allergy,
    anamnesis,
    teethHabit,
    impressions,
    privilege,
    role,
    patient_order,
    expenditure,
    expenditure_type,
    expenditure_method,
    recon_calendar,
    expenditure_statistics,
    arrearage_statistics,
    flow_sheet,
    base_demand,
    potential_demand,
    patient_professional,
    patient_case_template,
    patient_medical,
    patient_consult,
    patient_disposal,
    patient_charge,
    patient_visit,
    patient_case,
    visit_combo,
    visit_items,

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
