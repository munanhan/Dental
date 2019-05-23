<template>
    <div>
        <el-dialog
            title="连锁店管理"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog chain-store"
            :close-on-click-modal="false"
            v-dialog-drag
            width="1010px"
            top="2vh"
        >
            <el-tabs v-model="activeName">
                <el-tab-pane
                    label="分店管理"
                    name="chainStoreManagement"
                >
                    <div class="store-container">
                        <div
                            v-if="activeName == 'chainStoreManagement'"
                            class="add-store"
                        >
                            <el-button
                                type="primary"
                                @click="addStoreDialog = true"
                                size="medium"
                            >新增分店</el-button>
                        </div>

                        <div class="store-item">
                            <div
                                class="content"
                                @click="showInfo('1')"
                            >
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>

                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>

                <el-tab-pane
                    label="员工管理"
                    name="StaffManagement"
                >
                    <div class="staff-management">
                        <div class="action-bar">
                            <div class="search-item">
                                <span class="mr-10">所属诊所</span>
                                <el-select
                                    v-model="search.hospital"
                                    collapse-tags
                                >
                                    <el-option
                                        v-for="item in hospitalList"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="search-item">
                                <el-button
                                    type="primary"
                                    @click="getStaffData"
                                >查询</el-button>
                            </div>
                        </div>

                        <el-table
                            border
                            class="width100 mb-10"
                            :data="tableData"
                            :height="tableHeight"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="aaaa"
                                label="姓名"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="所属门店"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="职位"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="联系电话"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁管理员"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁查看权限"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="单店查看权限"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>

                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="患者管理"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-checkbox
                                        v-model="scope.row.check"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-checkbox>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁店管理"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                 <el-checkbox
                                        v-model="scope.row.check"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-checkbox>
                                </template>
                            </el-table-column>
                        </el-table>
                        <el-row
                            class="pager"
                            type="flex"
                            justify="end"
                        >
                            <el-pagination
                                @current-change="changePage"
                                @size-change="pageSizeChange"
                                background
                                layout="total, sizes, prev, pager, next, jumper"
                                :page-sizes="[10, 20, 50, 100]"
                                :page-size="pager.size"
                                :total="pager.total"
                                :current-page="pager.current"
                            ></el-pagination>
                        </el-row>
                    </div>
                </el-tab-pane>

                <el-tab-pane
                    label="连锁信息"
                    name="chainInformation"
                >

                </el-tab-pane>

            </el-tabs>
        </el-dialog>

        <chain-store-info-dialog :show.sync="showInfoDialog"></chain-store-info-dialog>
        <add-store-dialog :show.sync="addStoreDialog"></add-store-dialog>
    </div>
</template>

<script>
import DialogForm from "../../base/DialogForm";
import ChainStoreInfoDialog from "./ChainStoreInfoDialog";
import AddStoreDialog from "./AddStoreDialog";
export default {
    name: "ChainStore",
    mixins: [DialogForm],

    components: { ChainStoreInfoDialog, AddStoreDialog },
    props: {},
    data() {
        return {
            activeName: "chainStoreManagement",
            showInfoDialog: false,

            addStoreDialog: false,

            //员工管理
            tableHeight: 370,
            tableData: [{}],
            search: {
                hospital: 0
            },

            hospitalList: [{ id: 0, label: "全部" }],

            pager: {
                total: 0,
                current: 1,
                size: 20
            }
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        showInfo(id) {
            let that = this;
            that.showInfoDialog = true;
        },

        changePage(index) {
            let that = this;

            that.pager.current = index;
            that.getStaffData();
        },

        pageSizeChange(val) {
            let that = this;

            that.pager.size = val;
            that.getStaffData();
        },

        //获取员工的信息
        getStaffData() {
            let that = this,
                params = {},
                searchData = JSON.parse(JSON.stringify(that.search));

            params["pageIndex"] = that.pager.current;
            params["pageSize"] = that.pager.size;

            //获取数据
        },

        //监听表格的radio和checkbox的事件
        changeType(row, type, value) {}
    }
};
</script>
<style lang="less" scoped>
.transition-3 {
    transition: all 0.3s;
}

.chain-store {
    /deep/ .el-dialog__body {
        height: 530px;
        padding: 0;

        .el-tabs__content {
            overflow: unset;
        }
    }

    .store-container {
        width: 100%;
        height: 100%;
        overflow: auto;

        .add-store {
            position: absolute;
            right: 10px;
            top: -38px;
            z-index: 9999;
        }

        .store-item {
            display: inline-block;
            height: 230px;
            width: 200px;
            padding: 16px 10px 10px;
            box-sizing: border-box;

            .content {
                border: 1px solid #e3e3e3;
                border-radius: 8px;
                height: 100%;
                background-color: #f7c466;
                text-align: center;
                cursor: pointer;
                .transition-3;

                &:hover {
                    transform: translateY(-6px);
                    box-shadow: 6px 6px 6px #e3e3e3;
                }

                .title {
                    padding: 20px;
                    font-size: 18px;
                    font-weight: bold;
                    color: #a06904;
                }

                .info {
                    padding: 10px;
                    font-size: 16px;
                    font-weight: bold;
                }
            }
        }
    }

    .staff-management {
        padding: 10px;
    }
}
</style>