<template>
    <div
        class="content"
        ref="menuContent"
    >
        <el-container>
            <el-aside
                class="left"
                :style="{'width':200+'px'}"
            >
                <div class="menu_title">
                    <el-row>
                        <el-col :span="10">
                            <div class="title">
                                费用大类
                            </div>

                        </el-col>
                        <el-col :span="13">
                            <div class="setting">
                                <i
                                    class="fa fa-cog"
                                    style="margin-top:10px;
                             font-size:20px;
                             cursor:pointer;
                             margin-left:10px"
                                    @click=""
                                ></i>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="24">
                            <div class="menu_content">
                                <el-table
                                    :data="menuData"
                                    stripe
                                    border
                                    :show-header="false"
                                    highlight-current-row
                                    :height="menuHeight"
                                    @row-click="getMenuTableData"
                                >
                                    <el-table-column prop="role">
                                    </el-table-column>
                                </el-table>

                            </div>
                        </el-col>
                    </el-row>

                </div>
            </el-aside>

            <el-main class="right">
                <el-col :span="24">
                    <el-row>
                        <div class="right">
                            <div class="data_content">
                                <el-tabs type="border-card">
                                    <el-tab-pane label="PC端">

                                    </el-tab-pane>
                                    <el-tab-pane label="移动端">

                                    </el-tab-pane>
                                </el-tabs>
                            </div>
                        </div>
                    </el-row>
                    <el-row>
                        <div class="btn_content">
                            <el-col :span="24">
                                <span class="">
                                    <el-button
                                        style="margin-right: 10px;"
                                        type="primary"
                                        @click=""
                                    >添加</el-button>
                                </span>

                                <span class="">
                                    <el-button
                                        style="margin-right: 10px;"
                                        type="primary"
                                        @click=""
                                    >导入Excel</el-button>
                                </span>

                                <span class="">
                                    <el-button
                                        style="margin-right: 10px;"
                                        type="primary"
                                        @click=""
                                    >导出Excel</el-button>
                                </span>
                            </el-col>
                        </div>
                    </el-row>
                </el-col>
            </el-main>
        </el-container>

        <!-- 添加组合目录 -->
        <!--         <add-combo-dir
            :show.sync="addComboDirDialog"
        >
        </add-combo-dir> -->

    </div>
</template>

<script>
export default {
    name: "PermissionSettings",
    components: {},
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            editItem: {},
            //高度设定
            tableHeight: 700,
            menuHeight: 667,
            tab: "pc",
            menuData: [
                {
                    id: 1,
                    role: "主任"
                },
                {
                    id: 2,
                    role: "咨询师"
                },
                {
                    id: 3,
                    role: "前台"
                },
                {
                    id: 4,
                    role: "护士"
                },
                {
                    id: 5,
                    role: "收银员"
                },
                {
                    id: 6,
                    role: "技师"
                },
                {
                    id: 7,
                    role: "医生"
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
    created() {},
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
        selectTab(tab, event) {
            console.log(tab, event);
        },
        getMenuTableData(row) {
            alert(row.id);
        },
        resizeTable() {
            let that = this;
            // if (that.$refs.menuContent.clientHeight != 0) {
            let tableHeight = that.$refs.menuContent.clientHeight - 70;
            that.tableHeight = tableHeight;
            that.menuHeight = tableHeight - 33;
            // }

            // that.$refs.search.clientHeight -
            // 70;
            // console.log(tableHeight);
        },
        edit(editItem) {
            //修改
            let that = this;
            that.editItem = editItem;
        },
        del(id) {
            //删除
            alert(id);
        },
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
}

.content {
    .data_content {
        /*border: 1px solid #dbdbdb;*/
        margin-bottom: 10px;
        height: 700px;
        /*padding: 10px 0 0 10px;*/

        /deep/ .el-tabs__header .el-tabs__nav-scroll {
            padding-left: 0;
        }
    }
}
.left {
    border: 1px solid #dbdbdb;
    height: 100%;
    width: 180px;
    /*height: 800px;*/

    .title {
        padding-top: 10px;
        padding-bottom: 5px;
        padding-left: 16px;
        font-size: 14px;
        font-weight: bold;
        color: @color;
        /*text-align: center;*/
        border-bottom: 2px solid @color;
    }

    .setting {
        float: right;
        /*padding-right: 10px;*/
    }

    .menu_content {
        /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
            background-color: @linght-background-color;
            cursor: pointer;
        }
        /deep/ .el-table__body td {
            padding: 3px 0;
        }
    }
}
.right {
    /*border: 1px solid #dbdbdb;*/
    padding: 0 0 0 5px;
    /*height: 800px;*/
    height: 100%;
    /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
        background-color: @linght-background-color;
    }
}
.btn_content {
    padding: 0 0 10px 10px;
    /*border-bottom: 1px solid #e3e3e3;*/
    height: 40px;
    /*width: 100%;*/
}
</style>