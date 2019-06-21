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
            :rules="rules"
        >
            <div class="initDiag-content">
                <div class="left-content">
                    <div class="initDiag-upperleft">
                        <el-tabs v-model="activeName">
                            <el-tab-pane
                                label="病历模板"
                                name="medicalTemplates"
                            >
                                <div
                                    class="left-tree"
                                    style="height:250px;overflow: auto"
                                >
                                    <el-tree
                                        :data="initialData"
                                        @node-click="handleNodeClick"
                                    >
                                        <span
                                            class="custom-tree-node"
                                            slot-scope="{node, data}"
                                        >
                                            <i
                                                v-if="!node.expanded && data.type == 0"
                                                class="fa fa-folder mr-10 dir"
                                            ></i>
                                            <i
                                                v-if="node.expanded && data.type == 0"
                                                class="fa fa-folder-open mr-10 dir"
                                            ></i>
                                            <i
                                                v-if="data.type == 1"
                                                class="fa fa-file-alt mr-10 file"
                                            ></i>
                                            <span>{{ data.outline_name }}</span>
                                            <i
                                                v-if="data.type == 1"
                                                class="fa fa-caret-right mr-10 file hide "
                                            ></i>
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

                        <!-- <template v-for="item in templateContent" >
                            <div :key="item.key" v-if="item.value" style="display:flex">
                                <div class="lowerleft-left">{{item.name}}</div>
                                <div class="lowerleft-right">
                                    {{ item.value }}
                                </div>                                
                            </div>
                        </template> -->

                        <!-- <div style="display:flex">
                            <div class="lowerleft-left">{{item.name}}</div>
                            <div class="lowerleft-right">
                                {{ data[item.key] }}
                            </div>
                        </div> -->

                        <div
                            class="lowerleft-content"
                            v-if="templateContent.main_complain"
                        >
                            <div class="lowerleft-left">主诉</div>
                            <div class="lowerleft-right">
                                {{templateContent.main_complain}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.now_history"
                        >
                            <div class="lowerleft-left">现病史</div>
                            <div class="lowerleft-right">
                                {{templateContent.now_history}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.previous_history"
                        >
                            <div class="lowerleft-left">既往史</div>
                            <div class="lowerleft-right">
                                {{templateContent.previous_history}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.inspect"
                        >
                            <div class="lowerleft-left">检查</div>
                            <div class="lowerleft-right">
                                {{templateContent.inspect}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.auxiliary"
                        >
                            <div class="lowerleft-left">辅助检查</div>
                            <div class="lowerleft-right">
                                {{templateContent.auxiliary}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.diagnosis"
                        >
                            <div class="lowerleft-left">诊断</div>
                            <div class="lowerleft-right">
                                {{templateContent.diagnosis}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.treatment_plan"
                        >
                            <div class="lowerleft-left">治疗方案</div>
                            <div class="lowerleft-right">
                                {{templateContent.treatment_plan}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.treatment"
                        >
                            <div class="lowerleft-left">治疗</div>
                            <div class="lowerleft-right">
                                {{templateContent.treatment}}
                            </div>
                        </div>
                        <div
                            class="lowerleft-content"
                            v-if="templateContent.doctor_advice"
                        >
                            <div class="lowerleft-left">医嘱</div>
                            <div class="lowerleft-right">
                                {{templateContent.doctor_advice}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-content">
                    <div class="right-top">
                        <div class="top1">
                            <div class="top-num1">{{InitialDiag.case_id}}</div>
                            <div class="top-num2">{{InitialDiag.patient_age}}岁</div>
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
                        <div class="top2">
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
                                    format="yyyy-MM-dd"
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
                                    <input v-model="form.complain">
                                    <!-- <textarea style="resize:none;height:20px;margin-bottom:-2px"></textarea> -->
                                </tr>
                                <tr>
                                    <td align="center">现 病 史</td>
                                    <input v-bind="form.history">
                                    <!-- <textarea style="resize:none" ></textarea> -->
                                </tr>
                                <tr>
                                    <td align="center">既 往 史</td>
                                    <input v-model="form.previous">
                                </tr>
                                <tr>
                                    <td align="center">过 敏 史</td>
                                    <input v-model="form.allergy">
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
                                    <!-- <input class="middle-input">
                                    <i class="el-icon-delete-solid middle-i"></i>
                                    <input class="middle-input">
                                    <i class="el-icon-delete-solid middle-i"></i>
                                    <input class="middle-input">
                                    <i class="el-icon-delete-solid middle-i"></i> -->
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
                            <div class="bottom-image">
                                <div style="margin-top:10px">添加患者影像（可添加6张）</div>
                                <div class="add-image">
                                    <div class="bottom-box">
                                        <i class="fa fa-plus bottom-i"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="right-bottom">
                        <div
                            slot="footer"
                            class="dialog-footer"
                        >
                            <div class="button-conten">
                                <!-- <el-button>另存模板</el-button> -->
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
    name: "SubsequentVisit",

    mixins: [DialogForm],
    props: {
        // refresh: {
        //     type: Boolean,
        //     required: true
        // },

        addSubsequent: {
            type: Object,
            required: true
        }
    },
    created() {
        let that = this;
        that.InitialDiag = that.addSubsequent;
    },
    data() {
        return {
            selectNode: null,
            initialData: [],
            activeName: "medicalTemplates",
            rules: {},
            templateContent: [],
            InitialDiag: [],
            form: {
                value1: new Date(),
                radio: "2",
                checked: "",
                complain: "",
                history: "",
                previous: "",
                allergy: ""

                // defaultProps: {
                //   children: "children",
                //   label: "label"
                // },
            },

            data: {}
        };
    },
    watch: {
        // refresh(newValue, oldValue) {
        //     let that = this;

        //     if (newValue) {
        //         that.resizeContent();
        //     }
        // },
        addSubsequent(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.InitialDiag = that.addSubsequent;
            }
        },
        activeName(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.activeName = newValue;
            }
        },
        show(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.getMenu();
            }
        },

        selectType(newValue, oldValue) {
            let that = this;
            // if (newValue) {
            that.selectGetData(newValue);
            // }
        }
    },
    methods: {
        getMenu() {
            //获取菜单
            let that = this;
            that.$api.patient_case_template
                .index()
                .then(res => {
                    that.initialData = res.data;
                })
                .catch(res => {});
        },
        handleNodeClick(data) {
            let that = this;
            that.selectNode = data;

            if (data.type == 0) {
                that.menu_id = 0;
                that.selectStatus = "none";
            } else {
                that.menu_id = that.selectNode.id;
                that.selectGetData(that.activeName);
                that.selectStatus = "block";
            }
            // //设置选中的id
            // that.selectID = data.id;
        },
        selectGetData(option) {
            let that = this;
            if (that.selectNode != null && that.selectNode.type == 1) {
                switch (option) {
                    case "medicalTemplates":
                        that.getCaseData(
                            "patient_case_template",
                            "templateContent"
                        );
                        // that.caseShow = true;
                        break;
                    // case 1:
                    //     that.getData("medical", "medicalData", "medicalShow");
                    //     break;
                }
            }
        },
        getCaseData(apiType, dataType) {
            //主数据
            let that = this;
            let menu_id = that.selectNode.id;
            that.$api[apiType]
                .show({ menu_id: menu_id })
                .then(res => {
                    if (res.code == 200) {
                        that[dataType] = res.data;

                        // for (var i = 0; i < that.templateContent.length; i++) {
                        //     var item = that.templateContent[i];
                        //     item.value = res.data[item.key] || "";
                        // }

                        // for(var i = 0; i < that.templateContent.length; i++){
                        //     var item = that.templateContent[i];
                        //     item.value = "";
                        // }
                    } else {
                        that.$message.error(res.msg || "数据获取失败.");
                    }
                })
                .catch(res => {});
        }

        // setData(data){

        //     { aa : '' }
        //     { }

        //         for(var i = 0; i < that.templateContent.length; i++){
        //             var item = that.templateContent[i];
        //             item.value = res.data[item.key] || '';
        //         }
        // }
    }
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
            height: 293px;
            .left-tree {
                .custom-tree-node {
                    // border: 1px solid #ccc;
                    width: 100%;
                    &:hover .file {
                        background-color: #e0ffd6;
                    }
                    .dir {
                        color: #ffd000;
                    }
                    .hide {
                        position: absolute;
                        right: 0;
                        margin-top: -14px;
                        color: #000;
                        display: none;
                    }
                    &:hover .hide {
                        display: block;
                    }
                    .file {
                        color: #4f94cd;
                    }
                }
            }
        }
        .initDiag-lowerleft {
            margin-top: 5px;
            border: 1px solid #cacaca;
            overflow: auto;
            height: 300px;
            width: 400px;
            .lowerleft-content {
                cursor: pointer;
                // border: 1px solid red;
                display: flex;
                .lowerleft-left {
                    // border: 1px solid #000;
                    // cursor: pointer;
                    color: #f7a325;
                    width: 60px;
                    margin-left: 5px;
                    margin-top: 10px;
                    // border: none;
                    height: 31px;
                    // overflow: auto;
                }
                .lowerleft-right {
                    // border: 1px solid red;
                    margin-right: 5px;
                    margin-top: 10px;
                    flex: 1;
                    color: #000;
                    margin-left: 10px;
                    margin-bottom: 10px;
                }
                &:hover {
                    .lowerleft-left {
                        text-decoration: underline;
                    }
                    text-decoration: underline;
                }
            }
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
            .top1 {
                display: flex;
                font-size: 15px;
                .top-num1 {
                    margin-left: 8px;
                    margin-top: 13px;
                    margin-right: 10px;
                }
                .top-num2 {
                    margin-top: 13px;
                }
            }
            .top2 {
                display: flex;
            }
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
                height: 360px;
                overflow: auto;
                margin-top: 5px;
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
        .bottom-image {
            // border: 1px solid red;
            background-color: white;
            height: 160px;
            .add-image {
                margin-bottom: 20px;
                margin-top: 20px;
                margin-left: 10px;
                .bottom-box {
                    border: 1px solid #afafaf;
                    cursor: pointer;
                    height: 100px;
                    width: 100px;
                    .bottom-i {
                        color: #949494;
                        font-size: 25px;
                        padding-top: 35px;
                        padding-left: 40px;
                    }
                }
                :hover {
                    background-color: #dbdbdb;
                }
            }
        }
        .right-bottom {
            border: 1px solid #e6e6e6;
            border-top: none;
            height: 67px;
            .button-conten {
                margin-top: 10px;
                margin-left: 5px;
            }
        }
    }
    /deep/ .el-tabs__nav-scroll {
        margin-left: 10px;
    }
}
</style>