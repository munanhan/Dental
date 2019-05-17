<template>
    <el-dialog
        title="处置选择"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="1000px"
        top="1vh"
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
                                    <el-table
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
                                            style="margin-left:10px;margin-top:10px"
                                            v-model="radio"
                                            label="1"
                                        >非医保项目</el-radio>
                                        <el-radio
                                            style="margin-left:-15px;margin-top:10px"
                                            v-model="radio"
                                            label="2"
                                        >医保项目</el-radio>
                                        <i
                                            style="font-size:20px;margin-top:8px;cursor: pointer;"
                                            class="el-icon-setting form-setting"
                                        ></i>

                                    </div>
                                </div>
                                <div class="choice-lowerright"></div>
                            </div>
                        </div>
                    </el-tab-pane>

                    <el-tab-pane
                        label="处置组合"
                        name="disposal-combination"
                        class="disposal-combination"
                    >
                        asdsadsa
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
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "DisposalChoice",

    mixins: [DialogForm],

    data() {
        return {
            radio: "1",
            activeName: "disposal-choice",
            menuData: [
                {
                    id: 1,
                    catepory: "西药费"
                },
                {
                    id: 2,
                    catepory: "放射费"
                },
                {
                    id: 3,
                    catepory: "检查费"
                },
                {
                    id: 4,
                    catepory: "诊疗费"
                },
                {
                    id: 5,
                    catepory: "补牙费"
                },
                {
                    id: 6,
                    catepory: "手术费"
                },
                {
                    id: 7,
                    catepory: "正崎费"
                },
                {
                    id: 8,
                    catepory: "拔牙费"
                },
                {
                    id: 9,
                    catepory: "修复费"
                },
                {
                    id: 10,
                    catepory: "其  他"
                }
            ]
        };
    },

    methods: {
        // getMenu() {
        //     //获取菜单
        //     let that = this;
        //     that.$api.cost_category
        //         .get()
        //         .then(res => {
        //             that.menuData = res.data;
        //         })
        //         .catch(res => {});
        // },
        // getMenuTableData(row) {
        //     let that = this;
        //     that.menu_id = row.id;
        //     that.getData(row.id);
        // }
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
                    border: 1px solid red;
                    height: 600px;
                    width: 280px;
                    .choice-upperleft {
                        border: 1px solid red;
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
                        border: 1px solid red;
                        width: 680px;
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
                        }
                    }

                    .choice-lowerright {
                        border: 1px solid red;
                        width: 680px;
                        height: 248px;
                    }
                }
            }
            .disposal-combination {
            }
        }
    }
}
</style>