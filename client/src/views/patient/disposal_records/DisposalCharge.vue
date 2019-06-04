<template>
    <el-dialog
        title="处置与收费设置"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        :append-to-body="true"
        center
        top="2vh"
        v-dialog-drag
        width="1200px"
    >
        <div class="discharge-content">
            <div class="discharge-left">
                <div class="left-top">
                    <i
                        style="float:right"
                        class="el-icon-setting form-setting"
                        @click="cost_type"
                    ></i>
                </div>
                <div class="left-bottom">
                    <div
                        class="title"
                        style="font-size:16px"
                    >
                        费用大类
                    </div>
                    <div style="height:500px;overflow: auto">
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
            </div>
            <div class="discharge-middle">
                <el-table
                    :data="tableData"
                    height="602"
                    border
                    style="width: 100%"
                >
                    <el-table-column
                        prop="date"
                        label="操作"
                        align="center"
                        width="80"
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
                        prop="aaaa"
                        label="处置代码"
                        align="center"
                        width="80"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="bbbb"
                        label="处置名称"
                        align="center"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        label="价格(元)"
                        align="center"
                        width="80"
                    >

                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="单位"
                        align="center"
                        width="120"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="按会员折扣"
                        align="center"
                        width="100"
                    >
                        <el-checkbox v-model="checked"></el-checkbox>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="费用类型"
                        align="center"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="计费方式"
                        align="center"
                        width="100"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        align="center"
                        label="备注"
                    >
                    </el-table-column>
                    <el-table-column
                        prop=""
                        align="center"
                        width="100"
                        label="移动"
                    >
                        <template slot-scope="scope">
                            <el-tooltip
                                effect="dark"
                                content="上移"
                                placement="bottom"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-arrow-up"
                                    circle
                                    @click.stop="move(-1, scope.$index)"
                                ></el-button>
                            </el-tooltip>
                            <el-tooltip
                                effect="dark"
                                content="下移"
                                placement="bottom"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-arrow-down"
                                    circle
                                    @click.stop="move(1, scope.$index)"
                                ></el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <!-- <div class="discharge-right">
                <div style="margin-top:50px;
                            margin-left:5px">
                    <div>
                        <el-button
                            type="primary"
                            style="width:80px;
                                   margin-bottom:30px"
                        >上移</el-button>
                    </div>
                    <div>
                        <el-button style="width:80px">下移</el-button>
                    </div>
                </div>
            </div> -->
        </div>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button>导入 Excel</el-button>
            <el-button style="margin-right:50px">导出 Excel</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
            >保存</el-button>
            <el-button @click="closeDialog">退出</el-button>
        </div>
        <cost-type :show.sync="costtype_show"></cost-type>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import CostType from "./CostType";
export default {
    name: "DisposalCharge",

    components: {
        CostType
    },

    mixins: [DialogForm],
    created() {
        this.getMenu();
    },
    data() {
        return {
            costtype_show: false,
            tableData: [
                { aaaa: "网络咨询", bbbb: "朋友介绍" },
                { aaaa: "朋友介绍", bbbb: "网络咨询" },
                { aaaa: "家住附近", bbbb: "诊所网站" },
                { aaaa: "诊所网站", bbbb: "朋友介绍" }
            ],
            checked: true,
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
                }
            ]
        };
    },

    methods: {
        del(row, index) {
            let that = this;
            that.tableData.splice(index, 1);
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
        },
        move(act, index) {
            let that = this,
                moveIdx = index + act;

            if (moveIdx != -1 && moveIdx != that.tableData.length) {
                that.tableData[index] = that.tableData.splice(
                    moveIdx,
                    1,
                    that.tableData[index]
                )[0];
            }
        },
        cost_type() {
            this.costtype_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
@import "~@css/var";
.discharge-content {
    display: flex;

    // border: 1px solid red;

    height: 600px;
    width: 1160px;
    .discharge-left {
        margin-right: 10px;
        // border: 1px solid red;
        height: 600px;
        width: 250px;
        .left-top {
            // border: 1px solid red;
            height: 50px;
            width: 250px;
        }
        .left-bottom {
            // border: 1px solid red;
            height: 450px;
            width: 250px;
            .title {
                padding-top: 10px;
                padding-left: 16px;
                font-size: 14px;
                font-weight: bold;
                color: @color;
                border-bottom: 4px solid @color;
            }
        }
    }

    .discharge-middle {
        // border: 1px solid red;
        height: 600px;
        width: 900px;
    }
    // .discharge-right {
    //     border: 1px solid #e3e3e3;
    //     height: 600px;
    //     width: 100px;
    // }
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