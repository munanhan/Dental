<template>
    <div>
        <el-table
            border
            class="charge-top"
            height="800px"
            width="100%"
            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
        >
            <div>
                <el-table-column
                    prop="date"
                    label="状态"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="单据号"
                    width="80"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="收费时间"
                    align="center"
                    width="160"
                >
                </el-table-column>
                <el-table-column
                    prop="date"
                    label="医生"
                    width="60"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="收款员"
                    width="70"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="本次费用"
                    width="90"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="date"
                    label="实收金额"
                    width="90"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="折扣金额"
                    width="90"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="欠费"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="date"
                    label="账单时间"
                    width="160"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="护士"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="备注"
                    width="150"
                    align="center"
                >
                </el-table-column>
            </div>
        </el-table>
        <div class="charge-bottom">
            <el-button
                class="button"
                type="primary"
                @click="Charge"
            >收费</el-button>
            <el-select
                v-model="value"
                placeholder="其他"
                class="button"
                @change="dialogshow(value)"
            >
                <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                >

                </el-option>
            </el-select>
            <!-- <el-button class="button" @mouseover.native="otherIsShow">其他
        <i
          class="fa fa-chevron-up"
          style="margin-left:30px"
        ></i>
        <ul class="other" :class="{'no-show':otherShow}">
          <li
            v-for="item in options"
            :key="item.value"
            @click.stop="dialogshow(item.value)"
          >{{item.label}}</li>

        </ul>
      </el-button> -->

            <el-button
                class="button"
                @click="Advan_pay"
            >预交款</el-button>
            <el-button
                class="button"
                @click="Water_sin"
            >流水单</el-button>
        </div>
        <!-- <div style="flex:">asd</div> -->
        <charge
            :show.sync="charge_show"
            :charge="charInfo"
        ></charge>
        <refund
            :show.sync="Refund"
            :addrefun="charInfo"
        ></refund>
        <charging-set :show.sync="ChargingSet"></charging-set>
        <invalid :show.sync="Invalid"></invalid>
        <print :show.sync="Print"></print>
        <print-set :show.sync="PrintSet"></print-set>
        <advance-payment
            :show.sync="advancepay_show"
            :deposit="charInfo"
        ></advance-payment>
        <water-single :show.sync="watersin_show"></water-single>
    </div>
</template>

<script>
import Refund from "./Refund.vue";
import ChargingSet from "./ChargingSet.vue";
import Invalid from "./Invalid.vue";
import Print from "./Print.vue";
import PrintSet from "./PrintSet.vue";
import AdvancePayment from "./AdvancePayment.vue";
import WaterSingle from "./WaterSingle.vue";
import Charge from "./Charge.vue";
export default {
    name: "ChargeInfo",
    components: {
        Charge,
        Refund,
        ChargingSet,
        Invalid,
        Print,
        PrintSet,
        AdvancePayment,
        WaterSingle
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        },
        charInfo: {
            //type: Object,
            required: true
        }
    },
    data() {
        return {
            Refund: false,
            ChargingSet: false,
            Invalid: false,
            Print: false,
            PrintSet: false,
            advancepay_show: false,
            watersin_show: false,
            charge_show: false,
            otherShow: true,

            options: [
                {
                    value: "Refund",
                    label: "退费"
                },
                {
                    value: "Invalid",
                    label: "作废"
                },
                {
                    value: "Print",
                    label: "打印"
                },
                {
                    value: "ChargingSet",
                    label: "收费设置"
                },
                {
                    value: "PrintSet",
                    label: "打印设置"
                }
            ],
            value: ""
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getChargeInfo();
            }
        }
    },
    computed: {},
    methods: {
        // otherIsShow(){
        //  this.otherShow=false;
        //   console.log(1111);
        // },
        // otherIsNoShow(){
        //    this.otherShow=true;
        //   console.log(2222);
        // },
        dialogshow(value) {
            this[value] = true;
            this.value = "";
        },
        getChargeInfo() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        Advan_pay() {
            // let that = this;
            // if (thta.charInfo.id) {
            //     this.advancepay_show = true;
            // } else {
            //     that.$message.warning("请选择一个患者");
            // }

            this.advancepay_show = true;
        },
        Water_sin() {
            this.watersin_show = true;
        },
        Charge() {
            let that = this;
            if (that.charInfo.id) {
                this.charge_show = true;
            } else {
                that.$message.warning("请选择一个患者");
            }

            // this.charge_show = true;
        }
    }
};
</script>

<style lang="less" >
//导入全局的颜色
@import "~@css/var";

.charge-top {
    width: 100%;
    // border: 1px solid red;
    height: 500px;
    margin: 0;
    padding: 0;
    position: relative;
}
.charge-bottom {
    height: 60px;
    position: absolute;
    left: 0;
    bottom: 0;
    background-color: #e3e3e3;
    width: 100%;
    // .other {
    //   &.no-show {
    //     display: none;
    //   }

    //   list-style: none;
    //   margin-left: -21px;
    //   position: absolute;
    //   top: -190px;
    //   width: 88px;
    //   -webkit-box-shadow: 1px 1px 5px #b3b3b3;
    //   li {
    //     width: 128px;
    //     padding: 10px 0px;
    //     margin-left: -40px;
    //     &:hover {
    //       background-color: rgb(240, 240, 240);
    //     }
    //   }
    // }
}

.button {
    width: 130px;
    margin-top: 10px;
    margin-left: 10px;
}
</style>