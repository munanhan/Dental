<template>
    <div
        class="content"
        ref="menuContent"
    >
        <el-container>
            <el-aside
                class="left"
                :style="{'width':255+'px'}"
            >
                <div class="menu_title">
                    <el-row>
                        <el-col :span="8">
                            <div class="title">
                                处置组合
                            </div>

                        </el-col>
                        <el-col :span="15">
                            <div class="setting">
                                <i
                                    class="fa fa-sitemap combo_btn"
                                    @click="showCostTypeDialog"
                                ></i>
                                <i
                                    class="fa fa-share-alt combo_btn"
                                    @click="showCostTypeDialog"
                                ></i>
                                <i
                                    class="fa fa-edit combo_btn"
                                    @click="showCostTypeDialog"
                                ></i>
                                <i
                                    class="fa fa-trash-alt combo_btn"
                                    @click="showCostTypeDialog"
                                ></i>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col>
                            <div class="menu_content">
                                <el-tree
                                    :data="menuData"
                                    :props="treeField"
                                    @node-click="getMenuTableData"
                                    @current-change="clickNode"
                                    :highlight-current="selectThis"
                                    :style="{'height': menuHeight+'px'}"
                                    ref="tree"
                                    node-key="id"
                                >

                                </el-tree>
                            </div>
                        </el-col>
                    </el-row>

                </div>
            </el-aside>
            <el-main class="right">
                <el-col :span="24">
                    <el-row>

                        <div class="data_content">
                            <el-table
                                :data="tableData"
                                stripe
                                :height="tableHeight"
                                highlight-current-row
                                style="width: 100%"
                            >
                                <el-table-column
                                    label="处置代码"
                                    prop="disposal_code"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="处置名称"
                                    prop="disposal_name"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="价格"
                                    prop="price"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="单位"
                                    prop="unit"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="按会员折扣"
                                    prop="mem_discount"
                                >
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.mem_discount == 1">
                                            是
                                        </div>
                                        <div v-if="scope.row.mem_discount == 0">
                                            否
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column
                                    label="费用类型"
                                    prop="cost_type"
                                >

                                </el-table-column>
                                <el-table-column
                                    label="计费方式"
                                    prop="billing_mode"
                                >
                                    <template slot-scope="scope">
                                        <div v-if="scope.row.billing_mode == 1">
                                            按牙齿数计费
                                        </div>
                                        <div v-if="scope.row.billing_mode == 2">
                                            按其他计费
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column
                                    label="备注"
                                    prop="remarks"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="操作"
                                    prop="operation"
                                    width="200"
                                >
                                    <template slot-scope="scope">
                                        <div
                                            v-if="scope.row.status == 0"
                                            style="display: inline-block;margin-right: 10px;"
                                        >
                                            <el-tooltip
                                                effect="dark"
                                                content="停用"
                                                placement="bottom"
                                            >
                                                <el-button
                                                    type="warning"
                                                    size="mini"
                                                    icon="el-icon-minus"
                                                    circle
                                                    @click.stop="stop(scope.row.id)"
                                                ></el-button>
                                            </el-tooltip>
                                        </div>
                                        <div
                                            v-if="scope.row.status == 1"
                                            style="display: inline-block;padding-right: 10px"
                                        >
                                            <el-tooltip
                                                effect="dark"
                                                content="启用"
                                                placement="bottom"
                                            >
                                                <el-button
                                                    type="success"
                                                    size="mini"
                                                    icon="el-icon-check"
                                                    circle
                                                    @click.stop="start(scope.row.id)"
                                                ></el-button>
                                            </el-tooltip>
                                        </div>
                                        <el-tooltip
                                            effect="dark"
                                            content="修改"
                                            placement="bottom"
                                        >
                                            <el-button
                                                type="primary"
                                                size="mini"
                                                icon="el-icon-edit"
                                                circle
                                                @click.stop="edit(scope.row)"
                                            ></el-button>
                                        </el-tooltip>
                                        <el-tooltip
                                            effect="dark"
                                            content="删除"
                                            placement="bottom"
                                        >
                                            <el-button
                                                type="danger"
                                                size="mini"
                                                icon="el-icon-delete"
                                                circle
                                                @click.stop="del(scope.row.id)"
                                            ></el-button>
                                        </el-tooltip>

                                    </template>

                                </el-table-column>
                            </el-table>
                        </div>

                    </el-row>
                    <el-row>
                        <div class="btn_content">
                            <el-col :span="24">
                                <span class="">
                                    <el-button
                                        type="primary"
                                        style="margin-right: 10px;"
                                        @click="showAddDialog"
                                    >添加</el-button>
                                </span>

                                <span class="">
                                    <el-button
                                        type="primary"
                                        style="margin-right: 10px;"
                                        @click="importData"
                                    >导入Excel</el-button>
                                </span>

                                <span class="">
                                    <el-button
                                        type="primary"
                                        style="margin-right: 10px;"
                                        @click="exportData"
                                    >导出Excel</el-button>
                                </span>
                            </el-col>
                        </div>
                    </el-row>
                </el-col>
            </el-main>
        </el-container>

        <!-- 费用大类 -->
        <!--  <cost-type
      :show.sync="costTypeDialog"
    >
    </cost-type> -->
        <!-- 添加处置与收费 -->
        <!-- <add-disposal-charging
      :show.sync="addDisposalChargingDialog"
    >
    </add-disposal-charging> -->
        <!-- 修改处置与收费 -->
        <!-- <edit-disposal-charging
      :show.sync="editDisposalChargingDialog"
      :editItem="editItem"
    >
    </edit-disposal-charging> -->

    </div>
</template>

<script>
export default {
    name: "Index",
    components: {},
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            costTypeDialog: false,
            addDisposalChargingDialog: false,
            editDisposalChargingDialog: false,
            editItem: {},
            tableHeight: 700,
            menuHeight: 660,
            selectThis: false,
            treeField: {
                label: "combo_name",
                children: "children"
            },
            menuData: [
                {
                    id: 1,
                    combo_name: "蛀牙用药组合",
                    level: 1,
                    children: [
                        {
                            id: 6,
                            combo_name: "白+黑",
                            level: 2
                        },
                        {
                            id: 8,
                            combo_name: "必兰麻+保丽净",
                            level: 2
                        }
                    ]
                },
                {
                    id: 2,
                    combo_name: "拔牙用药组合",
                    level: 1,
                    children: [
                        {
                            id: 7,
                            combo_name: "西药+中药",
                            level: 2
                        }
                    ]
                },
                {
                    id: 3,
                    combo_name: "服用类组合"
                },
                {
                    id: 4,
                    combo_name: "外敷类组合"
                },
                {
                    id: 5,
                    combo_name: "日常类组合"
                }
            ],
            tableData: [
                {
                    id: 1,
                    disposal_code: "001",
                    disposal_name: "必兰麻",
                    price: 50.0,
                    unit: "项",
                    mem_discount: 1,
                    cost_type: "西药费",
                    billing_mode: 1,
                    remarks: "无",
                    operation: "",
                    status: 1
                },
                {
                    id: 2,
                    disposal_code: "002",
                    disposal_name: "保丽净",
                    price: 999.99,
                    unit: "项",
                    mem_discount: 0,
                    cost_type: "西药费",
                    billing_mode: 2,
                    remarks: "无",
                    operation: "",
                    status: 0
                }
            ]
        };
    },
    created() {
        let that = this;
        that.resizeTable();
    },
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeTable();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeTable);
        } else {
            window.attachEvent("bodyChange", that.resizeTable);
        }
    },
    watch: {
        update(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.resizeTable();

                setTimeout(() => {
                    that.$emit("update:update", false);
                });
            }
        }
    },

    computed: {},
    methods: {
        clickNode() {
            //点击该节点
            // let that = this;
            // that.selectThis = true;
        },
        getMenuTableData(data) {
            let that = this;
            that.selectThis = true;
            console.log(data);
        },
        showCostTypeDialog() {
            let that = this;
            that.costTypeDialog = true;
        },
        resizeTable() {
            let that = this;
            if (that.$refs.menuContent.clientHeight != 0) {
                let tableHeight = that.$refs.menuContent.clientHeight - 70;
                that.tableHeight = tableHeight;
                that.menuHeight = tableHeight - 40;
            }

            // that.$refs.search.clientHeight -
            // 70;
            // console.log(tableHeight);
        },
        start(id) {
            //开始
            alert(id);
        },
        stop(id) {
            //结束
            alert(id);
        },
        edit(editItem) {
            //修改
            let that = this;
            that.editItem = editItem;
            that.editDisposalChargingDialog = true;
        },
        del(id) {
            //删除
            alert(id);
        },
        showAddDialog() {
            let that = this;
            that.addDisposalChargingDialog = true;
        },
        importData() {},
        exportData() {},

        getPatientInfo() {
            let that = this;

            that.$api.aaaa.aaaa
                .then(res => {
                    that.getDataDone();
                })
                .catch(res => {
                    that.getDataDone();
                });
        },

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
/deep/ .el-tree-node:focus > .el-tree-node__content {
    background-color: @linght-background-color !important;
}

/deep/ .el-tree-node__content:hover {
    background-color: @linght-background-color !important;
}

/deep/
    .el-table--striped
    .el-table__body
    tr.el-table__row--striped.current-row
    td,
/deep/ .el-table__body tr.current-row > td {
    background-color: @linght-background-color;
}

.content {
    background: white;
    height: 100%;

    /deep/.el-tree--highlight-current
        .el-tree-node.is-current
        > .el-tree-node__content {
        background-color: black;
    }
}
.data_content {
    border: 1px solid #dbdbdb;
    margin-bottom: 10px;
}
.left {
    border: 1px solid #dbdbdb;
    height: 100%;
    width: 250px;
    /*height: 800px;*/

    .title {
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        font-size: 18px;
        font-weight: bold;
        color: @color;
    }

    .setting {
        float: right;
        /*padding-right: 10px;*/
    }

    .combo_btn {
        margin-top: 12px;
        font-size: 20px;
        cursor: pointer;
        margin-left: 10px;
        margin-right: 8px;
    }

    .menu_content {
        /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
            background-color: @linght-background-color;
            cursor: pointer;
        }
    }
}
.right {
    /*border: 1px solid #dbdbdb;*/
    /*height: 800px;*/
    padding: 0 0 0 10px;
    height: 100%;
    /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
        background-color: @linght-background-color;
    }
}
.btn_content {
    /*padding: 10px 0 10px 0;*/
    /*border-bottom: 1px solid #e3e3e3;*/
    height: 40px;
    /*width: 90%;*/
}
</style>