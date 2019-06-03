<template>
    <div>
        <el-dialog
            title="基本需求设置"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog patients-source"
            :close-on-click-modal="false"
            top="3vh"
            :append-to-body="true"
            v-dialog-drag
        >
            <div class="content">
                <!-- <div class="letf-content"> -->
                <el-table
                    border
                    class="width100 mb-10"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                >
                    <el-table-column
                        prop="name"
                        label="基本需求"
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
                            <!-- <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)"
                            >Edit</el-button> -->
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div
                slot="footer"
                class="dialog-footer"
            >
                <div class="pull-left">
                    <el-button
                        type="primary"
                        @click="addbas_need"
                        :disabled="commitLoading"
                    >新增</el-button>
                </div>

                <!-- <div>
                </div> -->
                <div>
                    <el-button @click="closeDialog">取 消</el-button>
                    <el-button
                        type="primary"
                        @click="closeDialog"
                    >确 定</el-button>
                </div>
                <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
            </div>
        </el-dialog>
        <add-basicneeds :show.sync="addbasneed_show"></add-basicneeds>

        <!-- <add-patients-source
            :show.sync="addpatsour_show"
            @flush="flush"
        ></add-patients-source> -->
    </div>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import AddBasicneeds from "./AddBasicneeds";

export default {
    name: "ExpenditureCategory",
    mixins: [DialogForm],

    components: {
        AddBasicneeds,
    },
    props: {},

    data() {
        return {
            addbasneed_show: false,
            tableHeight: "340px",
            tableData: []
        };
    },
    created() {},
    mounted() {},
    watch: {
        // show(newValue, oldValue) {
        //     let that = this;
        //     if (newValue) {
        //         that.$api.resource
        //             .resources()
        //             .then(res => {
        //                 that.tableData = res.data;
        //             })
        //             .catch(res => {
        //                 console.log(res);
        //             });
        //     }
        // }
    },
    computed: {},
    methods: {
        //      handleEdit(index, row) {
        //     console.log(index, row);
        //   },
        // del(row, index) {
        //     let that = this;
        //     let id = row.id;
        //     if (confirm("确定删除当前行吗？")) {
        //         that.$api.resource
        //             .delResource({ id })
        //             .then(res => {
        //                 if (res.data) {
        //                     that.tableData.splice(index, 1);
        //                 }
        //             })
        //             .catch(res => {
        //                 console.log(res);
        //             });
        //     } else {
        //         console.log("Cancel");
        //     }
        // },

        addbas_need() {
            this.addbasneed_show = true;
        },

        // flush(data) {
        //     let that = this;
        //     that.tableData.push(data);
        // }
    }
};
</script>
<style lang="less" scoped>
.patients-source {
    /deep/ .el-dialog__header {
        text-align: center;
    }
}
</style>