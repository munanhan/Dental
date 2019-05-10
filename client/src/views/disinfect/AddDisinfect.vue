<template>
    <div>
        <el-dialog
            title="新增消毒"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog add-disinfect-dialog"
            :close-on-click-modal="false"
            v-dialog-drag
        >
            <el-row class="disinfect-tip">
                录入日期: 2019-05-10 | 录入人： root
            </el-row>

            <el-form
                :model="form"
                :rules="formRules"
                label-width="100px"
                ref="form"
            >
                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="类型"
                            prop="type"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.type"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in typeList"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    class="el-icon-setting form-setting"
                                    @click.stop="typeDialog = true"
                                ></i>
                            </div>
                        </el-form-item>
                    </el-col>

                    <el-col :span="12">
                        <el-form-item
                            label="消毒方式"
                            prop="disinfect"
                        >
                            <div class="sub-form-item">
                                <el-select
                                    v-model="form.disinfect"
                                    collapse-tags
                                    class="width100"
                                >
                                    <el-option
                                        v-for="item in disinfectList"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    class="el-icon-setting form-setting"
                                    @click.stop="disinfectTypeDialog = true"
                                ></i>
                            </div>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item
                    label="主题"
                    prop="subject"
                >
                    <div class="sub-form-item">
                        <el-input
                            v-model.trim="form.subject"
                            autocomplete="off"
                        ></el-input>

                        <i
                            class="el-icon-setting form-setting"
                            @click.stop="subjectDialog = true"
                        ></i>
                    </div>
                </el-form-item>

                <div>
                    <el-form-item
                        label="描述"
                        prop="remark"
                    >
                        <el-input
                            type="textarea"
                            v-model.trim="form.remark"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                </div>

                <el-row>
                    <el-col :span="12">
                        <el-form-item
                            label="消毒日期"
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

                    <el-col :span="12">
                        <el-form-item
                            label="消毒人员"
                            prop="disinfectPerson"
                        >
                            <el-select
                                v-model="form.disinfectPerson"
                                collapse-tags
                                class="width100"
                            >
                                <el-option
                                    v-for="item in userList"
                                    :key="item.id"
                                    :label="item.label"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
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

        <type
            :show.sync="typeDialog"
            @update-type="updateType"
        ></type>

        <disinfect-type
            :show.sync="disinfectTypeDialog"
            @update-type="updateDisinfectType"
        ></disinfect-type>

        <subject
            :show.sync="subjectDialog"
            @update-type="updateSubject"
        ></subject>
    </div>
</template>

<script>
import DialogForm from "../base/DialogForm";
import Type from "./Type";
import DisinfectType from "./DisinfectType";
import Subject from "./Subject";

export default {
    name: "AddDisinfect",
    mixins: [DialogForm],
    components: { Type, DisinfectType, Subject },
    props: {},
    data() {
        return {
            commitLoading: false,

            form: {
                type: "",
                disinfect: "",
                subject: "",
                date: new Date(),
                disinfectPerson: ""
            },
            formRules: {
                type: [
                    {
                        required: true,
                        message: "请输入支出类别",
                        trigger: "blur"
                    }
                ],
                disinfect: [
                    {
                        required: true,
                        message: "请输入消毒方式",
                        trigger: "blur"
                    }
                ],

                disinfectPerson: [
                    {
                        required: true,
                        message: "请输入支出类别",
                        trigger: "blur"
                    }
                ]
            },

            typeList: [{ id: 0, label: "状态1" }, { id: 1, label: "状态2" }],

            disinfectList: [
                { id: 0, label: "状态1" },
                { id: 1, label: "状态2" }
            ],

            userList: [],

            typeDialog: false,
            disinfectTypeDialog: false,
            subjectDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        addCommit() {},

        updateType() {},
        updateDisinfectType() {},

        updateSubject() {}
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.add-disinfect-dialog {
    .disinfect-tip {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 20px;
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
    }
}
</style>