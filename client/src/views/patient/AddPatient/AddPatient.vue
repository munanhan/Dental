<template>
    <el-dialog
        title="新增患者"
        :visible.sync="show"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        class="custom-dialog"
        v-dialog-drag
        width="750px"
    >
        <el-form
            ref="AddPatientForm"
            label-width="80px"
            :rules="form.rules"
            :model="form"
        >
            <div style="display:flex">
                <el-form-item
                    label="病历号"
                    style="width:300px"
                    size="small"
                    prop="case_id"
                >
                    <el-input
                        :disabled="true"
                        v-model="form.case_id"
                        disable
                    ></el-input>
                </el-form-item>
                <!-- <i
          class="el-icon-setting form-setting"
         
        ></i> -->
                <!-- <i
          class="fa fa-cog"
          style="margin-top:10px;
                 padding-left:10px;
                 font-size:20px;
                 cursor:pointer"
        ></i> -->
                <!-- 
        <i
                        class="fa fa-arrow-circle-left mr-10 pre-mth"
                        @click.prevent.stop="switchDate('pre')"
                    ></i> -->

                <!-- <div
                    class="block"
                    style="margin-top:10px;
                 margin-left:40px;
                 margin-right:40px"
                >
                    <span class="demonstration"></span>
                    <el-rate v-model="form.value1"></el-rate>
                </div> -->
                <div class="block">
                    <el-button
                        round
                        style="margin-left:50px"
                    >新增头像</el-button>
                </div>
                <!-- <i
          class="el-icon-setting form-setting"
         
        ></i>
        <i
          class="el el-icon-question form-setting"
          style="margin-top:10px;
                 font-size:20px;
                 cursor:pointer"
        ></i> -->
            </div>

            <div style="display:flex">
                <el-form-item
                    label="姓名"
                    style="width:300px"
                    prop="name"
                >
                    <el-input v-model="form.name"></el-input>
                </el-form-item>

                <div style="margin-top:10px;margin-left:50px">
                    性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <el-radio
                        v-model="form.sex"
                        label="0"
                    >男</el-radio>
                    <el-radio
                        v-model="form.sex"
                        label="1"
                    >女</el-radio>
                    <el-radio
                        v-model="form.sex"
                        label="2"
                    >未填</el-radio>
                </div>

            </div>
            <!-- <div style="display:flex">
        <el-form-item
          label="医保余额"
          prop="society_no"
          style="width:300px"
        >
          <el-input v-model="form.society_no"></el-input>
        </el-form-item>
        <el-form-item
          style="margin-left:30px;width:300px"
          label="医保卡号"
          prop="age"
        >
          <el-input v-model="form.age"></el-input>
        </el-form-item>
      </div> -->
            <div style="height:300px;overflow: auto">

                <div style="display:flex">
                    <el-form-item
                        label="电话"
                        prop="phone"
                        style="width:300px"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>
                    <!-- <i
          class="el-icon-setting form-setting"
         
        ></i> -->
                    <el-form-item
                        style="margin-left:30px;width:300px"
                        label="年 龄"
                        prop="age"
                    >
                        <el-input v-model="form.age"></el-input>
                    </el-form-item>
                </div>

                <div style="display:flex">
                    <el-form-item
                        label="出生年月"
                        prop="birthday"
                        style="width:300px"
                    >
                        <!-- <el-input
                            autocomplete="off"
                            v-model="form.birthday"
                        ></el-input> -->
                        <el-date-picker
                            v-model="form.value1"
                            type="date"
                            placeholder="选择日期"
                        >
                        </el-date-picker>
                    </el-form-item>

                </div>

                <div style="display:flex">
                    <el-form-item
                        label="患者来源"
                        prop="source"
                    >
                        <el-select
                            v-model="form.source"
                            style="width:220px"
                        >
                            <el-option
                                v-for="item in sourceList"
                                :key="item.id"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="Patient_source"
                    ></i>
                    <div style="margin-top:10px;margin-left:20px">
                        类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <el-radio
                            v-model="form.category"
                            label="1"
                        >初诊</el-radio>
                        <el-radio
                            v-model="form.category"
                            label="2"
                        >复诊</el-radio>
                    </div>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="就诊日期"
                        prop="clinic_date"
                    >
                        <el-date-picker
                            v-model="form.clinic_date"
                            type="date"
                            placeholder="选择日期"
                        >
                        </el-date-picker>
                    </el-form-item>

                    <el-form-item
                        style="margin-left:50px;width:300px"
                        label="主治医生"
                        prop="attendingphysician"
                    >
                        <el-select
                            v-model="form.attendingphysician"
                            style="width:220px"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in attend"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>

                </div>

                <div style="display:flex">
                    <el-form-item
                        label="患者分类"
                        prop="group"
                    >
                        <el-select
                            v-model="form.patient_category"
                            style="width:220px"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in categoryList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="class_pat"
                    ></i>
                    <el-form-item
                        style="margin-left:20px;width:300px"
                        prop="content"
                        label="患者备注"
                    >
                        <el-input v-model="form.content"></el-input>
                    </el-form-item>

                </div>
                <div style="display:flex">
                    <el-form-item
                        label="会员等级"
                        prop="member_level"
                    >
                        <el-select
                            v-model="form.member_level"
                            style="width:220px"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in memberList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="member_grade"
                    ></i>

                    <el-form-item
                        style="margin-left:20px;width:300px"
                        label="会员卡号"
                        prop="mem_card"
                    >
                        <el-input v-model="form.mem_card"></el-input>
                    </el-form-item>
                </div>
                <div>
                    <el-form-item
                        autocomplete="off"
                        prop="patient_addresses"
                        label="联系地址"
                    >
                        <el-select
                            v-model="form.patient_addresses"
                            placeholder="请选择"
                            style="width:570px"
                        >
                            <el-option
                                v-for="item in form.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                        <!-- <i
              class="el-icon-setting form-setting"
              @click="contact_add"
            ></i> -->
                    </el-form-item>
                </div>
                <div>
                    <el-form-item
                        label="过 敏 史"
                        prop="allergie"
                    >
                        <!-- <el-select
                            v-model="form.allergie"
                            style="width:570px"
                            multiple
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in allergieList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select> -->
                        <el-select
                            v-model="form.allergie"
                            style="width:570px"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in allergieList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                        <i
                            class="el-icon-setting form-setting"
                            @click="allergy"
                        ></i>
                    </el-form-item>
                </div>
                <div>
                    <el-form-item
                        label="既 往 史"
                        prop="anamneses"
                    >
                        <!-- <el-select
                            v-model="form.anamneses"
                            style="width:570px"
                            multiple
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in anamnesesList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select> -->
                        <el-select
                            v-model="form.anamneses"
                            style="width:570px"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in anamnesesList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                        <i
                            class="el-icon-setting form-setting"
                            @click="past_med"
                        ></i>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="社保号"
                        prop="society_no"
                    >
                        <el-input
                            style="width:220px"
                            v-model="form.society_no"
                        ></el-input>

                    </el-form-item>
                    <el-form-item
                        style="margin-left:60px;width:300px"
                        label="电子邮箱"
                        porp="email"
                    >
                        <el-input v-model="form.email"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="患者印象"
                        prop="impression_id"
                    >
                        <el-select
                            v-model="form.impressions"
                            style="width:220px"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in impressionsList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pat_impre"
                    ></i>
                    <el-form-item
                        style="margin-left:30px;width:300px"
                        label="电网咨询"
                        prop="grid_consulting"
                    >
                        <el-input v-model="form.grid_consulting"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="民族"
                        prop=""
                        style="width:300px"
                    >
                        <el-input></el-input>
                    </el-form-item>
                    <el-form-item
                        label="洁牙习惯"
                        prop="teeth_cleaning_habits"
                        style="margin-left:60px;width:300px"
                    >
                        <el-select
                            v-model="form.teeth_cleaning_habits"
                            style="width:220px"
                            multiple
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in teethList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="teeth_habit"
                    ></i>
                </div>
                <div style="display:flex">
                    <!-- <el-form-item
            label="民族"
            porp="national"
          >
            <el-select
              style="width:220px"
              v-model="form.national"
              placeholder="请选择"
            >
              <el-option
                v-for="item in form.options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </el-form-item> -->
                    <el-form-item
                        label="刷牙"
                        prop="brush_teeth"
                    >
                        <div style="display:flex">
                            <el-input
                                style="width:60px"
                                v-model="form.brush_day"
                            ></el-input>
                            <div style="margin-left:10px">次/天</div>
                        </div>
                    </el-form-item>

                    <div style="display:flex">
                        <el-input
                            v-model="form.brush_minutes"
                            style="width:60px;
                             margin-left:10px"
                        ></el-input>
                        <div style="margin-left:10px;
                        margin-top:13px">分钟/次</div>
                    </div>
                    <el-form-item
                        label="吸烟"
                        style="margin-left:30px"
                        prop="smoking"
                    >
                        <div style="display:flex">
                            <el-input
                                style="width:100px"
                                v-model="form.smoking"
                            ></el-input>
                            <div style="margin-left:10px">次/天</div>
                        </div>
                    </el-form-item>
                </div>
                <div style="display:flex">

                </div>
            </div>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button>读身份证</el-button>
            <el-button>清空</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
                @click="submitFrom"
            >确 定</el-button>
            <el-button @click="closeDialog">取 消</el-button>

        </div>
        <patients-source :show.sync="patsourShow"></patients-source>
        <classification-patients :show.sync="classpat_show"></classification-patients>
        <membership-grade :show.sync="memgrade_show"></membership-grade>
        <!-- <contact-address :show.sync="contadd_show"></contact-address> -->
        <allergy :show.sync="allergy_show"></allergy>
        <past-medicalhistory :show.sync="pastmed_show"></past-medicalhistory>
        <patients-impression :show.sync="patimpre_show"></patients-impression>
        <teethcleaning-habits :show.sync="teehabit_show"></teethcleaning-habits>
        <!-- <user-image :show.sync="userimage_show"></user-image> -->
    </el-dialog>
</template>


<script>
import AddDialogForm from "@/views/base/AddDialogForm";
import PatientsSource from "./PatientsSource";
import ClassificationPatients from "./ClassificationPatients";
import MembershipGrade from "./MembershipGrade";
// import ContactAddress from "./ContactAddress";
import Allergy from "./Allergy";
import PastMedicalhistory from "./PastMedicalhistory";
import PatientsImpression from "./PatientsImpression";
import TeethcleaningHabits from "./TeethcleaningHabits";
// import UserImage from "./UserImage";

export default {
    name: "AddPatient",

    mixins: [AddDialogForm],

    components: {
        PatientsSource,
        ClassificationPatients,
        MembershipGrade,
        // ContactAddress,
        Allergy,
        PastMedicalhistory,
        PatientsImpression,
        TeethcleaningHabits
        // UserImage
    },

    data() {
        return {
            patsourShow: false,
            classpat_show: false,
            memgrade_show: false,
            contadd_show: false,
            allergy_show: false,
            pastmed_show: false,
            patimpre_show: false,
            teehabit_show: false,
            userimage_show: false,
            sourceList: [],
            attend: [],
            categoryList: [],
            memberList: [],
            allergieList: [],
            anamnesesList: [],
            impressionsList: [],
            teethList: [],

            form: {
                value1: "",
                category: "1",
                teeth_cleaning_habits: "",
                clinic_date: "",
                brush_day: "",
                brush_minutes: "",
                case_id: "",
                name: "",
                sex: "2",
                phone: "",
                birthday: "",
                age: "",
                source: "",
                group: "",
                member_level: "",
                mem_card: "",
                patient_addresses: "",
                society_no: "",
                email: "",
                impression_id: "",
                grid_consulting: "",
                rules: {
                    attendingphysician: [
                        {
                            required: true,
                            message: "请输入主治医生",
                            trigger: "blur"
                        }
                    ],
                    name: [
                        {
                            required: true,
                            message: "请输入姓名",
                            trigger: "blur"
                        }
                    ],
                    case_id: [
                        {
                            required: true,
                            message: "请输入病历号",
                            trigger: "blur"
                        }
                    ],
                    phone: [
                        {
                            required: true,
                            message: "请输入手机号",
                            trigger: "blur"
                        }
                    ]
                }
            }
        };
    },

    mounted() {
        // let that = this;
        // that.getCaseNo();
        // that.getConfigData();
    },
    watch: {
        show(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.getCaseNo();
                that.getConfigData();
            }
        }
    },

    methods: {
        submitFrom() {
            let that = this;
            // that.getCaseNo();
            console.log(that.form);
            // this.$api.patient
            //     .addPatient(this.form)
            //     .then(function(response) {
            //         console.log(response);
            //     })
            //     .catch(function(error) {
            //         console.log(error);
            //     });

            console.log();
        },
        Patient_source() {
            this.patsourShow = true;
        },
        class_pat() {
            this.classpat_show = true;
        },
        member_grade() {
            this.memgrade_show = true;
        },
        contact_add() {
            this.contadd_show = true;
        },
        allergy() {
            this.allergy_show = true;
        },
        past_med() {
            this.pastmed_show = true;
        },
        pat_impre() {
            this.patimpre_show = true;
        },
        teeth_habit() {
            this.teehabit_show = true;
        },
        // user_image() {
        //     this.userimage_show = true;
        // },
        // 病历号获取数据
        getCaseNo() {
            let that = this;
            that.$api.patient
                .caseNo()
                .then(res => {
                    // console.log(res.data);
                    that.form.case_id = res.data.case_id;
                })
                .catch(res => {
                    console.log(res);
                });
        },
        // 配置项
        getConfigData() {
            let that = this;
            that.$api.patient
                .configData()
                .then(res => {
                    that.sourceList = res.data.patient_sources;
                    that.attend = res.data.users.doctor;
                    that.categoryList = res.data.patient_categories;
                    that.memberList = res.data.patient_members;
                    that.allergieList = res.data.patient_allergies;
                    that.anamnesesList = res.data.patient_anamneses;
                    that.teethList = res.data.patient_teeth_habits;
                    that.impressionsList = res.data.patient_impressions;
                    console.log(res.data);
                    // that.form.case_id = res.data;
                })
                .catch(res => {
                    console.log(res);
                });
        },
        afterClose() {
            this.$refs["AddPatientForm"].resetFields();
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

// @color: '#aaaa';

// .flex{
//     display: flex;
//     color: @color;
// }

// .sssss{
//     .flex;
// }

.form-setting {
    text-align: right;
    width: 30px;
    font-size: 22px;
    margin-top: 10px;
    cursor: pointer;

    &:hover {
        color: @color;
    }
}
</style>