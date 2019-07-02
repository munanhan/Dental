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
            ref="initialform"
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
                                <div class="medical-tree">
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
                                                class="fa fa-caret-right mr-10 filel hide "
                                                @click.stop="pat_table(data)"
                                            ></i>
                                        </span>
                                    </el-tree>
                                </div>

                                <div class="initDiag-lowerleft">
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.main_complain"
                                        @click="transmission('complains', templateContent.main_complain)"
                                    >
                                        <div class="lowerleft-left">主诉</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.main_complain}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.now_history"
                                        @click="transmission('nows', templateContent.now_history)"
                                    >
                                        <div class="lowerleft-left">现病史</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.now_history}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.previous_history"
                                        @click="transmission('ccccc', templateContent.previous_history)"
                                    >
                                        <div class="lowerleft-left">既往史</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.previous_history}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.inspect"
                                        @click="transmission('ddddd', templateContent.inspect)"
                                    >
                                        <div class="lowerleft-left">检查</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.inspect}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.auxiliary"
                                        @click="transmission('eeeee', templateContent.auxiliary)"
                                    >
                                        <div class="lowerleft-left">辅助检查</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.auxiliary}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.diagnosis"
                                        @click="transmission('fffff', templateContent.diagnosis)"
                                    >
                                        <div class="lowerleft-left">诊断</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.diagnosis}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.treatment_plan"
                                        @click="transmission('ggggg', templateContent.treatment_plan)"
                                    >
                                        <div class="lowerleft-left">治疗方案</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.treatment_plan}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.treatment"
                                        @click="transmission('hhhhh', templateContent.treatment)"
                                    >
                                        <div class="lowerleft-left">治疗</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.treatment}}
                                        </div>
                                    </div>
                                    <div
                                        class="lowerleft-content"
                                        v-if="templateContent.doctor_advice"
                                        @click="transmission('iiiii', templateContent.doctor_advice)"
                                    >
                                        <div class="lowerleft-left">医嘱</div>
                                        <div class="lowerleft-right">
                                            {{templateContent.doctor_advice}}
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>

                            <el-tab-pane
                                label="病历词条"
                                name="entry"
                                class="entry-content"
                            >

                                <el-button
                                    class="entry-button"
                                    @click="selectEntryStatus = !selectEntryStatus"
                                >口腔内科</el-button>
                                <div
                                    class="entry-tree"
                                    v-if="!selectEntryStatus"
                                >

                                    <el-tree
                                        :data="medicalRecordEntryData"
                                        @node-click="handleEntryClick"
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
                                                class="fa fa-caret-right mr-10 filel hide "
                                                @click.stop="pat_table(data)"
                                            ></i>
                                        </span>
                                    </el-tree>
                                </div>
                                <div
                                    class="entry-info"
                                    v-else
                                >
                                    <div class="entry-box-top">
                                        <div class="top-left">
                                            <div class="left-top">
                                                <div class="left-top1">部位</div>
                                                <i class="el-icon-setting form-setting"></i>
                                            </div>

                                            <!-- <div
                                                class="lowerleft-content"
                                                v-if="templateContent.main_complain"
                                                @click="transmission('complains', templateContent.main_complain)"
                                            >
                                                <div class="lowerleft-left">主诉</div>
                                                <div class="lowerleft-right">
                                                    {{templateContent.main_complain}}
                                                </div>
                                            </div> -->
                                            <div class="left-bottom">
                                                <div
                                                    class="item"
                                                    v-for="(item,key) in partsEntryData"
                                                    :key="key"
                                                    @click="parts_table(item)"
                                                >
                                                    <span>{{item}}</span>
                                                    <i
                                                        class="fa fa-caret-right mr-10 filel hide "
                                                        @click.stop="parts_table(item)"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="top-left">
                                            <div class="left-top">
                                                <div class="left-top1">性质</div>
                                                <i class="el-icon-setting form-setting"></i>
                                            </div>
                                            <div class="left-bottom">
                                                <div
                                                    class="item"
                                                    v-for="(item,key) in propertiesData"
                                                    :key="key"
                                                >
                                                    <span>{{item}}</span>
                                                    <i
                                                        class="fa fa-caret-right mr-10 filel hide "
                                                        @click.stop="parts_table(item)"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="entry-box-top">
                                        <div class="top-left">
                                            <div class="left-top">
                                                <div class="left-top1">时间</div>
                                                <i class="el-icon-setting form-setting"></i>
                                            </div>
                                            <div class="left-bottom">
                                                <div
                                                    class="item"
                                                    v-for="(item,key) in timeData"
                                                    :key="key"
                                                >
                                                    <span>{{item}}</span>
                                                    <i
                                                        class="fa fa-caret-right mr-10 filel hide "
                                                        @click.stop="parts_table(item)"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="top-left">
                                            <div class="left-top">
                                                <div class="left-top1">其他</div>
                                                <i class="el-icon-setting form-setting"></i>
                                            </div>
                                            <div class="left-bottom">
                                                <div
                                                    class="item"
                                                    v-for="(item,key) in timeData"
                                                    :key="key"
                                                >
                                                    <span>{{item}}</span>
                                                    <i
                                                        class="fa fa-caret-right mr-10 filel hide "
                                                        @click.stop="parts_table(item)"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </div>

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

                </div>
                <div class="right-content">
                    <div class="right-top">
                        <div class="top1">
                            <div class="top-num1">{{InitialDiag.case_id}}</div>
                            <div class="top-num2">{{InitialDiag.patient_age}}岁</div>
                            <el-form-item
                                class=""
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
                            <!-- <el-checkbox
                                class="middle-checkbox"
                                v-model="form.checked"
                            ><span style="font-size:15px;color:#000">牙位同步</span></el-checkbox> -->
                        </div>
                        <div class="middle-table">
                            <table border="1">
                                <tr>
                                    <td align="center">主 诉</td>
                                    <input v-model="form.complain">
                                    <!-- @blur="" -->
                                    <!-- <textarea style="resize:none;height:20px;margin-bottom:-2px"></textarea> -->
                                </tr>
                                <tr>
                                    <td align="center">现 病 史</td>
                                    <input v-model="form.history">
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
                                    <template v-for="(item,index) in form.check">
                                        <input
                                            v-model="form.check[index]"
                                            class="middle-input"
                                            :key="index"
                                        >
                                        <i
                                            v-if="index == 0"
                                            @click="addDisposal('check')"
                                            class="el-icon-circle-plus-outline middle-i"
                                            :key="'icon'+index"
                                        ></i>
                                        <i
                                            v-else
                                            class="fa fa-trash-alt middle-i"
                                            @click="delDisposal('check')"
                                            :key="'icon'+index"
                                        ></i>

                                        <!-- <input
                                                :key="index"
                                                :v-model="form.check[index+1]"
                                                class="middle-input"
                                            > -->

                                    </template>

                                </tr>
                                <tr>
                                    <td align="center">辅助检查</td>
                                    <template v-for="(item,index) in form.auxiliarycheck">
                                        <input
                                            v-model="form.auxiliarycheck[index]"
                                            class="middle-input"
                                            :key="index"
                                        >
                                        <i
                                            v-if="index == 0"
                                            @click="addDisposal('auxiliarycheck')"
                                            class="el-icon-circle-plus-outline middle-i"
                                            :key="'icon'+index"
                                        ></i>
                                        <i
                                            v-else
                                            class="fa fa-trash-alt middle-i"
                                            @click="delDisposal('auxiliarycheck')"
                                            :key="'icon'+index"
                                        ></i>
                                    </template>
                                </tr>

                                <tr>
                                    <td align="center">诊 断</td>
                                    <template v-for="(item,index) in form.diagnosi">
                                        <input
                                            v-model="form.diagnosi[index]"
                                            class="middle-input"
                                            :key="index"
                                        >
                                        <i
                                            v-if="index == 0"
                                            @click="addDisposal('diagnosi')"
                                            class="el-icon-circle-plus-outline middle-i"
                                            :key="'icon'+index"
                                        ></i>
                                        <i
                                            v-else
                                            class="fa fa-trash-alt middle-i"
                                            @click="delDisposal('diagnosi')"
                                            :key="'icon'+index"
                                        ></i>
                                    </template>
                                </tr>

                                <tr>
                                    <td align="center">治疗方案</td>
                                    <template v-for="(item,index) in form.treatmentOptions">
                                        <input
                                            v-model="form.treatmentOptions[index]"
                                            class="middle-input"
                                            :key="index"
                                        >
                                        <i
                                            v-if="index == 0"
                                            @click="addDisposal('treatmentOptions')"
                                            class="el-icon-circle-plus-outline middle-i"
                                            :key="'icon'+index"
                                        ></i>
                                        <i
                                            v-else
                                            class="fa fa-trash-alt middle-i"
                                            @click="delDisposal('treatmentOptions')"
                                            :key="'icon'+index"
                                        ></i>
                                    </template>

                                    <!-- <input
                                        v-model="form.treatmentOptions"
                                        class="middle-input"
                                    >
                                    <i class="el-icon-circle-plus-outline middle-i"></i> -->
                                </tr>
                                <tr>
                                    <td align="center">治 疗</td>
                                    <!-- <input
                                        v-model="form.treatment"
                                        class="middle-input"
                                    >
                                    <i class="el-icon-circle-plus-outline middle-i"></i> -->
                                    <template v-for="(item,index) in form.treatment">
                                        <input
                                            v-model="form.treatment[index]"
                                            class="middle-input"
                                            :key="index"
                                        >
                                        <i
                                            v-if="index == 0"
                                            @click="addDisposal('treatment')"
                                            class="el-icon-circle-plus-outline middle-i"
                                            :key="'icon'+index"
                                        ></i>
                                        <i
                                            v-else
                                            class="fa fa-trash-alt middle-i"
                                            @click="delDisposal('treatment')"
                                            :key="'icon'+index"
                                        ></i>
                                    </template>
                                </tr>
                                <tr>
                                    <td align="center">医 嘱</td>
                                    <input
                                        v-model="form.advice"
                                        style="height:35px"
                                    >
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
    name: "InitialDiagnosis",

    mixins: [DialogForm],
    props: {
        // refresh: {
        //     type: Boolean,
        //     required: true
        // },

        addInitial: {
            //  type: Object,
            required: true
        }
    },
    created() {
        let that = this;
        that.InitialDiag = that.addInitial;
    },
    data() {
        return {
            selectNode: null,
            initialData: [],
            medicalRecordEntryData: [
                {
                    type: 0,
                    outline_name: "口腔内科",
                    children: [
                        {
                            type: 1,
                            outline_name: "粘膜病"
                        },
                        {
                            type: 1,
                            outline_name: "牙周炎"
                        }
                    ]
                },
                {
                    type: 0,
                    outline_name: "口腔外科",
                    children: [
                        {
                            type: 1,
                            outline_name: "粘膜病1"
                        },
                        {
                            type: 1,
                            outline_name: "牙周炎1"
                        }
                    ]
                }
            ],
            partsEntryData: ["前牙", "后牙", "左上", "右上", "左下", "右下"],
            propertiesData: ["咬物松动", "要求检查", "疼痛", "牙龈红肿"],
            timeData: ["前牙", "后牙"],
            selectEntryStatus: false,
            activeName: "medicalTemplates",
            rules: {},
            templateContent: [],
            InitialDiag: [],
            // initals: [''],
            form: {
                value1: new Date(),
                radio: "1",
                check: [""],
                complain: "",
                history: "",
                previous: "",
                allergy: "",
                treatment: [""],
                auxiliarycheck: [""],
                diagnosi: [""],
                treatmentOptions: [""],
                advice: ""

                // defaultProps: {
                //   children: "children",
                //   label: "label"
                // },
            },

            data: {}

            // aaa: []
        };
    },
    watch: {
        // refresh(newValue, oldValue) {
        //     let that = this;

        //     if (newValue) {
        //         that.resizeContent();
        //     }
        // },
        addInitial(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.InitialDiag = that.addInitial;
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
                // taht.getEntryMenu();
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
        //箭头
        pat_table(data) {
            let that = this;
            that.getCaseData("patient_case_template", "templateContent", data);
            // that.form.complain = value;
        },
        parts_table(data) {
            console.log(data);
        },
        afterClose() {
            this.templateContent = [];
            // let that = this;
            // for (let key in that.form) {
            //     that.form[key] = "";
            // }
        },

        addDisposal(value) {
            let that = this;
            switch (value) {
                case "check":
                    this.form.check.push("");
                    break;
                case "auxiliarycheck":
                    this.form.auxiliarycheck.push("");
                    break;
                case "diagnosi":
                    this.form.diagnosi.push("");
                    break;
                case "treatmentOptions":
                    this.form.treatmentOptions.push("");
                    break;
                case "treatment":
                    this.form.treatment.push("");
                    break;
            }
        },

        delDisposal(index, value) {
            // console.log(this.form.check);
            switch (index) {
                case "check":
                    this.form.check.splice(index - 1, 1);
                    break;
                case "auxiliarycheck":
                    this.form.auxiliarycheck.splice(index, 1);
                    break;
                case "diagnosi":
                    this.form.diagnosi.splice(index, 1);
                    break;
                case "treatmentOptions":
                    this.form.treatmentOptions.splice(index, 1);
                    break;
                case "treatment":
                    this.form.treatment.splice(index, 1);
                    break;
            }
            ``;
        },

        // afterClose() {

        //     this.$refs["initialform"].resetFields();
        // },
        // getEntryMenu() {
        //     let that = this;
        //     that.$api.patient_case_template
        //         .index()
        //         .then(res => {
        //             that.medicalRecordEntryData = res.data;
        //         })
        //         .catch(res => {});
        // },

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

        handleEntryClick(data) {
            data.type == 1 ? (this.selectEntryStatus = true) : null;
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

        getCaseData(apiType, dataType, selectNode = "") {
            //主数据
            let that = this;
            let menu_id = selectNode == "" ? that.selectNode.id : selectNode.id;
            that.$api[apiType]
                .show({ menu_id: menu_id })
                .then(res => {
                    if (res.code == 200) {
                        that[dataType] = res.data;
                        if (selectNode != "") {
                            that.form.check[0] = that.templateContent.inspect;
                            that.form.complain =
                                that.templateContent.main_complain;
                            that.form.history =
                                that.templateContent.now_history;
                            that.form.previous =
                                that.templateContent.previous_history;
                            that.form.treatment[0] =
                                that.templateContent.treatment;
                            that.form.auxiliarycheck[0] =
                                that.templateContent.auxiliary;
                            that.form.diagnosi[0] =
                                that.templateContent.diagnosis;
                            that.form.treatmentOptions[0] =
                                that.templateContent.treatment_plan;
                            that.form.advice =
                                that.templateContent.doctor_advice;
                        }
                    } else {
                        that.$message.error(res.msg || "数据获取失败.");
                    }
                })
                .catch(res => {});
        },

        transmission(type, value) {
            let that = this;
            switch (type) {
                case "complains":
                    that.form.complain = value;
                    break;
                case "nows":
                    that.form.history = value;
                    break;
                case "ccccc":
                    that.form.previous = value;
                    break;
                case "ddddd":
                    that.form.check = [value];
                    // console.log(that.form.$set)
                    // that.$set('form.check', '0', v   alue);
                    break;
                case "eeeee":
                    that.form.auxiliarycheck = [value];
                    break;
                case "fffff":
                    that.form.diagnosi = [value];
                    break;
                case "ggggg":
                    that.form.treatmentOptions = [value];
                    break;
                case "hhhhh":
                    that.form.treatment = [value];
                    break;
                case "iiiii":
                    that.form.advice = value;
                    break;
            }
        }
    }
};
</script>
<style lang="less" scoped>
@import "~@css/var";
.initDiag-content {
    // border: 1px solid red;
    height: 600px;
    width: 1000px;

    display: flex;
    .left-content {
        // border: 1px solid red;
        height: 600px;
        .initDiag-upperleft {
            border: 1px solid #cacaca;
            position: relative;
            width: 400px;
            height: 600px;
            .medical-tree {
                height: 250px;
                border-bottom: 1px solid #cacaca;
                margin-bottom: 5px;
                overflow: auto;
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
                    .filel {
                        color: #949494;
                        cursor: pointer;
                        font-size: 18px;
                    }
                }
            }
            .initDiag-lowerleft {
                margin-top: 5px;
                // border: 1px solid #cacaca;
                // border-bottom:none;
                border-top: 1px solid #cacaca;
                overflow: auto;
                height: 305px;
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

            .entry-content {
                .entry-button {
                    width: 100%;
                    margin-bottom: 5px;
                }
                .entry-tree {
                    height: 600px;
                    // border-bottom: 1px solid #cacaca;
                    overflow: auto;
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
                        .filel {
                            color: #949494;
                            cursor: pointer;
                            font-size: 18px;
                        }
                    }
                }
                .entry-info {
                    .entry-box-top {
                        display: flex;
                        margin-left: 3px;
                        height: 255px;
                        margin-bottom: 3px;
                        .top-left {
                            border: 1px solid #e7e7e7;
                            margin-right: 5px;
                            .left-top {
                                .left-top1 {
                                    flex: 1;
                                }
                                display: flex;
                                color: #000;
                                font-size: 15px;
                                margin-left: 5px;
                                .form-setting {
                                    text-align: right;
                                    margin-top: 2px;
                                    font-size: 15px;
                                    cursor: pointer;
                                    text-align: right;
                                    margin-right: 3px;
                                    &:hover {
                                        color: @color;
                                    }
                                }
                            }
                            .left-bottom {
                                margin-top: 2px;
                                margin-bottom: 5px;
                                border: 1px solid #949393;
                                height: 230px;
                                margin: 2px;
                                width: 187px;
                                // .item:nth-of-type(2n) {
                                //     width: 45%;
                                //     text-overflow: ellipsis;
                                //     white-space: nowrap;
                                //     float: right;
                                //     // border:1px solid red;
                                //     cursor: pointer;
                                //     &:hover {
                                //         background-color: #98ff79;
                                //     }
                                //     span {
                                //         display: inline-block;
                                //         margin-right: 10px;
                                //     }
                                //     i {
                                //         display: none;
                                //         // border: 1px solid red;
                                //     }
                                //     &:hover i {
                                //         display: inline-block;
                                //         padding-left: 35px;
                                //         margin-right: 0px;
                                //         text-align: right;
                                //     }
                                // }
                                .item {
                                    width: 50%;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                    float: right;
                                    // border:1px solid red;
                                    cursor: pointer;
                                    &:hover {
                                        background-color: #98ff79;
                                    }
                                    span {
                                        display: inline-block;
                                        margin-right: 10px;
                                    }
                                    i {
                                        display: none;
                                        // border: 1px solid red;
                                    }
                                    &:hover i {
                                        display: inline-block;
                                        // padding-left: 35px;
                                        // margin-right: 0px;
                                        // text-align: right;
                                    }
                                }
                                .item {
                                    width: 50%;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                    float: left;
                                    // border:1px solid red;
                                    cursor: pointer;
                                    &:hover {
                                        background-color: #98ff79;
                                    }

                                    i {
                                        // border: 1px solid red;
                                        margin-top: 2px;
                                        display: none;
                                    }
                                    &:hover i {
                                        // display: inline-block;
                                        // padding-left: 35px;
                                        // margin-right: 0;
                                        float: right;
                                    }
                                }
                                // .bottom-left {
                                //     width: 93px;
                                //     cursor: pointer;
                                //     height: 20px;
                                //     font-size: 15px;
                                //     &:hover {
                                //         background-color: #e4f7cc;
                                //     }
                                // }
                                // .bottom-right {
                                //     width: 93px;
                                //     cursor: pointer;
                                //     height: 20px;
                                //     font-size: 15px;
                                //     &:hover {
                                //         background-color: #e4f7cc;
                                //     }
                                // }
                            }
                        }
                    }
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
                        // transition: all 0.2s;
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
/deep/ .el-textarea__inner {
    border-radius: 0;
    border: none;
    resize: none;
}
</style>