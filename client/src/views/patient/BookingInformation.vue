<template>
    <el-timeline style="margin-top:20px">
        <el-timeline-item
            timestamp="2018/4/12"
            placement="top"
        >
            <el-card>
                <div style="display:flex">
                    <h4 style="">项目：牙周手术 类型：初诊 主治医生：1212 状态：预约</h4>
                    <i class="el-icon-edit box-content"></i>
                </div>
                <p>备注：</p>
            </el-card>
        </el-timeline-item>
        <el-timeline-item
            timestamp="2018/4/3"
            placement="top"
        >
            <el-card>
                <div style="display:flex">
                    <h4 style="">项目：牙周手术 类型：初诊 主治医生：1212 状态：预约</h4>
                    <i class="el-icon-edit box-content"></i>
                </div>
                <p>备注：</p>
            </el-card>
        </el-timeline-item>
        <el-timeline-item
            timestamp="2018/4/2"
            placement="top"
        >
            <el-card>
                <div style="display:flex">
                    <h4 style="">项目：牙周手术 类型：初诊 主治医生：1212 状态：预约</h4>
                    <i class="el-icon-edit box-content"></i>
                </div>
                <p>备注：</p>
            </el-card>
        </el-timeline-item>
    </el-timeline>
</template>

<script>
export default {
    name: "BookingInformation",
    components: {},
    props: {
        bookingInformation:{}
    },
    data() {
        return {};
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {}
};
</script>
<style lang="less" scoped>
.el-card {
    width: 600px;
}
.box-content {
    cursor: pointer;
    font-size: 20px;
    margin-left: 30px;
    margin-top: 15px;
}
</style>