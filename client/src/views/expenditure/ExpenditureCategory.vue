<template>
    <el-dialog
        title="支出类别设置"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog expenditure-category"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <div class="content">
            <div class="letf-content">
                <el-table
                    border
                    class="width100 mb-10"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                >
                    <el-table-column
                        prop="aaaa"
                        label="支出类型"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        label="删除"
                        align="center"
                        show-overflow-tooltip
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
                </el-table>
            </div>
            <div class="right-content">
                <div>
                    <el-button
                        type="primary"
                        @click="move(-1)"
                    >上移</el-button>
                </div>
                <div>
                    <el-button
                        type="primary"
                        @click="move(1)"
                    >下移</el-button>
                </div>
            </div>
        </div>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <div>
                <el-button
                    @click="closeDialog"
                    :disabled="commitLoading"
                >取 消</el-button>
            </div>
            <div>
                <el-button
                    type="primary"
                    @click="commit"
                    :loading="commitLoading"
                >确 定</el-button>
            </div>
            <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
        </div>

    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";

export default {
    name: "ExpenditureCategory",
    mixins: [DialogForm],

    components: {},
    props: {},

    data() {
        return {
            commitLoading: false,
            tableHeight: "340px",
            tableData: [{ aaaa: '123123123' }]
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        move() {
            let that = this;
        },

        del(row, index){
            let that = this;
            that.tableData.splice(index, 1);
        },

        commit(){

        }
    }
};
</script>
<style lang="less" scoped>
.expenditure-category {
    .content {
        display: flex;

        .letf-content {
            flex: 1;
        }

        .right-content {
            width: 160px;
            margin-left: 10px;

            > div {
                margin-bottom: 10px;

                > button {
                    width: 100%;
                }
            }
        }
    }
}
</style>