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
            ref="form"
            label-width="100px"
            :rules="rules"
        >
            <div class="Advan-content">
                <div class="Advan-top">
                    <div class="advan-1"> {{addConsult.patient_name}}</div>
                    <div class="advan-1"> {{addConsult.patient_age}}岁</div>
                    <div class="advan-2"> {{addConsult.case_id}}</div>
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
                                    v-model="form.main_consult"
                                ></el-input>

                            </td>
                        </tr>
                        <tr class="basic-needs">
                            <td align="center">基本需求</td>
                            <td style="background-color:white">
                                <div>
                                    <el-select
                                        class="table-select"
                                        style="width:620px;"
                                        v-model="form.base_demand"
                                        multiple
                                        filterable
                                        allow-create
                                        default-first-option
                                        @focus="getBaseDemand"
                                    >
                                        <el-option
                                            v-for="item in baseDemandList"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.name"
                                        >
                                        </el-option>
                                    </el-select>
                                    <i
                                        @click="basice_need"
                                        class="el-icon-setting form-setting"
                                    ></i>
                                </div>
                            </td>
                        </tr>
                        <tr class="potential">
                            <td align="center">潜在需求</td>
                            <td style="background-color:white">
                                <div>
                                    <el-select
                                        class="table-select"
                                        style="width:620px;"
                                        v-model="form.potential_demand"
                                        multiple
                                        filterable
                                        allow-create
                                        default-first-option
                                        @focus="getPotentialDemand"
                                    >
                                        <el-option
                                            v-for="item in potentialDemandList"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.name"
                                        >
                                        </el-option>
                                    </el-select>
                                    <i
                                        @click="potential_dem"
                                        class="el-icon-setting form-setting"
                                    ></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">医生方案</td>
                            <td>
                                <el-input
                                    class="table-input"
                                    v-model="form.doctor_solution"
                                ></el-input>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">沟通记录</td>
                            <td>
                                <el-input
                                    class="table-input"
                                    v-model="form.record"
                                ></el-input>

                            </td>
                        </tr>

                        <tr>
                            <td align="center">服务建议</td>
                            <td>
                                <el-input
                                    class="table-input"
                                    v-model="form.service_proposal"
                                ></el-input>
                            </td>
                        </tr>
                        <tr class="doctor">
                            <td align="center">接诊医生</td>
                            <el-select
                                class="table-select"
                                v-model="form.doctor"
                                placeholder="请选择"
                                style="width:664px"
                                @focus="getReceptionDoctor(1)"
                            >
                                <el-option
                                    v-for="item in doctorList"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </tr>
                        <tr class="data-entry">
                            <td align="center">资料录入人</td>
                            <el-select
                                class="table-select"
                                v-model="form.data_entry_person"
                                placeholder="请选择"
                                style="width:664px"
                                @focus="getReceptionDoctor(2)"
                            >
                                <el-option
                                    v-for="item in dataEntryPersonList"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
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
                @click="submitForm"
            >保存</el-button>
            <el-button @click="closeDialog">退出</el-button>
        </div>
        <basic-needs :show.sync="basneed_show"></basic-needs>
        <potential-demand :show.sync="potentdeman_show"></potential-demand>
    </el-dialog>
</template>

<script>
import AddDialogForm from "@/views/base/AddDialogForm";
import BasicNeeds from "./BasicNeeds";
import PotentialDemand from "./PotentialDemand";
export default {
    name: "AddConsulting",

    components: {
        BasicNeeds,
        PotentialDemand
    },
    props: {
        addConsult: {}
    },
    mixins: [AddDialogForm],

    created() {
        // let that = this;
        // that.BaseInfo = that.addConsult;
    },

    mounted() {},

    data() {
        return {
            basneed_show: false,
            potentdeman_show: false,
            dataEntryPersonList: [],
            baseDemandList: [],
            BaseInfo: [],
            doctorList: [],
            potentialDemandList: [],
            rules: {},
            form: {
                main_consult: "",
                base_demand: "",
                potential_demand: "",
                doctor_solution: "",
                record: "",
                service_proposal: "",
                doctor: "",
                data_entry_person: ""
            },
            commitLoading: false
        };
    },
    watch: {
        addConsult(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.BaseInfo = that.addConsult;
            }
        },

        show(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getDefaultRecorder();
            }
        }
    },
    methods: {
        submitForm() {
            let that = this;

            that.form["patient_id"] = that.addConsult.id;

            that.$api.patient_consult
                .store(that.form)
                .then(res => {
                    if (res.code == 200) {
                        that.$emit(
                            "add-item",
                            JSON.parse(JSON.stringify(res.data))
                        );

                        that.closeDialog();
                    } else {
                        that.$message.error(res.msg);
                    }
                })
                .catch(res => {
                    console.log(res.data);
                });
        },

        getBaseDemand() {
            let that = this;
            that.$api.base_demand
                .get()
                .then(res => {
                    that.baseDemandList = res.data;
                })
                .catch(res => {
                    console.log(res.data);
                });
        },

        getPotentialDemand() {
            let that = this;
            that.$api.potential_demand
                .get()
                .then(res => {
                    that.potentialDemandList = res.data;
                })
                .catch(res => {
                    console.log(res.data);
                });
        },

        getReceptionDoctor(type) {
            let that = this;
            that.$api.patient_consult
                .receptionDoctor()
                .then(res => {
                    if (res.code == 200) {
                        if (type == 1) {
                            that.doctorList = res.data;
                        } else {
                            that.dataEntryPersonList = res.data;
                        }
                    }
                })
                .catch(res => {
                    console.log(res.data);
                });
        },

        getDefaultRecorder() {
            let that = this;
            that.$api.patient_consult
                .defaultRecorder()
                .then(res => {
                    that.form.data_entry_person = res.data;
                })
                .catch(res => {
                    console.log(res.data);
                });
        },
        basice_need() {
            this.basneed_show = true;
        },
        potential_dem() {
            this.potentdeman_show = true;
        },

        afterClose() {
            let that = this;
            for (let key in that.form) {
                // that.form.hasOwnProperty(key)
                that.form[key] = "";
            }
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
        .basic-needs {
            .table-select {
                /deep/ .el-input__inner {
                    border: none;
                    border-radius: 0px;
                }
            }
        }
        .potential {
            .table-select {
                /deep/ .el-input__inner {
                    // border-top: none;
                    // border-left: none;
                    // border-bottom: none;
                    border: none;
                    border-radius: 0px;
                }
            }
        }
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

            .table-input {
                /deep/ .el-input__inner {
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

        .doctor {
            .table-select {
                /deep/ .el-input__inner {
                    border-right: none;
                    border-left: none;
                    border-top: none;
                    border-radius: 0px;
                }
            }
        }

        .data-entry {
            .table-select {
                /deep/ .el-input__inner {
                    // border-right: none;
                    // border-left: none;
                    // border-bottom: none;
                    border: none;
                    border-radius: 0px;
                }
            }
        }
        // .el-select {
        //     width: 664px;
        //     height: 40px;
        // }
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