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
                            prop="handler"
                        >
                            <el-select
                                v-model="form.handler"
                                collapse-tags
                                class="width100"
                            >
                                <el-option
                                    v-for="item in handlingList"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="负责人"
                            prop="charge_person"
                        >
                            <el-input
                                v-model.trim="form.charge_person"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="支出类别"
                            prop="expenditure_type"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.expenditure_type"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in expenditureCategory"
                                        :key="item.id"
                                        :label="item.expenditure_type"
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
                            prop="expenditure_content"
                        >
                            <el-input
                                v-model="form.expenditure_content"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="支出金额"
                            prop="expenditure_money"
                        >
                            <el-input-number
                                v-model="form.expenditure_money"
                                controls-position="right"
                                class="width100"
                            ></el-input-number>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="付款方式"
                            prop="expenditure_method"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.expenditure_method"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in payType"
                                        :key="item.id"
                                        :label="item.expenditure_method"
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
                    @click="addData"
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
import AddDialogForm from "../base/AddDialogForm";
import ExpenditureCategory from "./ExpenditureCategory";
import PayType from "./PayType";

export default {
    name: "AddExpenditure",
    mixins: [AddDialogForm],

    components: { ExpenditureCategory, PayType },

    props: {},
    data() {
        return {
            // commitLoading: false,
            apiType:'expenditure',

            form: {
                date: new Date(),
                handler: undefined,
                charge_person:'',
                remark: "",
                expenditure_money: 0,
                expenditure_type: "",
                expenditure_method: "",
                expenditure_content:'',
            },
            formRules: {
                date: [
                    {
                        required: true,
                        message: "请输入发生日期",
                        trigger: "blur"
                    }
                ],
                handler: [
                    {
                        required: true,
                        message: "请输入经手人",
                        trigger: "blur"
                    }
                ],
                expenditure_method: [
                    {
                        required: true,
                        message: "请输入付款方式",
                        trigger: "blur"
                    }
                ],
                amount: [
                    {
                        required: true,
                        message: "请输入支出金额",
                        trigger: "blur"
                    }
                ],
                expenditure_type: [
                    {
                        required: true,
                        message: "请输入支出类别",
                        trigger: "blur"
                    }
                ]
            },

            handlingList: [],

            payType: [],

            expenditureCategory: [],

            expenditureCategoryDialog: false,
            payTypeDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue,oldValue){
            if (newValue) {
                let that = this;
                that.$api.expenditure.getSelect()
                    .then(res => {
                        that.handlingList = res.data.user;
                        that.expenditureCategory = res.data.expenditure_type;
                        that.payType = res.data.expenditure_method;

                    })
                    .catch(res => {
                       // console.log(res);
                    });
            }
        }
    },
    computed: {},
    methods: {

        updateCategroy(list) {
            let that = this;
            that.expenditureCategory = list;
        },

        updatePayType(list) {
            let that = this;
            that.payType = list;
        },

        addData(){
            let that = this;
            that.form.date = typeof that.form.date == 'object'?that.form.date.toLocaleDateString():that.form.date;
            that.addCommit();
        }
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