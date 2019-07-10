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
            ref="form"
            label-width="80px"
            :rules="rules"
            :model="form"
            class="add-patient"
        >
            <div style="display:flex">
                <el-form-item
                    label="病历号"
                    style="width:300px"
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
                    :disable="false"
                >
                    <el-input
                        @keyup.native.13="selectRowByKey(13)"
                        @keyup.native.38="selectRowByKey(38)"
                        @keyup.native.40="selectRowByKey(40)"
                        v-model="form.patient_name"
                        ref="searchInput"
                    ></el-input>
                    <!-- @keyup.native="searchAll" -->
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
            <div
                class="search-all"
                v-if="showNameSearch"
            >
                <el-table
                    :data="tableData"
                    border
                    style="width:100%"
                    height="300px"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    @row-click="selectRow"
                    ref="searchTable"
                    :row-class-name="rowClassName"
                >
                    <!-- @row-dblclick="selectRow" -->
                    <el-table-column
                        prop="patient_phone"
                        label="电话"
                        align="center"
                        width="120px"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="case_id"
                        label="病历号"
                        align="center"
                        width="120px"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="patient_name"
                        label="姓名"
                        align="center"
                        width="100px"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="appointment_doctor"
                        label="复诊医生"
                        align="center"
                        width="100px"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="appointment_date"
                        label="复诊日期"
                        align="center"
                        width="120px"
                    >
                    </el-table-column>
                </el-table>
            </div>

            <div class="patient-box">
                <div style="display:flex">
                    <el-form-item
                        label="电话"
                        prop="patient_phone"
                        class="box-phone"
                    >
                        <el-input v-model="form.patient_phone"></el-input>
                    </el-form-item>

                    <el-form-item
                        class="box-email"
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
                        class="box-birthday"
                    >
                        <el-date-picker
                            v-model="form.patient_birthday"
                            type="date"
                            placeholder="选择日期"
                            :picker-options="pickerOptions"
                            value-format="yyyy-MM-dd"
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
                        label="社保"
                        prop="society_no"
                        style="width:300px"
                    >
                        <el-input v-model="form.society_no"></el-input>
                    </el-form-item>
                    <el-form-item
                        style="margin-left:50px;width:300px"
                        label="类 别"
                        prop="type"
                    >
                        <el-radio-group v-model="form.type">
                            <el-radio :label="0">初诊</el-radio>
                            <el-radio :label="1">复诊</el-radio>
                        </el-radio-group>
                    </el-form-item>

                </div>

                <div style="display:flex">
                    <el-form-item
                        label="就诊日期"
                        prop="appointment_date"
                        style="width:300px"
                    >
                        <el-date-picker
                            v-model="form.appointment_date"
                            type="date"
                            placeholder="选择日期"
                            :picker-options="pickerOptions"
                            value-format="yyyy-MM-dd"
                        >
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item
                        label="主治医生"
                        prop="appointment_doctor"
                        style="margin-left:50px;"
                    >
                        <el-select
                            v-model="form.appointment_doctor"
                            style="width:220px"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in addPatient.attend_doctors"
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
                        label="会员等级"
                        prop="member_id"
                    >
                        <el-select
                            v-model="form.member_id"
                            style="width:220px"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in addPatient.members"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <i
                        class="el-icon-setting form-setting"
                        @click="member_manage"
                    ></i>

                    <el-form-item
                        class="box-member"
                        label="会员卡号"
                        prop="member_card"
                    >
                        <el-input
                            placeholder="默认为手机号"
                            v-model="form.member_card"
                        ></el-input>
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
                        >
                            <el-option
                                v-for="item in addPatient.categories"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
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
                        >
                            <el-option
                                v-for="item in addPatient.teeth_habits"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
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
                        <el-input
                            v-model="form.patient_address"
                            style="width:570px"
                        ></el-input>

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
                        >
                            <el-option
                                v-for="item in addPatient.allergies"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
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
                        >
                            <el-option
                                v-for="item in addPatient.anamneses"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
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

            <el-button @click="resetForm('form')">清空</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
                @click="submitFrom('form')"
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
        TeethcleaningHabits
    },

    props:{
        addPatient:{},
    },

    data() {
        return {
            category_show: false,
            member_show: false,
            allergy_show: false,
            anamnesis_show: false,
            teeth_habit_show: false,
            userimage_show: false,
            pickerOptions: {
                disabledDate: time => {
                    return time.getTime() > Date.now();
                }
            },
            tableData: [],

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
                    },
                    {
                        pattern: /^1[3|4|5|7|8|6|9][0-9]{9}$/,
                        message: "请输入正确的手机号"
                    }
                ],

                patient_email: [
                    {
                        required: true,
                        message: "请输入邮箱",
                        trigger: "blur"
                    },
                    {
                        pattern: /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/,
                        message: "请输入正确的邮箱格式"
                    }
                ],
                patient_birthday: [
                    {
                        required: true,
                        message: "请选择出生年月日",
                        trigger: "blur"
                    }
                ],
                attend_doctor: [
                    {
                        required: true,
                        message: "请选择主治医生",
                        trigger: "blur"
                    }
                ]
            },

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
                allergy: "",
                anamnesis: "",
                appointment_doctor: "",
                appointment_date: "",
                type: 0,
                society_no: ""
            },

            showNameSearch: false,
            showNameTimer: null,

            //搜索框选中
            searchSelectIdx: null,

            stopNotify: false
        };
    },

    mounted() {},

    destroyed() {},

    watch: {
        show(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.form.case_id=that.addPatient.case_id;
            }
        },
        "form.patient_birthday": {
            handler(newName, oldName) {
                if (newName) {
                    let that = this;
                    that.age();
                }
            }
        },

        "form.patient_name": {
            handler(newName, oldName) {
                let that = this;

                clearTimeout(that.showNameTimer);

                if(that.stopNotify){
                    that.stopNotify = false;
                }else if(newName){
                    that.showNameTimer = setTimeout(() => {
                        that.searchAll(newName);
                    }, 300);
                }
            }
        }
    },

    methods: {
        //搜索
        searchAll(value) {
            let that = this;

            that.searchSelectIdx = 0;

            if (value) {
                // that.showNameSearch = true;

                that.$api.patient.searchAll({ search_all: value }).then(res => {
                    if (res.code == 200 && res.data.length) {
                        that.tableData = res.data;

                        that.showNameSearch = true;

                        that.searchSelectIdx = 0;

                        document.addEventListener(
                            "keydown",
                            that.checkHideSearch
                        );
                        document.addEventListener(
                            "click",
                            that.checkHideSearch
                        );
                    }
                });
            } else {
                that.hideSearch();
            }
        },

        hideSearch() {
            let that = this;

            // that.tableData = [];

            that.showNameSearch = false;
            that.stopNotify = true;

            document.removeEventListener("keydown", that.checkHideSearch);
            document.removeEventListener("click", that.checkHideSearch);
        },

        //检查是否要关闭搜索框
        checkHideSearch(event) {
            let that = this,
                target = event.target,
                keyCode = event.keyCode || null;

            //这个是按键盘触发的
            if (keyCode) {
                if (
                    keyCode == 9 &&
                    document.activeElement != that.$refs.searchInput.$el
                ) {
                    that.hideSearch();
                }
            } else {
                //这个是鼠标触发的

                if (that.$refs.searchTable.$el.contains(target)) {
                    that.$refs.searchInput.focus();
                } else {
                    that.hideSearch();
                }
            }
        },

        rowClassName({ row, rowIndex }) {
            if (rowIndex === this.searchSelectIdx) {
                return "select-row";
            }
            return "";
        },

        selectRowByKey(key) {
            let that = this;

            switch (key) {
                case 38:
                    that.searchSelectIdx != 0 && (that.searchSelectIdx -= 1);
                    // if(that.searchSelectIdx != 0){
                    //     that.searchSelectIdx -= 1 ;
                    // }
                    break;
                case 40:
                    if (that.searchSelectIdx != that.tableData.length - 1) {
                        that.searchSelectIdx++;
                    }

                    break;
                case 13:
                    that.selectRow(that.tableData[that.searchSelectIdx]);
                    break;
            }

            that.$refs.searchInput.focus();
        },

        selectRow(row) {
            let that = this;

            that.hideSearch();
            that.form = row;
        },

        resetForm(form) {
            let that = this;
            that.$refs[form].resetFields();
        },

        age() {
            let that = this,
                age = "",
                currentTime = new Date(),
                birthTime = new Date(that.form.patient_birthday);

            age =
                currentTime.getFullYear() -
                birthTime.getFullYear() -
                (currentTime.getMonth() < birthTime.getMonth() ||
                (currentTime.getMonth() == birthTime.getMonth() &&
                    currentTime.getDate() < birthTime.getDate())
                    ? 1
                    : 0);
            that.form.patient_age = age;
        },

        submitFrom(form) {
            let that = this;
            that.$refs[form].validate(valid => {
                if (valid) {
                    that.$api.patient
                        .store(that.form)
                        .then(res => {
                            if (res.code == 200) {
                                that.$message({
                                    type: "success",
                                    message: "添加成功!"
                                });
                                that.closeDialog();
                            } else {
                                that.$message.error("添加失败");
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

    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.add-patient {
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

    .search-all {
        border: 1px solid #b9b9b9;
        height: 300px;
        width: 400px;
        margin-left: 80px;
        position: fixed;
        z-index: 99;
    }
    .patient-box {
        height: 300px;
        overflow: auto;
        border: 1px solid #e3e3e3;
        padding-top: 10px;
        .box-email {
            margin-left: 50px;
            width: 300px;
        }
        .box-phone {
            width: 300px;
        }
        .box-birthday {
            width: 300px;
        }
        .box-member {
            margin-left: 20px;
            width: 300px;
        }
    }
}
</style>