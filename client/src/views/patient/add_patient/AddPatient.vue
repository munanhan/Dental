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

                <div class="block">
                    <el-button
                        round
                        style="margin-left:50px"
                    >新增头像</el-button>
                </div>

            </div>

            <div style="display:flex">
                <el-form-item
                    label="姓名"
                    style="width:300px"
                    prop="patient_name"
                >
                    <el-input v-model="form.patient_name"></el-input>
                </el-form-item>

                <div style="margin-top:10px;margin-left:50px">
                    性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <el-radio-group v-model="form.patient_sex">
                        <el-radio :label="0">男</el-radio>
                        <el-radio :label="1">女</el-radio>
                        <el-radio :label="2">未填</el-radio>
                    </el-radio-group>
                </div>

            </div>

            <div style="height:300px;overflow: auto">
                <div style="display:flex">
                    <el-form-item
                        label="电话"
                        prop="patient_phone"
                        style="width:300px"
                    >
                        <el-input v-model="form.patient_phone"></el-input>
                    </el-form-item>

                    <el-form-item
                        style="margin-left:50px;width:300px"
                        label="电子邮箱"
                        prop="patient_email"
                    >
                        <el-input v-model="form.patient_email"></el-input>

                    </el-form-item>
                </div>

                <div style="display:flex">
                    <el-form-item
                        label="出生年月"
                        prop="patient_birthday"
                        style="width:300px"
                        @input="birthday"
                        
                    >
                        <el-date-picker
                            v-model="form.patient_birthday"
                            type="date"
                            placeholder="选择日期"
                           
                        >
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item
                        style="margin-left:50px;width:300px"
                        label="年 龄"
                        prop="patient_age"
                    >
                        <el-input v-model="form.patient_age"></el-input>
                    </el-form-item>

                </div>

                <div style="display:flex">
                    <el-form-item
                        label="会员等级"
                        prop="member_level"
                    >
                        <el-select
                            v-model="form.member_id"
                            style="width:220px"
                            placeholder="请选择"
                            @focus="member"
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
                        @click="member_manage"
                    ></i>

                    <el-form-item
                        style="margin-left:20px;width:300px"
                        label="会员卡号"
                        prop="member_card"
                    >
                        <el-input v-model="form.member_card"></el-input>
                    </el-form-item>
                </div>

                <div style="display:flex">
                    <el-form-item
                        label="患者分类"
                        prop="patient_category"
                    >
                        <el-select
                            v-model="form.patient_category"
                            style="width:220px"
                            placeholder="请选择"
                            @focus="category"
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
                        @click="category_manage"
                    ></i>
                    <el-form-item
                        style="margin-left:20px;width:300px"
                        prop="patient_content"
                        label="患者备注"
                    >
                        <el-input v-model="form.patient_content"></el-input>
                    </el-form-item>

                </div>

                <div style="display:flex">
                    <el-form-item
                            label="洁牙习惯"
                            prop="teeth_habits"
                    >
                        <el-select
                                v-model="form.teeth_habits"
                                style="width:220px"
                                placeholder="请选择"
                                @focus="teethHabit"
                        >
                            <el-option
                                    v-for="item in teethHabitList"
                                    :key="item.value"
                                    :label="item.name"
                                    :value="item.name"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                            class="el-icon-setting form-setting"
                            @click="teeth_habit_manage"
                    ></i>
                    <el-form-item
                            style="margin-left:20px;width:300px"
                            prop="nation"
                            label="民 族"
                    >
                        <el-input v-model="form.nation"></el-input>
                    </el-form-item>

                </div>

                <div style="display:flex">

                </div>

                <div>
                    <el-form-item
                        autocomplete="off"
                        prop="patient_address"
                        label="联系地址"
                    >
                        <el-input v-model="form.patient_address" style="width:570px"></el-input>

                    </el-form-item>
                </div>

                <div>
                    <el-form-item
                        label="过 敏 史"
                        prop="allergy"
                    >

                        <el-select
                            v-model="form.allergy"
                            style="width:570px"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择"
                            @focus="allergy"
                        >
                            <el-option
                                v-for="item in allergyList"
                                :key="item.id"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                        <i
                            class="el-icon-setting form-setting"
                            @click="allergy_manage"
                        ></i>
                    </el-form-item>
                </div>

                <div>
                    <el-form-item
                        label="既 往 史"
                        prop="anamnesis"
                    >
                        <el-select
                            v-model="form.anamnesis"
                            style="width:570px"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择"
                            @focus="anamnesis"
                        >
                            <el-option
                                v-for="item in anamnesisList"
                                :key="item.value"
                                :label="item.name"
                                :value="item.name"
                            >
                            </el-option>
                        </el-select>
                        <i
                            class="el-icon-setting form-setting"
                            @click="anamnesis_manage"
                        ></i>
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

            <el-button>清空</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
                @click="submitFrom"
            >确 定</el-button>
            <el-button @click="closeDialog">取 消</el-button>

        </div>

        <classification-patients :show.sync="category_show"></classification-patients>
        <membership-grade :show.sync="member_show"></membership-grade>
        <allergy :show.sync="allergy_show"></allergy>
        <past-medicalhistory :show.sync="anamnesis_show"></past-medicalhistory>
        <teethcleaning-habits :show.sync="teeth_habit_show"></teethcleaning-habits>
        <!-- <user-image :show.sync="userimage_show"></user-image> -->
    </el-dialog>
</template>


<script>
import AddDialogForm from "@/views/base/AddDialogForm";

import ClassificationPatients from "./ClassificationPatients";
import MembershipGrade from "./MembershipGrade";
import Allergy from "./Allergy";
import PastMedicalhistory from "./PastMedicalhistory";

import TeethcleaningHabits from "./TeethcleaningHabits";
// import UserImage from "./UserImage";

export default {
    name: "AddPatient",

    mixins: [AddDialogForm],

    components: {
        ClassificationPatients,
        MembershipGrade,
        Allergy,
        PastMedicalhistory,
        TeethcleaningHabits,
    },

    data() {
        return {

            category_show: false,
            member_show: false,
            allergy_show: false,
            anamnesis_show: false,
            teeth_habit_show: false,
            userimage_show: false,

            categoryList: [],
            memberList: [],
            allergyList: [],
            anamnesisList: [],
            teethHabitList: [],

            form: {
                patient_birthday: "",
                patient_content: "",
                teeth_habits: "",
                patient_category: "",
                case_id: "",
                patient_name: "",
                nation: "",
                patient_sex: 2,
                patient_phone: "",
                patient_age: "",
                member_id: "",
                member_card: "",
                patient_address: "",
                patient_email: "",
                allergy:"",
                anamnesis:"",
                rules: {
                    patient_name: [
                        {
                            required: true,
                            message: "请输入姓名",
                            trigger: "blur"
                        }
                    ],

                    patient_phone: [
                        {
                            required: true,
                            message: "请输入手机号",
                            trigger: "blur"
                        }
                    ],

                    patient_email: [
                        {
                            required: true,
                            message: "请输入邮箱",
                            trigger: "blur"
                        }
                    ],
                    patient_birthday: [
                        {
                            required: true,
                            message: "请选择出生年月日",
                            trigger: "blur"
                        }
                    ],

                }
            }
        };
    },

    mounted() {

    },

    watch: {
        show(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.getCaseNo();
            }
        }
    },

    methods: {

        anamnesis(){
            let that=this;

                that.$api.anamnesis.get()
                    .then(res=>{
                        that.anamnesisList=res.data;
                    })
                    .catch(res=>{
                        console.log(res.data);
                    })
        },

        allergy(){
            let that=this;

                that.$api.allergy.get()
                    .then(res=>{
                        that.allergyList=res.data;
                    })
                    .catch(res=>{
                        console.log(res.data);
                    })

        },

        teethHabit(){
            let that=this;

                that.$api.teethHabit.get()
                    .then(res=>{
                        that.teethHabitList=res.data;
                    })
                    .catch(res=>{
                        console.log(res.data);
                    })
        },

        category(){
          let that=this;

              that.$api.category.get()
                  .then(res=>{
                      that.categoryList=res.data;
                  })
                  .catch(res=>{
                      console.log(res.data);
                  })
        },

        member(){
            let that =this;

                that.$api.patient_member.get()
                    .then(res=>{
                        that.memberList = res.data;
                    })
                    .catch(res=>{
                        console.log(res.data);
                    })
        },

        birthday(){

        },

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

        category_manage() {
            this.category_show = true;
        },

        member_manage() {
            this.member_show = true;
        },


        allergy_manage() {
            this.allergy_show = true;
        },

        anamnesis_manage() {
            this.anamnesis_show = true;
        },

        teeth_habit_manage() {
            this.teeth_habit_show = true;
        },

        getCaseNo() {
            let that = this;
            that.$api.patient
                .caseNo()
                .then(res => {
                    that.form.case_id = res.data.case_id;
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