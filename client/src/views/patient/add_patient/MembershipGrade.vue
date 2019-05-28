<template>
    <div>
        <el-dialog
            title="会员等级维护"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog membership-grade"
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
                        label="会员等级"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="discount"
                        label="会员折扣"
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
            <div
                slot="footer"
                class="dialog-footer clearfix"
            >
                <div class="pull-left">
                    <el-button
                        type="primary"
                        @click="add_grade"
                        :disabled="commitLoading"
                    >新增</el-button>
                </div>

                <!-- <div>
                </div> -->
                <div class="pull-right">
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

        <add-membership-grade
            :show.sync="addgrade_show"
            @flush="flush"
        ></add-membership-grade>
    </div>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
import AddMembershipGrade from "./AddMembershipGrade";
export default {
    name: "MembershipGrade",
    mixins: [DialogForm],

    components: {
        AddMembershipGrade
    },
    props: {},

    data() {
        return {
            addgrade_show: false,
            tableHeight: "340px",
            tableData: []

            // addExpendDialog: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.$api.patient_member
                    .get()
                    .then(res => {
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

        del(row, index) {
            let that = this;
            let id = row.id;
            if (confirm("确定删除当前行吗？")) {
                that.$api.patient_member
                    .del({ id })
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
        flush(data) {
            let that = this;
            console.log(that.tableData);
            that.tableData.push(data);
        },

        commit() {},

        addItem(item) {
            let that = this;

            console.log(item);

            that.closeDialog();
        },
        add_grade() {
            this.addgrade_show = true;
        }
    }
};
</script>
<style lang="less" scoped>
.membership-grade {
    /deep/ .el-dialog__header {
        text-align: center;
    }
}
</style>