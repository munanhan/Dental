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
            :model="changePwd"
            ref="changePwdForm"
            label-width="100px"
            :rules="rules"
        >
            <div class="Advan-content">
                <div class="Advan-top">
                    <div class="advan-1"> 1503010120</div>
                    <div class="advan-1"> 5岁</div>
                    <div class="advan-2"> *(无病历号)</div>
                </div>

                <div class="Advan-bottom">
                    <table border="1">
                        <tr>
                            <td
                                align="center"
                                width="200"
                            >客户主诉</td>
                            <input>
                        </tr>
                        <tr>
                            <td align="center"> 基本需求</td>
                            <!-- <input style="width:620px"> -->
                            <el-select
                                v-model="type"
                                style="width:620px"
                            >
                                <el-option
                                    label="区域二"
                                    value="beijing"
                                >
                                    <el-checkbox v-model="checked1">备选项</el-checkbox>
                                </el-option>
                                <el-option
                                    label="区域三"
                                    value="231231"
                                >
                                    <el-checkbox v-model="checked2">备选项</el-checkbox>
                                </el-option>
                                <el-option
                                    label="区域四"
                                    value="54545"
                                >
                                    <el-checkbox v-model="checked3">备选项</el-checkbox>
                                </el-option>
                            </el-select>
                            <i
                                @click="basice_need"
                                class="el-icon-setting form-setting"
                            ></i>
                        </tr>
                        <tr>
                            <td align="center">潜在需求</td>
                            <div>
                                <input style="width:616px">
                                <i @click="potential_dem" class="el-icon-setting form-setting"></i>
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
            type: [],
            checked1: false,
            checked2: false,
            checked3: false,
            changePwd: {
                oldPass: "",
                newPass: "",
                newPassRe: ""
            },

            rules: {},

            commitLoading: false
        };
    },

    methods: {
        basice_need() {
            this.basneed_show = true;
        },
        potential_dem() {
            this.potentdeman_show = true;
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
        }
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