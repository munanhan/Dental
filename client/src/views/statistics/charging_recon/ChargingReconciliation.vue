<template>
    <div class="chargin-recon">
        <div class="left-content">
            <el-menu
                default-active="tollSheet"
                @select="selectHandler"
            >
                <el-menu-item index="tollSheet">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">收费单</span>
                </el-menu-item>
                <el-menu-item index="reconCalendar">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">对账日历</span>
                </el-menu-item>
                <el-menu-item index="arrearsPatient">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">欠费患者</span>
                </el-menu-item>
                <el-menu-item index="advancePayment">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">预交款</span>
                </el-menu-item>
                <el-menu-item index="flowSheet">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">流水单</span>
                </el-menu-item>
                <el-menu-item index="prepaidBalance">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">预交款余额</span>
                </el-menu-item>
                <el-menu-item index="expenditureDetails">
                    <i class="fa fa-file-alt menu-icon"></i>
                    <span slot="title">支出明细</span>
                </el-menu-item>
            </el-menu>
        </div>
        <div class="right-content">

            <!-- 预交款 -->
            <advance-payment
                v-show="content.advancePayment"
                :update="advancePaymentUpdate"
            ></advance-payment>

            <!-- 欠费患者 -->
            <arrears-patient
                v-show="content.arrearsPatient"
                :update="arrearsPatientUpdate"
            ></arrears-patient>

            <!-- 支出明细 -->
            <expenditure-details
                v-show="content.expenditureDetails"
                :update="expenditureDetailsUpdate"
            ></expenditure-details>

            <!-- 流水单 -->
            <flow-sheet
                v-show="content.flowSheet"
                :update="flowSheetUpdate"
            ></flow-sheet>

            <!-- 预交款余额 -->
            <prepaid-balance
                v-show="content.prepaidBalance"
                :update="prepaidBalanceUpdate"
            ></prepaid-balance>

            <!-- 对账日历 -->
            <recon-calendar
                v-show="content.reconCalendar"
                :update="reconCalendarUpdate"
            ></recon-calendar>

            <!-- 收费单 -->
            <toll-sheet
                v-show="content.tollSheet"
                :update="tollSheetUpdate"
            ></toll-sheet>
        </div>
    </div>
</template>

<script>
import AdvancePayment from "./AdvancePayment";
import ArrearsPatient from "./ArrearsPatient";
import ExpenditureDetails from "./ExpenditureDetails";
import FlowSheet from "./FlowSheet";
import PrepaidBalance from "./PrepaidBalance";
import ReconCalendar from "./ReconCalendar";
import TollSheet from "./TollSheet";

export default {
    name: "ChargingReconciliation",
    components: {
        AdvancePayment,
        ArrearsPatient,
        ExpenditureDetails,
        FlowSheet,
        PrepaidBalance,
        ReconCalendar,
        TollSheet
    },

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            content: {
                tollSheet: true,
                reconCalendar: false,
                arrearsPatient: false,
                advancePayment: false,
                flowSheet: false,
                prepaidBalance: false,
                expenditureDetails: false
            },

            tollSheetUpdate: false,
            reconCalendarUpdate: false,
            arrearsPatientUpdate: false,
            advancePaymentUpdate: false,
            flowSheetUpdate: false,
            prepaidBalanceUpdate: false,
            expenditureDetailsUpdate: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                for (var key in that.content) {
                    if (that.content[key]) {
                        that[key + "Update"] = true;
                    }
                }
            }
        }
    },

    computed: {},
    methods: {
        selectHandler(index) {
            let that = this;
            that.content.tollSheet = "tollSheet" == index;
            that.tollSheetUpdate = "tollSheet" == index;

            that.content.reconCalendar = "reconCalendar" == index;
            that.reconCalendarUpdate = "reconCalendar" == index;

            that.content.arrearsPatient = "arrearsPatient" == index;
            that.arrearsPatientUpdate = "arrearsPatient" == index;

            that.content.advancePayment = "advancePayment" == index;
            that.advancePaymentUpdate = "advancePayment" == index;

            that.content.flowSheet = "flowSheet" == index;
            that.flowSheetUpdate = "flowSheet" == index;

            that.content.prepaidBalance = "prepaidBalance" == index;
            that.prepaidBalanceUpdate = "prepaidBalance" == index;

            that.content.expenditureDetails = "expenditureDetails" == index;
            that.expenditureDetailsUpdate = "expenditureDetails" == index;
        },

        afterGetData(res) {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
.chargin-recon {
    display: flex;
    position: relative;
    height: 100%;
    box-sizing: border-box;

    .left-content {
        width: 150px;

        border-right: 1px solid #e3e3e3;

        .menu-icon {
            margin-right: 10px;
        }
    }

    .right-content {
        flex: 1 auto;
        overflow: auto;
    }
}
</style>