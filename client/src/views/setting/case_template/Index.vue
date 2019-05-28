<template>
    <div class="case-template">
        <div class="left-container">
            <div class="actions">
                <span class="mr-20">大纲目录</span>
                <i
                    class="el-icon-share mr-20"
                    title="新增节点"
                    @click.stop.prevent="addTreeNodeDialog = true"
                ></i>
                <i
                    class="el-icon-edit mr-20"
                    title="修改"
                    @click.stop.prevent="showEditNode"
                ></i>
                <i
                    class="el-icon-delete"
                    title="删除节点"
                    @click.stop.prevent="removeNode"
                ></i>
            </div>
            <div>
                <el-tree
                    :data="templateData"
                    node-key="id"
                    :props="treeProps"
                    :highlight-current="!!selectNode"
                    ref="templateTree"
                    @node-click="handleNodeClick"
                >
                    <span
                        class="custom-tree-node"
                        slot-scope="{node, data}"
                    >
                        <i
                            v-if="!node.expanded && data.children && data.children.length"
                            class="fa fa-folder mr-10 dir"
                        ></i>
                        <i
                            v-if="node.expanded && data.children && data.children.length"
                            class="fa fa-folder-open mr-10 dir"
                        ></i>
                        <i
                            v-if="!data.children"
                            class="fa fa-file-alt mr-10 file"
                        ></i>
                        <span>{{ node.label }}</span>
                    </span>
                </el-tree>

            </div>
        </div>
        <div
            class="right-container"
            ref="right"
        >
            <div
                class="type-select-container"
                ref="rightTitle"
            >
                <el-radio-group v-model="selectType">
                    <el-radio-button :label="0">模板</el-radio-button>
                    <el-radio-button :label="1">主诉、现病史、既往病史</el-radio-button>
                    <el-radio-button :label="2">检查、辅助检查</el-radio-button>
                    <el-radio-button :label="3">诊断</el-radio-button>
                    <el-radio-button :label="4">治疗、治疗方案</el-radio-button>
                    <el-radio-button :label="5">医嘱</el-radio-button>
                </el-radio-group>
            </div>

            <div :style="{
                    height: `${rightContentHeight}px`
                }"
                class="content"
                >
                <case-template
                    v-show="selectType == 0"
                    :data="caseData"
                    :show.sync="caseShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                ></case-template>

                <medical-history
                    v-show="selectType == 1"
                    :data="medicalData"
                    :show.sync="medicalShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                ></medical-history>
                <inspect
                    v-show="selectType == 2"
                    :data="inspectData"
                    :show.sync="inspectShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                ></inspect>

                <diagnose
                    v-show="selectType == 3"
                    :data="diagnoseData"
                    :show.sync="diagnoseShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                >
                </diagnose>

                <treat
                    v-show="selectType == 4"
                    :data="treatData"
                    :show.sync="treatShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                >
                </treat>

                <advice
                    v-show="selectType == 5"
                    :data="adviceData"
                    :show.sync="adviceShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                >
                </advice>
            </div>
        </div>

        <add-tree-node
            :show.sync="addTreeNodeDialog"
            @add-item="addNode"
        ></add-tree-node>

        <edit-tree-node
            :show.sync="editTreeNodeDialog"
            :editItem="currentEditItem"
            @edit-item="eidtNode"
        ></edit-tree-node>
    </div>
</template>

<script>
import AddTreeNode from "./AddTreeNode";
import EditTreeNode from "./EditTreeNode";
import CaseTemplate from "./template/CaseTemplate";
import MedicalHistory from "./mediacal_history/MedicalHistory";
import Inspect from "./inspect/Inspect";
import Diagnose from "./diagnose/Diagnose";
import Treat from "./treat/Treat";
import Advice from "./advice/Advice";

export default {
    name: "CaseTemplateIndex",
    components: {
        AddTreeNode,
        EditTreeNode,
        CaseTemplate, //病历模板
        MedicalHistory, //主诉、现病史、既往病史
        Inspect, //检查
        Diagnose, //诊断
        Treat, //治疗、治疗方案
        Advice //医嘱
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            templateData: [
                {
                    id: 0,
                    text: 1111,
                    type: 1,
                    children: [{ id: 1, text: 22222, type: 2 }]
                }
            ],

            treeProps: {
                label: "text",
                children: "children"
            },

            addTreeNodeDialog: false,
            editTreeNodeDialog: false,

            selectNode: null,

            currentEditItem: {},

            selectType: 0,

            rightContentHeight: 500,
            rightContentWidth: 400,

            caseData: {}, //模板
            medicalData: {}, //病历
            inspectData: {}, //检查
            diagnoseData: {}, //诊断
            treatData: {}, //治疗、治疗方案
            adviceData: {}, //医嘱咐

            //用户处理每个模块里面表格的高度
            caseShow: false,
            medicalShow: false,
            inspectShow: false,
            diagnoseShow: false,
            treatShow: false,
            adviceShow: false
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            window.addEventListener("click", that.removeSelect);

            //监听事件,由layout那边的resize抛出的
            window.addEventListener("bodyChange", that.resizeContent);
        });
    },

    destroyed() {
        window.removeEventListener("click", this.removeSelect);
    },

    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeContent();
            }
        },

        selectType(newValue, oldValue) {
            let that = this;

            switch (newValue) {
                case 0:
                    that.caseShow = true;
                    break;
                case 1:
                    that.medicalShow = true;
                    break;
                case 2:
                    that.inspectShow = true;
                    break;
                case 3:
                    that.diagnoseShow = true;
                    break;
                case 4:
                    that.treatShow = true;
                    break;
                case 5:
                    that.adviceShow = true;
                    break;
            }
        }
    },
    computed: {},
    methods: {
        resizeContent() {
            let that = this,
                height =
                    that.$refs.right.clientHeight -
                    that.$refs.rightTitle.clientHeight -
                    20;

            that.rightContentHeight = height;
            that.rightContentWidth = that.$refs.right.clientWidth;
        },

        removeSelect() {
            let that = this;
            that.selectNode = null;
        },

        handleNodeClick(data) {
            let that = this;

            that.selectNode = data;
            // //设置选中的id
            // that.selectID = data.id;
        },

        showEditNode() {
            let that = this;

            if (that.selectNode) {
                that.editTreeNodeDialog = true;

                //获取数据, 然后弹窗
            } else {
                that.$message.error("请选择修改的节点");
            }
        },

        //新增节点
        addNode(value) {
            let that = this;
            console.log(that.selectNode);
            console.log(value);
        },

        eidtNode(value) {},

        //删除节点
        removeNode() {
            let that = this;

            if (that.selectNode) {
                that.$refs.templateTree.remove(that.selectNode);
                console.log(that.selectNode);
            } else {
                that.$message.error("请选择删除的节点");
            }
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.case-template {
    display: flex;
    height: 100%;

    .left-container {
        width: 250px;
        border-right: 1px solid #e3e3e3;

        .actions {
            padding: 8px;
            font-size: 22px;
            box-sizing: border-box;
            border-bottom: 1px solid #e3e3e3;

            i {
                cursor: pointer;
                .transition-2;

                &:hover {
                    color: @hover-color;
                }
            }
        }

        .custom-tree-node {
            .dir {
                color: #f4a460;
            }

            .file {
                color: #4f94cd;
            }
        }

        /deep/ .el-tree-node:focus > .el-tree-node__content {
            background-color: @linght-background-color;
        }

        /deep/ .el-tree-node__content:hover {
            background-color: @linght-background-color;
        }

        /deep/.el-tree--highlight-current
            .el-tree-node.is-current
            > .el-tree-node__content {
            background-color: @linght-background-color;
        }
    }

    .right-container {
        flex: 1;
        overflow: auto;

        .type-select-container {
            margin: 10px;
        }

        .content{
            height: 100%;
            overflow: hidden;
        }
    }
}
</style>