<template>
    <div>
        <el-dialog
            title="既往史设置"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog past-medicalhistory"
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
                        label="既往史"
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
            <div
                slot="footer"
                class="dialog-footer"
            >
                <div class="pull-left">
                    <el-button
                        type="primary"
                        @click="add_med"
                        :disabled="commitLoading"
                    >新增</el-button>
                </div>

                <!-- <div>
                </div> -->
                <div>
                    <el-button
                        @click="closeDialog"
                        :disabled="commitLoading"
                    >取 消</el-button>
                    <el-button
                        type="primary"
                        @click="commit"
                        :loading="commitLoading"
                    >确 定</el-button>
                </div>
                <!-- :disabled="!$check_pm('resume_add') || analyzeLoading" -->
            </div>
        </el-dialog>

        <add-past-medicalhistory
            :show.sync="addmed_show"
            @flush="flush"
        ></add-past-medicalhistory>
    </div>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import AddPastMedicalhistory from "./AddPastMedicalhistory";

export default {
    name: "ExpenditureCategory",
    mixins: [DialogForm],

    components: {
        AddPastMedicalhistory
    },
    props: {},

    data() {
        return {
            addmed_show: false,
            tableHeight: "340px",
            tableData: []
            // tableData: []

            // addExpendDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.$api.patient_anamneses
                    .getAnamneses()
                    .then(res => {
                        // console.log(res.data)
                        that.tableData = res.data;
                    })
                    .catch(res => {
                        console.log(res);
                    });
            }
        }
    },
    computed: {},
    methods: {
        //交换位置
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

        // del(row, index) {
        //     let that = this;
        //     let id = row.id;
        //     that.$api.patient_anamneses
        //         .delAnamneses({ id })
        //         .then(res => {
        //             if (res.data) {
        //                 that.tableData.splice(index, 1);
        //             }
        //         })
        //         .catch(res => {
        //             console.log(res);
        //         });
        // },
        del(row, index) {
            let that = this;
            let id = row.id;
            if (confirm("确定删除当前行吗？")) {
                that.$api.patient_anamneses
                    .delAnamneses({ id })
                    .then(res => {
                        if (res.code == 200) {
                            that.tableData.splice(index, 1);
                        }
                    })
                    .catch(res => {
                        console.log(res);
                    });
            } else {
                console.log("Cancel");
            }
        },

        commit() {},

        addItem(item) {
            let that = this;

            console.log(item);

            that.closeDialog();
        },
        add_med() {
            this.addmed_show = true;
        },
        flush(data) {
            let that = this;
            that.tableData.push(data);
        }
    }
};
</script>
<style lang="less" scoped>
.past-medicalhistory {
    /deep/ .el-dialog__header {
        text-align: center;
    }
}
</style>