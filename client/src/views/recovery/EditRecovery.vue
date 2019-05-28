<template>
    <div>
        <el-dialog
            title="修改回收"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog recovery-dialog"
            :close-on-click-modal="false"
            v-dialog-drag
        >
            <el-form
                :model="form"
                :rules="formRules"
                label-width="100px"
                ref="form"
            >
                <el-row
                    :gutter="20"
                    class="mb-10"
                >
                    <el-col :span="12">
                        <div class="item-block">
                            <span class="block-title">感染性废物</span>

                            <el-form-item
                                label="体积"
                                prop="infectious_waste_bulk"
                            >
                                <div class="sub-form-item">
                                    <el-input-number
                                        v-model="form.infectious_waste_bulk"
                                        controls-position="right"
                                        :min="0"
                                    ></el-input-number>

                                    <div class="form-setting-text">
                                        桶
                                    </div>
                                </div>

                            </el-form-item>
                            <el-form-item
                                label="重量"
                                prop="infectious_waste_weight"
                            >
                                <div class="sub-form-item">

                                    <el-input-number
                                        v-model="form.infectious_waste_weight"
                                        controls-position="right"
                                        :min="0"
                                    ></el-input-number>

                                    <div class="form-setting-text">
                                        KG
                                    </div>
                                </div>
                            </el-form-item>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <div class="item-block">
                            <span class="block-title">损伤性废物</span>

                            <el-form-item
                                label="体积"
                                prop="harm_waste_bulk"
                            >
                                <div class="sub-form-item">

                                    <el-input-number
                                        v-model="form.harm_waste_bulk"
                                        controls-position="right"
                                        :min="0"
                                    ></el-input-number>

                                    <div class="form-setting-text">
                                        桶
                                    </div>
                                </div>
                            </el-form-item>
                            <el-form-item
                                label="重量"
                                prop="harm_waste_weight"
                            >
                                <div class="sub-form-item">

                                    <el-input-number
                                        v-model="form.harm_waste_weight"
                                        controls-position="right"
                                        :min="0"
                                    ></el-input-number>

                                    <div class="form-setting-text">
                                        KG
                                    </div>
                                </div>
                            </el-form-item>
                        </div>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item
                            label="交接人"
                            prop="handover"
                        >
                            <el-select
                                v-model="form.handover"
                                collapse-tags
                                class="width100"
                            >
                                <el-option
                                    v-for="item in handoverList"
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
                            label="运送人"
                            prop="carrier"
                        >
                            <el-input
                                v-model="form.carrier"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item
                            label="交接时间"
                            prop="date"
                        >
                            <el-date-picker
                                v-model="form.date"
                                type="date"
                                format="yyyy-MM-dd hh:mm"
                                value-format="yyyy-MM-dd hh:mm"
                                :clearable="false"
                                class="width100"
                            >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                            label="处置单位"
                            prop="disposal_unit"
                        >

                            <div class="sub-form-item">

                                <el-select
                                    v-model="form.disposal_unit"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in disposalUnitList"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    class="el-icon-setting form-setting"
                                    @click.stop="disposalUnitDialog = true"
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
                        type="textarea"
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
                    @click="editCommit"
                    :loading="commitLoading"
                >确 定</el-button>
            </div>
        </el-dialog>

        <disposal-unit
            :show.sync="disposalUnitDialog"
            @update-unit="updateDisposalUnit"
        ></disposal-unit>
    </div>
</template>

<script>
import EditDialogForm from "../base/EditDialogForm";
import DisposalUnit from "./DisposalUnit";

export default {
    name: "EditRecovery",
    mixins: [EditDialogForm],

    components: {DisposalUnit},
    props: {},
    data() {
        return {
            form: {
                infectious_waste_bulk: 0,
                infectious_waste_weight: 0,
                harm_waste_bulk: 0,
                harm_waste_weight: 0,
                date: new Date(),
                handover: "",
                carrier: "",
                disposal_unit: "",
                remark: ""
            },

            formRules: {
                handover: [
                    {
                        required: true,
                        message: "请输入交接人",
                        trigger: "blur"
                    }
                ],
                disposal_unit: [
                    {
                        required: true,
                        message: "请输入处置单位",
                        trigger: "blur"
                    }
                ]
            },

            handoverList: [{ id: 0, label: "小李" }, { id: 1, label: "小张" }],

            disposalUnitList: [
                { id: 0, label: "单位1" },
                { id: 1, label: "单位2" }
            ],

            disposalUnitDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        updateDisposalUnit(list) {}
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.recovery-dialog {
    /deep/ .el-dialog__body {
        padding-bottom: 0;
    }

    .item-block {
        border: 1px solid #e3e3e3;
        position: relative;
        padding-top: 20px;

        .block-title {
            padding: 0 6px;
            position: absolute;
            left: 10px;
            top: -8px;
            background-color: white;
        }
    }

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

        .form-setting-text {
            text-align: left;
            width: 50px;
            margin-left: 10px;
        }
    }
}
</style>