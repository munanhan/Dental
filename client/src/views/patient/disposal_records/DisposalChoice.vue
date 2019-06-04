<template>
    <el-dialog
        title="处置选择"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="1010px"
        top="2vh"
    >
        <div class="dispos-content">
            <div class="dispos-tabs">
                <el-tabs
                    v-model="activeName"
                    class="tabs"
                >
                    <el-tab-pane
                        label="处置选择"
                        name="disposal-choice"
                        class="disposal-choice"
                    >
                        <div style="display:flex">
                            <div class="choice-left-content">
                                <div class="choice-upperleft">
                                    <div class="title">
                                        费用大类
                                    </div>
                                    <div style="height:300px;overflow: auto">
                                        <el-table
                                            style="cursor: pointer;"
                                            :data="menuData"
                                            stripe
                                            border
                                            :show-header="false"
                                            highlight-current-row
                                        >
                                            <el-table-column prop="category">
                                            </el-table-column>
                                        </el-table>
                                    </div>
                                </div>
                                <div class="choice-lowerleft"></div>
                            </div>
                            <div class="choice-right-content">
                                <div class="choice-upperright">
                                    <div
                                        style="display:flex"
                                        class="upperight-top"
                                    >
                                        <el-input
                                            class="upperight-top-input"
                                            placeholder="请输入内容"
                                        >
                                            <el-button
                                                slot="append"
                                                icon="el-icon-search"
                                            ></el-button>
                                        </el-input>
                                        <el-radio
                                            class="upperight-top-radio"
                                            v-model="radio"
                                            label="1"
                                        >非医保项目</el-radio>
                                        <el-radio
                                            class="upperight-top-radio"
                                            v-model="radio"
                                            label="2"
                                        >医保项目</el-radio>
                                        <i
                                            style=""
                                            @click="disCharge"
                                            class="el-icon-setting form-setting"
                                        ></i>

                                    </div>
                                    <div class="upperight-middle">
                                        <el-table
                                            :data="tableData"
                                            border
                                            highlight-current-row
                                            height="250"
                                            style="width: 100%;margin-left:10px;cursor: pointer;"
                                        >
                                            <el-table-column
                                                prop="add"
                                                label="添加"
                                                align="center"
                                                width="60"
                                            >
                                                <el-tooltip
                                                    effect="dark"
                                                    content="添加"
                                                    placement="bottom"
                                                >
                                                    <el-button
                                                        circle
                                                        size="mini"
                                                        icon="el-icon-plus"
                                                    ></el-button>
                                                </el-tooltip>
                                            </el-table-column>
                                            <el-table-column
                                                prop="name"
                                                label="处置编号"
                                                align="center"
                                                width="90"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="address"
                                                label="处置名称"
                                                align="center"
                                                width="90"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="date"
                                                label="单位"
                                                align="center"
                                                width="70"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="name"
                                                label="单价"
                                                align="center"
                                                width="70"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="address"
                                                label="是否医保"
                                                align="center"
                                                width="80"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="name"
                                                label="处置备注"
                                                align="center"
                                                width="100"
                                            >
                                            </el-table-column>
                                            <el-table-column
                                                prop="address"
                                                label="费用类型"
                                                align="center"
                                            >
                                            </el-table-column>
                                        </el-table>
                                    </div>
                                    <div class="upperight-bottom">
                                        <div class="upperight-top-content">
                                            <div class="upperight-text">已选择的处置项目：</div>
                                            <el-button
                                                style="height:40px"
                                                type="success"
                                                plain
                                            ><i class="el-icon-bottom"></i>添加</el-button>
                                            <el-button
                                                type="danger"
                                                plain
                                                style="height:40px"
                                            ><i class="el-icon-top"></i>删除</el-button>
                                        </div>
                                        <div class="upperight-table">
                                            <el-table
                                                :data="tableData2"
                                                border
                                                height="230"
                                                highlight-current-row
                                                style="width:100%"
                                            >
                                                <el-table-column
                                                    prop="delete"
                                                    label="删除"
                                                    align="center"
                                                    width="60"
                                                >
                                                    <template slot-scope="scope">
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
                                                                @click.stop="del(scope.row, scope.$index)"
                                                            ></el-button>
                                                        </el-tooltip>
                                                    </template>
                                                </el-table-column>
                                                <el-table-column
                                                    prop="name"
                                                    label="处置编码"
                                                    align="center"
                                                    width="100"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    prop="address"
                                                    label="处置名称"
                                                    align="center"
                                                    width="130"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    prop="date"
                                                    label="单位"
                                                    align="center"
                                                    width="100"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    prop="name"
                                                    label="单价"
                                                    align="center"
                                                    width="100"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    prop="address"
                                                    align="center"
                                                    label="费用类型"
                                                    width="90"
                                                >
                                                </el-table-column>
                                                <el-table-column
                                                    prop="address"
                                                    align="center"
                                                >
                                                </el-table-column>
                                            </el-table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </el-tab-pane>

                    <el-tab-pane
                        label="处置组合"
                        name="disposal-combination"
                        class="disposal-combination"
                    >
                        <div class="combination-content">
                            <div style="display:flex">
                                <div class="combination-left-content">
                                    <div class="upperleft-content">
                                        <el-input>
                                            <el-button
                                                slot="append"
                                                icon="el-icon-search"
                                            ></el-button>
                                        </el-input>
                                        <div class="combination-upperleft"></div>
                                    </div>
                                    <div class="combination-lowerleft"></div>
                                </div>

                                <div class="combination-right-content">
                                    <el-table
                                        :data="tableData"
                                        border
                                        show-summary
                                        height="600px"
                                        style="width: 100%"
                                    >
                                        <el-table-column
                                            prop="date"
                                            label="删除"
                                            align="center"
                                            width="60"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="name"
                                            label="处置编码"
                                            align="center"
                                            width="100"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="address"
                                            label="处置名称"
                                            align="center"
                                            width="100"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="date"
                                            label="单位"
                                            align="center"
                                            width="100"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="name"
                                            label="单价"
                                            align="center"
                                            width="100"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="address"
                                            align="center"
                                            label="数量"
                                            width="80"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="name"
                                            label="费用"
                                            align="center"
                                            width="100"
                                        >
                                        </el-table-column>
                                        <el-table-column
                                            prop="address"
                                            label="费用类型"
                                            align="center"
                                        >
                                        </el-table-column>
                                    </el-table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
            >确 定</el-button>
        </div>
        <disposal-charge :show.sync="dischargeShow"></disposal-charge>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import DisposalCharge from "./DisposalCharge";
export default {
    name: "DisposalChoice",

    mixins: [DialogForm],

    components: {
        DisposalCharge
    },
    created() {
        this.getMenu();
    },
    data() {
        return {
            dischargeShow: false,
            tableData2: [
                {
                    date: "02",
                    name: "王小虎",
                    address: "上海"
                },
                {
                    date: "22",
                    name: "王小虎",
                    address: "上海"
                },
                {
                    date: "201",
                    name: "王小虎",
                    address: "上海"
                }
            ],
            tableData: [
                {
                    date: "02",
                    name: "王小虎",
                    address: "上海"
                },
                {
                    date: "22",
                    name: "王小虎",
                    address: "上海"
                },
                {
                    date: "201",
                    name: "王小虎",
                    address: "上海"
                }
            ],
            radio: "1",
            activeName: "disposal-choice",
            menuData: [
                // {
                //     id: 1,
                //     catepory: "西药费"
                // },
                // {
                //     id: 2,
                //     catepory: "放射费"
                // },
                // {
                //     id: 3,
                //     catepory: "检查费"
                // },
                // {
                //     id: 4,
                //     catepory: "诊疗费"
                // },
                // {
                //     id: 5,
                //     catepory: "补牙费"
                // },
                // {
                //     id: 6,
                //     catepory: "手术费"
                // }
            ]
        };
    },

    methods: {
        disCharge() {
            this.dischargeShow = true;
        },
        del(row, index) {
            let that = this;
            that.tableData2.splice(index, 1);
        },
        getMenu() {
            //获取菜单
            let that = this;
            that.$api.cost_category
                .get()
                .then(res => {
                    that.menuData = res.data;
                })
                .catch(res => {});
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.dispos-content {
    height: 650px;
    // border: 1px solid red;

    .dispos-tabs {
        border: 1px solid #d8d6d6;
        width: 100%;
        margin-right: 10px;
        height: 100%;
        box-sizing: border-box;

        .tabs {
            position: relative;
            height: 100%;
            width: 100%;
            /deep/ .el-tabs_content {
                position: absolute;
                top: 40px;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .disposal-choice {
                .choice-left-content {
                    margin-left: 5px;
                    // border: 1px solid red;
                    height: 600px;
                    width: 280px;
                    .choice-upperleft {
                        // border: 1px solid red;
                        height: 350px;
                        width: 280px;
                        .title {
                            padding-top: 10px;
                            padding-left: 16px;
                            font-size: 14px;
                            font-weight: bold;
                            color: @color;
                            border-bottom: 4px solid @color;
                        }
                    }
                    .choice-lowerleft {
                        border: 1px solid black;
                        height: 245px;
                    }
                }
                .choice-right-content {
                    // border: 1px solid red;
                    height: 600px;
                    width: 100%;
                    .choice-upperright {
                        // border: 1px solid red;
                        width: 690px;
                        height: 350px;
                        .upperight-top {
                            // border: 1px solid red;
                            width: 680px;
                            margin-top: 5px;
                            height: 50px;
                            .upperight-top-input {
                                width: 400px;
                                margin-left: 10px;
                            }
                            .upperight-top-radio {
                                margin-left: 10px;
                                margin-top: 10px;
                            }
                            .form-setting {
                                font-size: 20px;
                                margin-top: 8px;
                                cursor: pointer;
                            }
                        }
                        .upperight-middle {
                            // border: 1px solid red;
                            width: 680px;
                            height: 250px;
                        }
                        .upperight-bottom {
                            // border: 1px solid red;
                            margin-top: 5px;
                            width: 690px;
                            height: 45px;
                            .upperight-top-content {
                                display: flex;
                                .upperight-text {
                                    margin-top: 10px;
                                    margin-left: 10px;
                                    margin-right: 20px;
                                }
                            }
                            .upperight-table {
                                margin-top: 5px;
                                width: 680px;
                                margin-left: 10px;
                            }
                        }
                    }
                }
            }
            .combination-content {
                // border: 1px solid red;
                width: 970px;
                height: 600px;
                .combination-left-content {
                    margin-left: 5px;
                    // border: 1px solid red;
                    height: 600px;
                    .upperleft-content {
                        height: 100;
                        // border: 1px solid red;
                        width: 280px;
                        .combination-upperleft-input {
                            width: 230px;
                        }
                        .combination-upperleft {
                            border: 1px solid #e3e3e3;
                            margin-top: 5px;
                            width: 280px;
                            height: 350px;
                        }
                    }
                    .combination-lowerleft {
                        border: 1px solid red;
                        width: 280px;
                        margin-top: 5px;
                        height: 195px;
                    }
                }
                .combination-right-content {
                    margin-left: 15px;
                    // border: 1px solid red;
                    height: 600px;
                    width: 750px;
                }
            }
            // .disposal-combination {
            //     border: 1px solid red;
            //     height: 10px;
            //     width: 100px;
            // }
        }
    }
}
</style>