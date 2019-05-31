<template>
    <el-dialog
        title="预约提醒"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog reminder"
        :close-on-click-modal="false"
        v-dialog-drag
        width="800px"
        height=300        
        top="3vh"
    >
        <el-table
            border
            class="width100 reminder-table"
            :data="tableData"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
        >
            <el-table-column
                prop="aaaa"
                label="病人姓名"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="aaaa"
                label="电话"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="aaaa"
                label="医生"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="aaaa"
                label="到期时间"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="aaaa"
                label="事项"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>

            <el-table-column
                label="操作"
                align="center"
                show-overflow-tooltip
            >
                <template slot-scope="scope">

                    <el-tooltip
                        effect="dark"
                        content="患者到达"
                        placement="bottom"
                    >
                        <el-button
                            type="primary"
                            size="mini"
                            icon="el-icon-s-order"
                            circle
                            @click.stop="arrive(scope.row, scope.$index)"
                        ></el-button>
                    </el-tooltip>

                    <el-tooltip
                        effect="dark"
                        content="删除预约"
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
    </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
    name: "AppointmentReminder",
    mixins: [DialogForm],

    components: {},
    props: {},
    data() {
        return {
            tableData: []
        };
    },
    created() {},
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();
            }
        }
    },
    computed: {},
    methods: {
        getData() {
            let that = this;
        },

        arrive(row, idx) {
            let that = this;
        },

        del(row, idx) {
            let that = this;

            //删除成功后
            that.tableData.splice(idx, 1);
        }
    }
};
</script>
<style lang="less" scoped>
.reminder-table{
    height: 500px;
}
</style>