<template>
    <el-dialog
        title="修改信息"
        :visible.sync="show"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        class="custom-dialog"
        v-dialog-drag
        width="950px"
        top="1vh"
    >
        <el-form
            ref="Modifyform"
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
                    prop="medical_record"
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
                    prop="name"
                >
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="性别">
                    <el-radio-group v-model="form.sex">
                        <el-radio :label="0">男</el-radio>
                        <el-radio :label="1">女</el-radio>
                        <el-radio :label="2">未填</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="出生年月">
                    <el-date-picker
                        style="width:260px"
                        v-model="form.birthday"
                        type="date"
                        placeholder="选择日期"
                    >
                    </el-date-picker>
                </el-form-item>
                <el-form-item
                    label="年龄(岁)"
                    class="left-width"
                    prop="age"
                >
                    <el-input v-model="form.age"></el-input>
                </el-form-item>

                <div style="display:flex">
                    <el-form-item
                        label="电话"
                        prop="phone"
                        style="width:340px"
                    >
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="会员等级"
                        prop="value"
                    >
                        <el-select
                            style="width:260px"
                            v-model="form.value"
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
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="mem_grade"
                    ></i>
                    <el-form-item
                        label="会员卡号"
                        class="right-width"
                        prop="member_gard"
                    >
                        <el-input v-model="form.member_gard"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item label="职业">
                        <el-select
                            v-model="form.value"
                            placeholder="请选择"
                            style="width:260px"
                        >
                            <el-option
                                v-for="item in form.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
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
                        prop="society"
                    >
                        <el-input v-model="form.society"></el-input>
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="电子邮箱"
                        class="left-width"
                        prop="email"
                    >
                        <el-input v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item
                        label="患者分组"
                        class="right-width"
                        style="margin-left:30px"
                        prop="group"
                    >
                        <el-input v-model="form.group"></el-input>
                    </el-form-item>
                </div>
                <el-form-item
                    label="患者备注"
                    style="width:700px"
                >
                    <el-input></el-input>
                </el-form-item>
                <div style="display:flex">
                    <el-form-item
                        label="介绍人"
                        class="left-width"
                    >
                        <el-input></el-input>
                    </el-form-item>
                    <el-form-item
                        label="咨询师"
                        class="right-width"
                        style="margin-left:30px"
                    >
                        <el-select
                            style="width:250px"
                            v-model="form.value"
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
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item label="联系地址">
                        <el-select
                            style="width:620px"
                            v-model="form.value"
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
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="患者印象"
                        class="left-width"
                        prop=""
                    >
                        <el-input></el-input>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pat_impre"
                    ></i>
                    <el-form-item label="电网咨询">
                        <el-select
                            style="width:250px"
                            v-model="form.value"
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
                        <el-input></el-input>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="pat_sour"
                    ></i>
                    <el-form-item label="患者分类">
                        <el-select
                            style="width:250px"
                            v-model="form.value"
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
                                v-for="item in form.allergyList"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
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
                        prop="pastMedicalhistory"
                    >
                        <el-select
                            style="width:620px"
                            v-model="form.pastMedicalhistory"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                        >
                            <el-option
                                v-for="item in form.pastMedicalhistoryList"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
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
                            v-model="form.teeth"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                        >
                            <el-option
                                v-for="item in form.teethList"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="teeth_hab"
                    ></i>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="初诊医生"
                        class="left-width"
                    >
                        <el-select
                            style="width:260px"
                            v-model="form.value"
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
                    </el-form-item>
                    <el-form-item
                        label="初诊日期"
                        class="right-width"
                        style="margin-left:30px"
                    >
                        <el-select
                            style="width:250px"
                            v-model="form.value"
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
                    </el-form-item>
                </div>
                <div style="display:flex">
                    <el-form-item
                        label="复诊医生"
                        class="left-width"
                    >
                        <el-select
                            style="width:260px"
                            v-model="form.value"
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
                    </el-form-item>
                    <el-form-item
                        label="复诊日期"
                        class="right-width"
                        style="margin-left:30px"
                    >
                        <el-select
                            style="width:250px"
                            v-model="form.value"
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
                    </el-form-item>
                </div>
                <!-- ----------------亲友关系----------- -->
                <div style="display:flex">
                    <div
                        class="number"
                        style="background-color:#a6d2ff;margin-right:3px"
                    >3</div>
                    <div class="number">亲友关系</div>
                </div>
                <el-table
                    border
                    style="width: 100%"
                >
                    <el-table-column
                        prop="date"
                        label="关系"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="participant_name"
                        label="关系人姓名"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="性别"
                        width="80"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="电话"
                        width="140"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="会员等级"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="会员号"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="备注"
                        width="120"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="修改"
                        width="80"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="删除"
                    >
                    </el-table-column>
                </el-table>

            </div>

        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button
                :loading="commitLoading"
                type="primary"
            >确 定</el-button>
            <el-button @click="new_relat">新增关系</el-button>
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
// import ContactAddress from "./ContactAddress";
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
            form: {
                teethList:[
                    {
                        value:"选项1",
                        label:"不干净"
                    }
                ],
                pastMedicalhistoryList: [
                    {
                        value: "选项1",
                        label: "黄金糕"
                    }
                ],
                allergyList: [
                    {
                        value: "选项1",
                        label: "黄金糕"
                    }
                ],
                options: [
                    {
                        value: "选项1",
                        label: "黄金糕"
                    },
                    {
                        value: "选项2",
                        label: "双皮奶"
                    },
                    {
                        value: "选项3",
                        label: "蚵仔煎"
                    },
                    {
                        value: "选项4",
                        label: "龙须面"
                    },
                    {
                        value: "选项5",
                        label: "北京烤鸭"
                    }
                ],
                birthday: "",
                age: "",
                value: "",
                group:"",
                case_id: "",
                phone: "",
                sex: 2,
                name: "",
                teeth:"",
                member_gard:"",
                email:"",
                medical_record: ""
            },
            rules: {
                name: [
                    { required: true, message: "请输入姓名", trigger: "blur" }
                    // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                medical_record: [
                    { required: true, message: "请输入病历号", trigger: "blur" }
                    // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ],
                phone: [
                    { required: true, message: "请输入手机号", trigger: "blur" }
                    // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                ]
            }
        };
    },
    watch: {
        // show(newValue, oldValue) {
        //     if (newValue) {
        //         let that = this;
        //         that.getCaseNo();
        //     }
        // }
    },
    methods: {
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
        afterClose() {
            this.$refs["Modifyform"].resetFields();
        }
        //病历号获取
        // getCaseNo() {
        //     let that = this;
        //     that.$api.patient
        //         .caseNo()
        //         .then(res => {
        //             console.log(res.data);
        //             // that.form.case_id = res.data.case_id;
        //         })
        //         .catch(res => {
        //             console.log(res);
        //         });
        // }
    }
};
</script>

<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.mod-1 {
    .image {
        border: 1px solid red;
        position: absolute;
        right: 0;
        margin-right: 240px;
        width: 320px;
        height: 350px;
        // background-image:none;
        background-color: #000;
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