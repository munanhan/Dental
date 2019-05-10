<template>
    <div>
        <el-dialog
            title="新增费用支出"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog pay-dialog"
            :close-on-click-modal="false"
            v-dialog-drag
        >
            <el-form
                :model="form"
                :rules="formRules"
                label-width="100px"
                ref="form"
            >
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="发生日期"
                            prop="date"
                        >
                            <el-date-picker
                                v-model="form.date"
                                type="date"
                                format="yyyy-MM-dd"
                                value-format="yyyy-MM-dd"
                                :clearable="false"
                                class="width100"
                            >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="经手人"
                            prop="handling"
                        >
                            <el-select
                                v-model="form.handling"
                                collapse-tags
                                class="width100"
                            >
                                <el-option
                                    v-for="item in handlingList"
                                    :key="item.id"
                                    :label="item.label"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="负责人"
                            prop="phone"
                        >
                            <el-input
                                v-model.trim="form.phone"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="支出类别"
                            prop="expenditure_category"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.expenditure_category"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in expenditureCategory"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    class="el-icon-setting form-setting"
                                    @click.stop="expenditureCategoryDialog = true"
                                ></i>
                            </div>

                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="支出明细"
                            prop="expenditure_details"
                        >
                            <el-input
                                v-model="form.expenditure_details"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="支出金额"
                            prop="amount"
                        >
                            <el-input-number
                                v-model="form.amount"
                                controls-position="right"
                                class="width100"
                            ></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="付款方式"
                            prop="pay_type"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.pay_type"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in payType"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    class="el-icon-setting form-setting"
                                    @click.stop="payTypeDialog = true"
                                ></i>
                            </div>

                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item
                    label="备注"
                    prop="remark"
                >
                    <el-input
                        v-model="form.remark"
                        autocomplete="off"
                    ></el-input>
                </el-form-item>
            </el-form>
            <div
                slot="footer"
                class="dialog-footer"
            >
                <el-button
                    @click="closeDialog"
                    :disabled="commitLoading"
                >取 消</el-button>
                <el-button
                    type="primary"
                    @click="addCommit"
                    :loading="commitLoading"
                >确 定</el-button>
                <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
            </div>
        </el-dialog>

        <expenditure-category
            :show.sync="expenditureCategoryDialog"
            @update-category="updateCategroy"
        ></expenditure-category>
        <pay-type
            :show.sync="payTypeDialog"
            @update-pay-type="updatePayType"
        ></pay-type>
    </div>
</template>

<script>
import DialogForm from "../base/DialogForm";
import ExpenditureCategory from "./ExpenditureCategory";
import PayType from "./PayType";

export default {
    name: "PayDailog",
    mixins: [DialogForm],

    components: { ExpenditureCategory, PayType },

    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                date: new Date(),
                pay_type: "",
                remark: "",
                amount: 0,
                expenditure_category: "",
                expenditure_details: ""
            },
            formRules: {
                date: [
                    {
                        required: true
                    }
                ],
                handling: [
                    {
                        required: true
                    }
                ],
                pay_type: [
                    {
                        required: true
                    }
                ],
                amount: [
                    {
                        required: true
                    }
                ],
                expenditure_category: [
                    {
                        required: true
                    }
                ]
            },

            handlingList: [{ id: 0, label: "小李" }, { id: 1, label: "小张" }],

            payType: [{ id: 1, label: "现金" }, { id: 2, label: "转账" }],

            expenditureCategory: [
                { id: 1, label: "房租水电" },
                { id: 2, label: "工资奖金" },
                { id: 3, label: "药品耗材" },
                { id: 4, label: "外加工费用" }
            ],

            expenditureCategoryDialog: false,
            payTypeDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        addCommit() {},

        updateCategroy(list) {},

        updatePayType(list) {}
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.pay-dialog {
    .sub-form-item {
        display: flex;

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
}
</style>