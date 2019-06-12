<template>
    <el-dialog
        title="咨询信息"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="800px"
    >
        <el-form
            :model="form"
            ref="ConsultForm"
            label-width="100px"
            :rules="form.rules"
        >
            <div class="Advan-content">
                <div
                    v-for="(item,index) in form.consultings"
                    :key="index"
                    class="Advan-top"
                >
                    <div class="advan-1"> {{item.case_id}}</div>
                    <div class="advan-1"> {{item.age}}岁</div>
                    <div class="advan-2"> {{item.medical}}</div>
                </div>

                <div class="Advan-bottom">
                    <table border="1">
                        <tr>
                            <td
                                align="center"
                                width="200"
                            >客户主诉</td>

                            <td>
                                <el-input
                                    class="table-input"
                                    v-model="input"
                                    placeholder="请输入内容"
                                ></el-input>

                            </td>
                        </tr>
                        <tr>
                            <td align="center">基本需求</td>
                            <div>
                                <el-select
                                    style="width:620px;"
                                    v-model="form.value"
                                    multiple
                                    filterable
                                    allow-create
                                    default-first-option
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
                                <i
                                    @click="basice_need"
                                    class="el-icon-setting form-setting"
                                ></i>
                            </div>
                        </tr>
                        <tr>
                            <td
                                align="center"
                                prop=""
                            >潜在需求</td>
                            <div>
                                <el-select
                                    style="
                                           border:none;
                                           width:620px"
                                    v-model="form.value1"
                                    multiple
                                    filterable
                                    allow-create
                                    default-first-option
                                    placeholder="请选择"
                                >
                                    <el-option
                                        v-for="item in form.qianzai"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                                <i
                                    @click="potential_dem"
                                    class="el-icon-setting form-setting"
                                ></i>
                            </div>
                        </tr>
                        <tr>
                            <td align="center">医生方案</td>
                            <input>
                        </tr>
                        <tr>
                            <td align="center">沟通记录</td>
                            <input>
                        </tr>
                        <tr>
                            <td align="center">服务建议</td>
                            <input>
                        </tr>
                        <tr>
                            <td align="center">接诊医生</td>
                            <select>
                                <option> </option>
                                <option>222</option>
                                <option>333</option>
                            </select>
                        </tr>
                        <tr>
                            <td align="center">资料录入人</td>
                            <select style="width:664px">
                                <option> </option>
                                <option>222</option>
                                <option>333</option>
                            </select>
                        </tr>
                    </table>
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
            >保存</el-button>
            <el-button @click="closeDialog">退出</el-button>
        </div>
        <basic-needs :show.sync="basneed_show"></basic-needs>
        <potential-demand :show.sync="potentdeman_show"></potential-demand>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import BasicNeeds from "./BasicNeeds";
import PotentialDemand from "./PotentialDemand";
export default {
    name: "AddConsulting",

    components: {
        BasicNeeds,
        PotentialDemand
    },

    mixins: [DialogForm],

    data() {
        return {
            basneed_show: false,
            potentdeman_show: false,
            form: {
                consultings: [
                    {
                        case_id: "钟先生",
                        age: "10",
                        medical: "1503010120"
                    }
                ],
                type: [],
                // sad: "",
                qianzai: [
                    {
                        value: "HTML",
                        label: "HTML"
                    },
                    {
                        value: "CSS",
                        label: "CSS"
                    }
                ],
                options: [
                    {
                        value: "HTML",
                        label: "HTML"
                    },
                    {
                        value: "CSS",
                        label: "CSS"
                    },
                    {
                        value: "JavaScript",
                        label: "JavaScript"
                    }
                ],
                value: [],
                rules: {}
            },
            commitLoading: false
        };
    },

    methods: {
        basice_need() {
            this.basneed_show = true;
        },
        potential_dem() {
            this.potentdeman_show = true;
        },
        afterClose() {
            this.$refs["ConsultForm"].resetFields();
        }
    }
};
</script>
<style lang="less" scoped>
@import "~@css/var";
.Advan-content {
    .Advan-top {
        display: flex;
        margin-bottom: 10px;
        border: 1px solid red;
        font-size: 15px;
        width: 100%;
        height: 40px;
        background-color: #f9f9f9;
        border: 1px solid #f6f6f6;
        .advan-1 {
            margin: 0 20px;
            margin-top: 10px;
        }
        .advan-2 {
            margin-top: 10px;
        }
    }
    .Advan-bottom {
        // border:1px solid red;
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid #e3e3e3;
        }
        tr {
            font-size: 16px;
        }
        td {
            padding: 0;
            background-color: #f8f8f8;

            .table-input{
                /deep/ .el-input__inner{
                    border: none;
                    border-radius: 0;
                }
            }
        }

        // .aaa{
        //     display: flex;

        //     .left{
        //         flex: 1;
        //     }

        //     .icon{
        //         width: 100px;
        //     }
        // }

        input {
            width: 660px;
            height: 40px;
        }
        select {
            width: 664px;
            height: 40px;
        }
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