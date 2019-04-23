<template>
    <el-dialog
        title="预约状态"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog reservation-status"
        :close-on-click-modal="false"
        v-dialog-drag
        width="1200px"
        top="2vh"
    >
        <div class="dialog-content">

            <el-table
                border
                class="width100 status-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
            >
                <el-table-column
                    label="患者姓名"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="预约日期"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="预约医生"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="就诊类型"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="事项"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="性别"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="患者来源"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="预约备注"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
        </div>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">关闭</el-button>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../../base/DialogForm";
export default {
    name: "ReservationStatus",

    mixins: [DialogForm],

    components: {},
    props: {},
    data() {
        return {
            tableData: []
        };
    },
    created() {},
    watch: {},
    computed: {},

    mounted() {
        let that = this;
        that.getData();
    },
    methods: {
        getData() {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
.reservation-status {
    .status-table {
        min-height: 300px;
    }
}
</style>