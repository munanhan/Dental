<template>
    <div class="case-template">
        <div class="left-container">
            <div class="actions">
                <span class="mr-14">大纲目录</span>
                <i
                    class="el-icon-circle-plus-outline mr-14"
                    title="新增目录"
                    @click.stop.prevent="addDirDialog = true"
                ></i>
                <i
                    class="el-icon-share mr-14"
                    title="新增节点"
                    @click.stop.prevent="showAddNode"
                ></i>
                <i
                    class="el-icon-edit mr-14"
                    title="修改"
                    @click.stop.prevent="showEditNode"
                ></i>
                <i
                    class="el-icon-delete"
                    title="删除节点"
                    @click.stop.prevent="showDelNode"
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

            <div
                :style="{
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
                    :selectStatus="selectStatus"
                ></case-template>

                <medical-history
                    v-show="selectType == 1"
                    :data="medicalData"
                    :show.sync="medicalShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                    :selectStatus="selectStatus"
                ></medical-history>
                <inspect
                    v-show="selectType == 2"
                    :data="inspectData"
                    :show.sync="inspectShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                    :selectStatus="selectStatus"
                ></inspect>

                <diagnose
                    v-show="selectType == 3"
                    :data="diagnoseData"
                    :show.sync="diagnoseShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                    :selectStatus="selectStatus"
                >
                </diagnose>

                <treat
                    v-show="selectType == 4"
                    :data="treatData"
                    :show.sync="treatShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                    :selectStatus="selectStatus"
                >
                </treat>

                <advice
                    v-show="selectType == 5"
                    :data="adviceData"
                    :show.sync="adviceShow"
                    :height="rightContentHeight"
                    :width="rightContentWidth"
                    :selectStatus="selectStatus"
                >
                </advice>
            </div>
        </div>

        <add-dir
            :show.sync="addDirDialog"
            @add-item="addNode"
        ></add-dir>

        <add-tree-node
            :show.sync="addTreeNodeDialog"
            :selectNode="selectNode"
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
import AddDir from "./AddDir";
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
        AddDir,
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

            ],

            treeProps: {
                label: "text",
                children: "children"
            },

            addTreeNodeDialog: false,
            editTreeNodeDialog: false,
            addDirDialog: false,

            selectStatus:'none',

            selectNode: null,

            currentEditItem: {},

            selectType: 0,

            rightContentHeight: 500,
            rightContentWidth: 400,

            caseData: {}, //模板
            medicalData: [], //病历
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
            that.resizeContent();
            that.getMenu();
            // window.addEventListener("click", that.removeSelect);

            //监听事件,由layout那边的resize抛出的
            window.addEventListener("bodyChange", that.resizeContent);
        });
    },

    // destroyed() {
    //     window.removeEventListener("click", this.removeSelect);
    // },

    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeContent();
            }
        },

        selectType(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.selectGetData(newValue);
            }

        },

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

        // removeSelect() {
        //     let that = this;
        //     that.selectNode = null;
        // },

        handleNodeClick(data) {
            let that = this;
            that.selectNode = data;

            if (data.type == 0) {
                that.selectStatus = 'none';
            }
            else{
                that.selectGetData(that.selectType);
                that.selectStatus = 'block';
            }
            // //设置选中的id
            // that.selectID = data.id;
        },
        showAddNode(){
            let that = this;
            if (that.selectNode != null && that.selectNode.type == 1) {
                //限制选中目录才能进行添加
                that.$message.error("请选择目录进行添加.");
            }
            else{
                that.addTreeNodeDialog = true;
            }
            
        },
        showEditNode() {
            let that = this;

            if (that.selectNode) {
                that.getMenuById();

                //获取数据, 然后弹窗
            } else {
                that.$message.error("请选择修改的节点");
            }
        },

        //新增节点
        addNode(value) {
            let that = this;
            // console.log(that.selectNode);
            // console.log(value);
            value.children = [];
            if (value.p_id == 0) {
                //p_id为0的时候 ，为顶级，直接添加数据即可
                that.templateData.push(value);
            }
            else if(that.selectNode.type == 0){
                //当非顶级的时候，判断选中这条数据的大纲类型，如果是目录，则向下添加一条数据
                that.selectNode.children.push(value);
            }
            // else if (that.selectNode.type == 1) {
            //     //如果这条选中的大纲数据是个文件，则同级添加一条数据
            //     that.selectNode.push(value);
            // }

        },

        eidtNode(value) {
            let that = this;
            that.selectNode.outline_name = value.outline_name;

        },
        showDelNode(){
            //显示删除节点提示
          let that = this;

          that.$confirm('删除不可恢复，是否确定删除？', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            that.removeNode();
          }).catch(() => {
            that.$message({
              type: 'info',
              message: '已取消删除'
            });          
          });

        },
        //删除节点
        removeNode() {
            let that = this;

            if (that.selectNode) {
                let id = that.selectNode.id;
                that.$api.case_template_menu.del({id})
                    .then(res => {
                        if (res.code == 200) {
                            that.$message({
                                message: res.msg,
                                type: "success",
                                duration: 800
                            });
                            that.$refs.templateTree.remove(that.selectNode);
                            // console.log(that.selectNode);
                        }

                    })
                    .catch(res => {
                         that.$message.error(
                              res.msg || "操作异常请重试."
                          );
                    });

            } else {
                that.$message.error("请选择删除的节点");
            }
        },
        selectGetData(option){
            let that = this;
            if (that.selectNode != null && that.selectNode.type == 1) {
                    switch (option) {
                        case 0:
                            that.getCaseData('case_template','caseData');
                            that.caseShow = true;
                            break;
                        case 1:
                            that.getData('medical','medicalData','medicalShow');
                            break;
                        case 2:
                            that.getData('inspect','inspectData');
                            that.inspectShow = true;
                            break;
                        case 3:
                            that.getData('diagnose','diagnoseData');
                            that.diagnoseShow = true;
                            break;
                        case 4:
                            that.getData('treat','treatData');
                            that.treatShow = true;
                            break;
                        case 5:
                            that.getData('advice','adviceData');
                            that.adviceShow = true;
                            break;
                    }
                }

            },
        getMenu(){
            //获取菜单
            let that = this;
            that.$api.case_template_menu.get()
            .then(res => {
                that.templateData = res.data;
            })
            .catch(res => {

            });
        },
        getMenuById(){
            //根据id获取菜单
            let that = this;
            let id = that.selectNode.id;
            that.$api.case_template_menu.getById({'id':id})
            .then(res => {
                that.currentEditItem = res.data;
                that.editTreeNodeDialog = true;
            })
            .catch(res => {

            });
        },
        getCaseData(apiType,dataType){
            //主数据
            let that = this;
            let menu_id = that.selectNode.id;
            that.$api[apiType].getById({'menu_id':menu_id})
            .then(res => {
                if (res.code == 200) {
                    that[dataType] = res.data;
                }
                else{
                       that.$message.error( res.msg || "数据获取失败." );
                }
                
            })
            .catch(res => {

            });
        },
        getData(apiType,dataType,dialogShow){
            //主数据
            let that = this;
            let menu_id = that.selectNode.id;
            that.$api[apiType].get({'menu_id':menu_id})
            .then(res => {
                if (res.code == 200) {
                    that[dataType] = res.data;
                    that[dialogShow] = true;
                }
                else{
                       that.$message.error( res.msg || "数据获取失败." );
                }
                
            })
            .catch(res => {

            });
        },
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

            .mr-14 {
                margin-right: 14px;
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

        .content {
            height: 100%;
            overflow: hidden;
        }
    }
}
</style>