<template>
    <el-dialog
        title="初诊"
        :visible.sync="show"
        :before-close="closeDialog"
        :close-on-click-modal="false"
        class="custom-dialog"
        v-dialog-drag
        width="1100px"
        top="2vh"
    >
        <el-form
            ref="form"
            :model="form"
            label-width="80px"
            :rules="form.rules"
        >
            <div class="initDiag-content">
                <div class="left-content">
                    <div class="initDiag-upperleft">
                        <el-tabs v-model="form.activeName">
                            <el-tab-pane
                                label="病历模板"
                                name="medicalTemplates"
                            >
                                <div
                                    class="left-tree"
                                    style="height:300px;overflow: auto"
                                >
                                    <el-tree :data="form.initialData">
                                        <span
                                            class="custom-tree-node"
                                            slot-scope="{node, data}"
                                        >
                                            <i
                                                v-if="!node.expanded && data.children && data.children.length"
                                                class="fa fa-folder"
                                            ></i>
                                            <i
                                                v-if="node.expanded && data.children && data.children.length"
                                                class="fa fa-folder-open"
                                            ></i>
                                            <i
                                                v-if="!data.children"
                                                class="fa fa-folder"
                                            ></i>
                                            <span>{{ node.label }}</span>
                                        </span>

                                    </el-tree>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane
                                label="病历词条"
                                name="second"
                            >
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                    <div class="initDiag-lowerleft">

                    </div>
                </div>
                <div class="right-content">
                    <div class="right-top">
                        <div style="display:flex;font-size:15px">
                            <div style="margin-left:8px;margin-top:13px;margin-right:10px">1503010120</div>
                            <div style="margin-top:13px">8岁</div>
                            <el-form-item
                                style="margin-top:5px;margin-left:30px"
                                label="活动名称"
                                size="small"
                            >
                                <el-input style="width:120px"></el-input>
                            </el-form-item>
                            <div style="margin-top:10px;margin-left:10px">
                                <el-radio
                                    v-model="form.radio"
                                    label="1"
                                >初诊</el-radio>
                                <el-radio
                                    style="margin-left:-20px"
                                    v-model="form.radio"
                                    label="2"
                                >复诊</el-radio>
                            </div>
                        </div>
                        <div style="display:flex">
                            <el-form-item
                                label="检查医生:"
                                size="small"
                            >
                                <el-select
                                    style="width:120px"
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
                                style="margin-left:-20px"
                                label="护士:"
                                size="small"
                            >
                                <el-select
                                    style="width:120px"
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
                                label="就诊日期:"
                                size="small"
                            >
                                <el-date-picker
                                    style="width:180px"
                                    format="yyyy-MM-dd hh:mm"
                                    v-model="form.value1"
                                    type="date"
                                    placeholder="选择日期"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="right-middle">
                        <div style="display:flex">
                            <el-button class="middle-button">Ω特殊符号</el-button>
                            <el-checkbox
                                class="middle-checkbox"
                                v-model="form.checked"
                            ><span style="font-size:15px;color:#000">牙位同步</span></el-checkbox>
                        </div>
                        <div class="middle-table">
                            <table border="1">
                                <tr>
                                    <td align="center">主 诉</td>
                                    <input>
                                    <!-- <textarea style="resize:none;height:20px;margin-bottom:-2px"></textarea> -->
                                </tr>
                                <tr>
                                    <td align="center">现 病 史</td>
                                    <input>
                                    <!-- <textarea style="resize:none" ></textarea> -->
                                </tr>
                                <tr>
                                    <td align="center">既 往 史</td>
                                    <input>
                                </tr>
                                <tr>
                                    <td align="center">过 敏 史</td>
                                    <input>
                                </tr>
                                <tr>
                                    <td align="center">检 查</td>
                                    <input class="middle-input">
                                    <i class="el-icon-circle-plus-outline middle-i"></i>
                                </tr>
                                <tr>
                                    <td align="center">主页检查</td>
                                    <input class="middle-input">
                                    <i class="el-icon-circle-plus-outline middle-i"></i>
                                </tr>
                                <tr>
                                    <td align="center">诊 断</td>
                                    <input class="middle-input">
                                    <i class="el-icon-circle-plus-outline middle-i"></i>
                                </tr>
                                <tr>
                                    <td align="center">治疗方案</td>
                                    <input class="middle-input">
                                    <i class="el-icon-circle-plus-outline middle-i"></i>
                                </tr>
                                <tr>
                                    <td align="center">治疗</td>
                                    <input class="middle-input">
                                    <i class="el-icon-circle-plus-outline middle-i"></i>
                                </tr>
                                <tr>
                                    <td align="center">医嘱</td>
                                    <input style="height:35px">
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="right-bottom">
                        <div
                            slot="footer"
                            class="dialog-footer"
                        >
                            <div style="margin-top:10px;margin-left:5px">
                                <el-button>另存模板</el-button>
                                <el-button>预约</el-button>
                                <el-button>回访</el-button>
                                <el-button type="primary">确 定</el-button>
                                <el-button @click="closeDialog">退出</el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-form>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "InitialDiagnosis",

    mixins: [DialogForm],

    data() {
        return {
            form: {
                value1: "",
                radio: "1",
                checked: "",
                activeName: "medicalTemplates",
                initialData: [
                    {
                        label: "口腔内科",
                        children: [
                            {
                                label: "牙周炎",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            },
                            {
                                label: "黏膜病",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            },
                            {
                                label: "牙髓炎",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        label: "口腔外科",
                        children: [
                            {
                                label: "二级 1-1",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        label: "口腔修复科",
                        children: [
                            {
                                label: "二级 1-1",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        label: "口腔正畸科",
                        children: [
                            {
                                label: "二级 1-1",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        label: "口腔种植科",
                        children: [
                            {
                                label: "二级 1-1",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        label: "预防保健科",
                        children: [
                            {
                                label: "二级 1-1",
                                children: [
                                    {
                                        label: "三级 1-1-1"
                                    }
                                ]
                            }
                        ]
                    }
                ],
                // defaultProps: {
                //   children: "children",
                //   label: "label"
                // },
                rules: {}
            }
        };
    },

    methods: {}
};
</script>
<style lang="less" scoped>
.initDiag-content {
    // border: 1px solid red;
    height: 600px;
    width: 1000px;
    display: flex;
    .left-content {
        height: 600px;
        .initDiag-upperleft {
            border: 1px solid #cacaca;
            position: relative;
            width: 400px;
            height: 350px;
        }
        .initDiag-lowerleft {
            margin-top: 5px;
            border: 1px solid #cacaca;
            height: 242px;
        }
    }
    .right-content {
        // border: 1px solid red;
        background-color: #f9f9f9;
        position: absolute;
        right: 0;
        width: 650px;
        margin-right: 20px;
        height: 600px;
        .right-top {
            height: 120px;
            border: 1px solid #e6e6e6;
        }
        .right-middle {
            border: 1px solid #e6e6e6;
            border-top: none;
            height: 410px;
            .middle-button {
                margin-top: 2px;
                margin-left: 2px;
            }
            .middle-checkbox {
                margin-top: 10px;
                margin-left: 450px;
            }
            .middle-table {
                margin-top: 5px;
                margin-left: 2px;
                .middle-input {
                    width: 490px;
                }
                .middle-i {
                    font-size: 23px;
                    margin-left: 3px;
                    cursor: pointer;
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
                width: 120px;
                background-color: #f8f8f8;
            }
            input {
                width: 520px;
                height: 30px;
                // border: 1px solid red;
                &:hover {
                    background-color: #98ff79;
                    // border:1px solid rgb(0, 255, 34);
                }
            }
            select {
                width: 664px;
                height: 40px;
            }
        }
        .right-bottom {
            border: 1px solid #e6e6e6;
            border-top: none;
            height: 67px;
        }
    }
    /deep/ .el-tabs__nav-scroll {
        margin-left: 10px;
    }
}
</style>