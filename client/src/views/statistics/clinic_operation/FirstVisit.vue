<template>
    <el-dialog
        title="初复诊记录明细"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog first-visit"
        :close-on-click-modal="false"
        v-dialog-drag
        width="800px"
        top="2vh"
    >
    <div class="dialog-content">

        <el-table
            border
            class="width100 visit-table"
            :data="tableData"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
            show-summary
        >
            <el-table-column
                label="就诊日期"
                width="120"
                align="center"
            >
            </el-table-column>
            <el-table-column
                prop="name"
                label="病历号"
                width="120"
                align="center"
            >
            </el-table-column>
            <el-table-column
                prop="address"
                label="姓名"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="address"
                label="电话"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <el-table-column
                prop="address"
                label="医生"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column>
            <!-- <el-table-column
                prop="address"
                label="电话2"
                align="center"
                show-overflow-tooltip
            >
            </el-table-column> -->
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
    name: "FirstVisit",

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
.first-visit {

    .dialog-content{
        padding: 10px 0;
    }
    
    .visit-table{
        min-height: 300px;
    }    

}
</style>