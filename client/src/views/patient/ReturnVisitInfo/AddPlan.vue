<template>
    <el-dialog
        title="回访计划"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        center
        top="1vh"
        width="1000px"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
        >
            <!-- <el-form-item label="活动名称">
    <el-input></el-input>
  </el-form-item> -->
            <div class="plan-content">
                <div class="plan-top">
                    <div class="number">{{PlanInfo.patient_name}} </div>
                    <div class="top-font">| {{PlanInfo.case_id}} |</div>
                    <div class="top-font"> {{PlanInfo.patient_age}}岁 |</div>
                    <div class="top-font"> {{PlanInfo.patient_phone}}</div>
                </div>
                <div class="plan-middle-content">
                    <div class="plan-middle">
                        <el-form-item
                            size="small"
                            label="回访计划"
                            style="margin-top:10px"
                        >
                            <el-select
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
                            @click="returnvis_setup"
                        ></i>
                        <div class="middle-num">(使用提示：勾选表格中事项并编辑行！)</div>
                    </div>
                    <div style="height:300px;margin-top:-10px">
                        <el-table
                            border
                            ref="multipleTable"
                            :data="form.tableData"
                            tooltip-effect="dark"
                            style="height:300px"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                type="selection"
                                width="55"
                            >
                            </el-table-column>
                            <el-table-column
                                label="定时天数"
                                width="120"
                            >
                                <template slot-scope="scope">{{ scope.row.date }}</template>
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="回访事项"
                                width="120"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="address"
                                label="回访结果"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                        </el-table>
                    </div>
                </div>
                <div class="plan-bottom">
                    <div style="display:flex">
                        <el-form-item
                            size="small"
                            label="主治医生"
                            style="margin-top:10px"
                        >
                            <el-select
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
                    <div style="border:1px solid #e3e3e3;height:180px;margin-top:-10px;background:rgb(246, 246, 246)">
                        <div style="margin-left:10px;margin-top:10px">
                            其他计划
                        </div>
                        <el-form-item
                            label="主治医生"
                            style="margin-top:10px"
                        >
                            <el-select
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
                            label="回访事项"
                            style="margin-top:-10px"
                        >
                            <el-input style="width:850px"></el-input>
                        </el-form-item>
                        <el-form-item
                            label="回访结果"
                            style="margin-top:-15px"
                        >
                            <el-input style="margin-top:-50px;width:850px"></el-input>
                        </el-form-item>
                    </div>
                    <el-form-item
                        size="small"
                        label="回访人员"
                        style="margin-top:10px"
                    >
                        <el-select
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
            </div>
        </el-form>

        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button type="primary">确 定</el-button>
        </div>
        <return-visit-setup :show.sync="returnvisset_show"></return-visit-setup>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import ReturnVisitSetup from "./ReturnVisitSetup";
export default {
    name: "AddPlan",
    props: {
        // refresh: {
        //     type: Boolean,
        //     required: true
        // },

        addPlan: {
            // type: Object,
            required: true
        }
    },
    mixins: [DialogForm],

    components: {
        ReturnVisitSetup
    },

    created() {
        let that = this;
        that.PlanInfo = that.addPlan;
    },
    data() {
        return {
            returnvisset_show: false,
            PlanInfo: [],
            form: {
                tableData: [
                    {
                        date: "1",
                        name: "隔日回访",
                        address: ""
                    },
                    {
                        date: "2",
                        name: "三日后回访",
                        address: ""
                    },
                    {
                        date: "3",
                        name: "一周后回访",
                        address: ""
                    },
                    {
                        date: "4",
                        name: "一个月后回访",
                        address: ""
                    },
                    {
                        date: "5",
                        name: "半年后回访",
                        address: ""
                    }
                ],
                multipleSelection: [],
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
                value: ""
            }
        };
    },
    watch: {
        addPlan(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.PlanInfo = that.addPlan;
            }
        }
    },
    methods: {
        returnvis_setup() {
            this.returnvisset_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
@import "~@css/var";
.plan-content {
    font-size: 15px;
    .plan-top {
        display: flex;
        // margin-top: 10px;
        width: 100%;
        height: 40px;
        background-color: #f9f9f9;
        border: 1px solid #f6f6f6;
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
    .plan-middle-content {
        //   border:1px solid red;
        .plan-middle {
            display: flex;
            .form-setting {
                text-align: right;
                width: 30px;
                font-size: 22px;
                margin-top: 15px;
                cursor: pointer;

                &:hover {
                    color: @color;
                }
            }
            .middle-num {
                margin-top: 16px;
                margin-left: 200px;
            }
        }
    }
    .plan-bottom {
    }
}
</style>