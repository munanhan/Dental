<template>
    <el-dialog
        title="修改信息"
        :visible.sync="show"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        class="custom-dialog"
        v-dialog-drag
        width="750px"
        top="1vh"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
            :rules="rules"
        >
            <!----------------------- 基本资料 -->

            <div class="mod-1">
                <div style="display:flex">
                    <div class="number-top">1</div>
                    <div class="number">基本资料</div>
                </div>
                <div class="image">

                </div>
                <el-form-item
                    label="病历号"
                    class="left-width"
                    prop="case_id"
                >
                    <el-input
                        :disabled="true"
                        v-model="form.case_id"
                        disable
                    ></el-input>
                </el-form-item>

                <el-form-item
                    label="姓名"
                    class="left-width"
                    prop="patient_name"
                >
                    <el-input v-model="form.patient_name"></el-input>
                </el-form-item>
                <el-form-item label="性别">
                    <el-radio-group v-model="form.patient_sex">
                        <el-radio :label="0">男</el-radio>
                        <el-radio :label="1">女</el-radio>
                        <el-radio :label="2">未填</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="出生年月">
                    <el-date-picker
                        style="width:260px"
                        v-model="form.patient_birthday"
                        type="date"
                        value-format="yy-mm-dd"
                        placeholder="选择日期"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item
                    label="年龄(岁)"
                    class="left-width"
                    prop="patient_age"
                >
                    <el-input v-model="form.patient_age"></el-input>
                </el-form-item>

                <div style="display:flex">
                    <el-form-item
                        label="电话"
                        prop="patient_phone"
                        style="width:340px"
                    >
                        <el-input v-model="form.patient_phone"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="会员等级"
                        prop="member_id"
                    >
                        <el-select
                            style="width:260px"
                            v-model="form.member_id"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in editInfo.members"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="mem_grade"
                    ></i>
                    <el-form-item
                        label="会员卡号"
                        class="right-width"
                        prop="member_card"
                    >
                        <el-input v-model="form.member_card"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item label="职业">
                        <el-select
                            v-model="form.patient_profession"
                            placeholder="请选择"
                            style="width:260px"
                        >
                            <el-option
                                v-for="item in editInfo.professions"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pro_fess"
                    ></i>
                    <el-form-item
                        label="社保号"
                        class="right-width"
                        prop="society_no"
                    >
                        <el-input v-model="form.society_no"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="电子邮箱"
                        class="left-width"
                        prop="patient_email"
                    >
                        <el-input v-model="form.patient_email"></el-input>
                    </el-form-item>
                    <el-form-item
                        label="患者分组"
                        class="right-width"
                        style="margin-left:30px"
                        prop="patient_group"
                    >
                        <el-select
                                v-model="form.patient_group"
                                placeholder="请选择"
                                style="width:260px"
                        >
                            <el-option
                                    v-for="item in grouList"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="患者备注"
                        class="left-width"
                        prop="patient_content"
                    >
                        <el-input v-model="form.patient_content"></el-input>
                    </el-form-item>
                    <el-form-item
                        label="民族"
                        class="right-width"
                        style="margin-left:30px"
                        prop="nation"
                    >
                        <el-input v-model="form.nation"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="介绍人"
                        class="left-width"
                    >
                        <el-input v-model="form.introducer"></el-input>
                    </el-form-item>
                    <el-form-item
                        label="咨询师"
                        class="right-width"
                        style="margin-left:30px"
                    >
                        <el-select
                            style="width:250px"
                            v-model="form.counselor"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in editInfo.attend_doctors"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item label="联系地址">
                        <el-input
                            v-model="form.patient_address"
                            style="width:620px"
                        ></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item label="患者印象">
                        <el-select
                                style="width:250px"
                                v-model="form.patient_impression"
                                placeholder="请选择"
                        >
                            <el-option
                                    v-for="item in editInfo.impressions"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pat_impre"
                    ></i>
                    <el-form-item label="电网咨询">
                        <el-select
                            style="width:250px"
                            v-model="form.grid_consulting"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in editInfo.attend_doctors"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>

                <!-------------------- 就诊信息  -->

                <div style="display:flex">
                    <div class="number-top">2</div>
                    <div class="number">就诊信息</div>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="患者来源"
                        class="left-width"
                    >
                        <el-select
                            style="width:250px"
                            v-model="form.patient_source"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in editInfo.source"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pat_sour"
                    ></i>
                    <el-form-item label="患者分类">
                        <el-select
                            style="width:250px"
                            v-model="form.patient_category"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in editInfo.categories"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="class_pat"
                    ></i>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="过 敏 史"
                        prop="allergy"
                    >
                        <el-select
                            style="width:620px"
                            v-model="form.allergy"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                        >
                            <el-option
                                v-for="item in editInfo.allergies"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="allergy"
                    ></i>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="既 往 史"
                        prop="anamnesis"
                    >
                        <el-select
                            style="width:620px"
                            v-model="form.anamnesis"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                        >
                            <el-option
                                v-for="item in editInfo.anamneses"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="past_med"
                    ></i>
                </div>
                <!-- <div style="display:flex">
                    <el-form-item
                        label="刷牙"
                        prop="brush_teeth"
                    >
                        <div style="display:flex">
                            <el-input
                                style="width:80px"
                                v-model="form.brush_teeth_Timeday"
                            ></el-input>
                            <div style="margin-left:10px">次/天</div>
                        </div>
                    </el-form-item>
                    <el-input
                        v-model="form.brush_teeth_minutestime"
                        style="width:80px;
                               margin-left:10px"
                    ></el-input>
                    <div style="margin-left:10px;
                                margin-top:13px">分钟/次</div>

                    <el-form-item
                        label="吸烟"
                        style="margin-left:30px"
                        prop="smoking"
                    >
                        <div style="display:flex">
                            <el-input
                                style="width:150px"
                                v-model="form.smoking"
                            ></el-input>
                            <div style="margin-left:10px">次/天</div>
                        </div>
                    </el-form-item>
                </div> -->
                <div style="display:flex">
                    <el-form-item
                        label="洁牙习惯"
                        style="width:700px"
                        prop="teeth"
                    >
                        <el-select
                            style="width:620px"
                            v-model="form.teeth_habits"
                            filterable
                            allow-create
                            default-first-option
                        >
                            <el-option
                                v-for="item in editInfo.teeth_habits"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="teeth_hab"
                    ></i>
                </div>
            </div>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button
                :loading="commitLoading"
                type="primary"
                @click="submit('form')"
            >确 定</el-button>
            <!-- <el-button @click="new_relat">新增关系</el-button> -->
            <el-button @click="closeDialog">取 消</el-button>

            <membership-grade :show.sync="memgrade_show"></membership-grade>
            <professional :show.sync="profess_show"></professional>
            <!-- <contact-address :show.sync="contadd_show"></contact-address> -->
            <patients-impression :show.sync="patimpre_show"></patients-impression>
            <patients-source :show.sync="patsour_show"></patients-source>
            <classification-patients :show.sync="classpat_show"></classification-patients>
            <allergy :show.sync="allergy_show"></Allergy>
            <past-medicalhistory :show.sync="pastmed_show"></past-medicalhistory>
            <teethcleaning-habits :show.sync="teethhab_show"></teethcleaning-habits>
            <new-relationship :show.sync="newrelat_show"></new-relationship>
        </div>
    </el-dialog>
</template>


<script>
import AddDialogForm from "@/views/base/AddDialogForm";
import MembershipGrade from "./MembershipGrade";
import professional from "./professional";

import PatientsImpression from "./PatientsImpression";
import PatientsSource from "./PatientsSource";
import ClassificationPatients from "./ClassificationPatients";
import Allergy from "./Allergy";
import PastMedicalhistory from "./PastMedicalhistory";
import TeethcleaningHabits from "./TeethcleaningHabits";
import NewRelationship from "./NewRelationship";
export default {
    name: "AddPatient",

    mixins: [AddDialogForm],

    components: {
        MembershipGrade,
        professional,
        // ContactAddress,
        PatientsImpression,
        PatientsSource,
        ClassificationPatients,
        Allergy,
        PastMedicalhistory,
        TeethcleaningHabits,
        NewRelationship
    },

    props:{
        editInfo:{},
    },

    data() {
        return {
            memgrade_show: false,
            profess_show: false,
            contadd_show: false,
            patimpre_show: false,
            patsour_show: false,
            classpat_show: false,
            allergy_show: false,
            pastmed_show: false,
            teethhab_show: false,
            newrelat_show: false,

            grouList:[
                {
                    id:0,
                    name:"最近患者"
                },
                {
                    id:1,
                    name:"黑名单"
                },
                {
                    id:2,
                    name:"治疗完成"
                }
            ],
            form: {
                member_id: "",
                patient_birthday: "",
                patient_age: "",
                patient_source: "",
                patient_category:"",
                patient_profession:"",
                society_no:"",
                patient_group: "",
                case_id: "",
                patient_phone: "",
                patient_sex:"",
                patient_name: "",
                introducer:"",
                counselor:"",
                patient_impression:"",
                grid_consulting:"",
                allergy:[],
                anamnesis:[],
                brush_day:"",
                brush_minutes:"",
                smoke_day:"",
                teeth_habits: "",
                member_card: "",
                patient_email: "",
                patient_content: "",
                nation: "",
                patient_address: ""
            },
            rules: {
                patient_name: [
                    { required: true, message: "请输入姓名", trigger: "blur" }

                ],

                patient_phone: [
                    { required: true, message: "请输入手机号", trigger: "blur" }

                ]
            }
        };
    },
    watch: {
        show(newValue, oldValue) {
            let that=this;
            that.form=that.editInfo.patient_info;
        }
    },
    methods: {

        submit(form){
            let that = this;
            that.$refs[form].validate(valid => {
                if (valid) {
                    that.$api.patient
                        .update(that.form)
                        .then(res => {
                            if (res.code == 200) {
                                that.$emit("edit-item",JSON.parse(JSON.stringify(res.data)));
                                that.$message.success('修改成功');
                                that.closeDialog();
                            } else {
                                that.$message.error("修改失败");
                            }
                        })
                        .catch(res => {
                            console.log(res.msg);
                        });
                } else {
                    return false;
                }
            });
        },
        mem_grade() {
            this.memgrade_show = true;
        },
        pro_fess() {
            this.profess_show = true;
        },
        cont_add() {
            this.contadd_show = true;
        },
        pat_impre() {
            this.patimpre_show = true;
        },
        pat_sour() {
            this.patsour_show = true;
        },
        class_pat() {
            this.classpat_show = true;
        },
        allergy() {
            this.allergy_show = true;
        },
        past_med() {
            this.pastmed_show = true;
        },
        teeth_hab() {
            this.teethhab_show = true;
        },
        new_relat() {
            this.newrelat_show = true;
        },

    }
};
</script>

<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.mod-1 {
    .image {
        border: 1px solid rgb(167, 167, 167);
        position: absolute;
        right: 0;
        margin-right: 35px;
        width: 320px;
        height: 350px;
        // background-image:none;
        // background-color: #000;
    }
    .number-top {
        background-color: #a6d2ff;
        margin-right: 3px;
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .number {
        font-size: 18px;

        font-weight: bold;
        // rgb(110, 240, 149)
        margin-bottom: 10px;
    }
    .left-width {
        width: 340px;
    }
    .right-width {
        width: 330px;
    }
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
}
</style>