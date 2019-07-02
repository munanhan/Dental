<template>
    <el-dialog
        title="新增回访"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="600px"
        top="2vh"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
        >
            <div class="visit-content">
                <div class="visit-top">
                    <div style="display:flex;font-size:16px;">
                        <div class="number">{{Return_visit.patient_name}} </div>
                        <div class="top-font"> {{Return_visit.patient_sex}} </div>
                        <div class="top-font"> {{Return_visit.case_id}} </div>
                        <div class="top-font"> {{Return_visit.patient_age}}岁 </div>
                        <div class="top-font"> {{Return_visit.patient_phone}}</div>
                    </div>
                </div>
                <div class="visit-bottom">
                    <el-form-item
                        style="padding-top:10px"
                        label="回访时间"
                    >
                        <el-date-picker
                            v-model="form.visit_time"
                            type="date"
                            placeholder="选择日期"
                        >
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item label="回访人员">
                        <el-select
                            style="width:220px"
                            v-model="form.review_staff"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in form.reviewStaffList"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="主治医生">
                        <el-select
                            style="width:220px"
                            v-model="form.attend_doctor"
                            placeholder="请选择"
                        >
                            <el-option
                                v-for="item in form.attendDoctorList"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <div style="margin-left:12px">
                        回访状态
                        <el-radio-group v-model="form.status">
                            <el-radio :label="0">已回访</el-radio>
                            <el-radio :label="1">做计划</el-radio>
                            <el-radio :label="2">待跟进</el-radio>
                        </el-radio-group>
                    </div>

                    <el-form-item
                        style="margin-top:20px"
                        label="回访内容"
                    >
                        <input>
                        <!-- <el-input style="height:20px;width:470px"></el-input> -->
                    </el-form-item>
                    <el-form-item
                        style="margin-top:20px"
                        label="回访结果"
                    >
                        <input style="height:50px;width:470px">
                    </el-form-item>
                </div>
            </div>

        </el-form>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button
                type="primary"
                @click.stop.prevent="commit"
            >确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddReturnVisit",
    mixins: [DialogForm],
    props: {
        // refresh: {
        //     type: Boolean,
        //     required: true
        // },

        addReturnVisit: {
            //type: Object,
            required: true
        }
    },

    created() {
        let that = this;
        that.Return_visit = that.addReturnVisit;
    },

    data() {
        return {
            Return_visit: [],

            reviewStaffList: [],

            attendDoctorList: [],

            form: {
                visit_time: "",
                review_staff: "",
                attend_doctor: "",
                status: 0,
                review_content: "",
                review_result: ""
            }
        };
    },

    watch: {
        addReturnVisit(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.Return_visit = that.addReturnVisit;
            }
        }
    },

    methods: {
        commit() {
            let that = this;

            that.$emit("update", {});
        }
    }
};
</script>
<style lang="less" scoped>
.visit-content {
    .visit-top {
        height: 50px;
        width: 100%;
        margin-bottom: 10px;
        background-color: #fafafa;
        border: 1px solid #e2e2e2;
        .number {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            margin-left: 20px;
        }
        .top-font {
            margin-top: 12px;
            margin-left: 10px;
        }
    }
    .visit-bottom {
        background-color: #fafafa;
        border: 1px solid #e2e2e2;
        // border: 1px solid red;
        padding-bottom: 30px;
        input {
            height: 50px;
            width: 470px;
            margin-top: 13px;
        }
    }
}
</style>