<template>
    <div class="disposa_content">
        <div class="disposa_top">
            <div class="background">
                <div class="top-content">
                    <div style="flex: 1; text-align:left;">
                        <div class="top">{{disposa_date}}</div>
                        <div class="top">{{disposa_time}}</div>
                        <div class="top">{{disposa_diagnosis}}</div>
                        <div class="top">{{disposa_doctor}}</div>
                    </div>
                    <div
                        class="right-i-content"
                        style="text-align:right;"
                    >
                        <i class="el-icon-printer right-i"></i>
                        <i class="fa fa-newspaper right-i"></i>
                        <i
                            class="fa fa-pen right-i"
                            @click="addDisposal"
                        ></i>
                        <i class="fa fa-capsules right-i"></i>
                        <i class="fa fa-comments right-i"></i>
                    </div>
                </div>
                <div
                    class="item"
                    v-for="(item,index) in disposa"
                    :key="index"
                >
                    <div class="background-left">
                        <div
                            class="left-bottom"
                            @click="add_teeth"
                        >
                            <div class="diagnose-detail">
                                <div class="tooth">
                                    <div class="tooth-row">
                                        <div class="tooth-left">12345678</div>
                                        <div class="tooth-right">12345678</div>
                                    </div>
                                    <div class="tooth-row">
                                        <div class="tooth-left">12345678</div>
                                        <div class="tooth-right">12345678</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="background-right">
                        <div class="right-middle">
                            <div style="display:flex">
                                <input
                                    class="middle-input1"
                                    placeholder="其他"
                                >
                                <i
                                    class="el-icon-circle-plus-outline input-i"
                                    @click="dis_choice"
                                ></i>
                                <input
                                    style="margin-left:20px"
                                    class="middle-input"
                                    placeholder="单价"
                                    type="text"
                                    v-model="item.disposa_price"
                                    @blur="item.disposa_price =toDecimal(item.disposa_price)"
                                >
                                <input
                                    class="middle-input"
                                    type="text"
                                    v-model="item.disposa_amount"
                                    onfocus="if(value=='1') {value=''}"
                                    onblur="if (value=='') {value='1'}"
                                >
                                <input
                                    class="middle-input"
                                    placeholder="费用"
                                    type="text"
                                    :value="toDecimal(item.disposa_amount * item.disposa_price)"
                                    disabled
                                >
                                <i
                                    class="fa fa-trash-alt input-i"
                                    @click="delDisposal"
                                ></i>
                            </div>
                            <div class="underline"></div>
                        </div>
                        <input class="lower-input">
                        <div class="underline"></div>

                    </div>
                </div>
                <div
                    class="right-bottom pull-right"
                    style=""
                >
                    <div style="margin-right:10px">合计</div>
                    <div>{{total}}</div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="disposa_bottom">
            <el-button
                class="dis-button"
                type="primary"
            >增加处置</el-button>

            <!-- <el-button class="dis-button">打印设置</el-button> -->
        </div>
        <disposal-choice :show.sync="dischoice_show"></disposal-choice>
        <add-teeth :show.sync="addteeth_show"></add-teeth>

    </div>

</template>

<script>
// import DisposalChoice from "@/views/base/DisposalChoice";
import DisposalChoice from "./DisposalChoice";
import AddTeeth from "./AddTeeth";
export default {
    name: "DisposalRecords",

    components: {
        DisposalChoice,
        AddTeeth
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            dischoice_show: false,
            addteeth_show: false,
            disposa_date: "1972-05-01",
            disposa_time: "23:14",
            disposa_diagnosis: "初诊",
            disposa_doctor: "马医生",

            disposa: [
                {
                    disposa_item: "",
                    disposa_price: "",
                    disposa_amount: "1"
                }
            ]
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getDisposalRecords();
            }
        }
    },
    computed: {
        total() {
            var sum = 0;
            this.disposa.forEach(element => {
                if (element.disposa_price) {
                    sum +=
                        parseFloat(element.disposa_amount) *
                        parseFloat(element.disposa_price);
                }
            });
            return this.toDecimal(sum);
        }
    },
    methods: {
        getDisposalRecords() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        dis_choice() {
            this.dischoice_show = true;
        },
        add_teeth() {
            this.addteeth_show = true;
        },

        //新增
        addDisposal() {
            this.disposa.push({});
        },

        //删除
        delDisposal(index) {
            this.disposa.splice(index - 1, 1);
        },

        toDecimal: function(x) {
            var f = parseFloat(x);
            if (isNaN(f)) {
                return "";
            }
            var f = Math.round(x * 100) / 100;
            var s = f.toString();
            var rs = s.indexOf(".");
            if (rs < 0) {
                rs = s.length;
                s += ".";
            }
            while (s.length <= rs + 2) {
                s += "0";
            }
            return s;
        },
        del(row, index) {
            let that = this;
            that.tableData.splice(index, 1);
        }
    }
};
</script>
<style lang="less" >
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.disposa_content {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    height: 100%;

    .disposa_top {
        height: 100%;
        width: 100%;
        overflow: auto;
        position: relative;
        margin-bottom: 10px;
        .background {
            margin-right: 15px;
            .transition-2;
            margin-top: 5px;
            margin-left: 20px;
            background-color: #f8f8f8;
            border: 2px solid #e3e3e3;
            border-left-width: 10px;
            padding: 10px;
            color: #989797;
            &:hover {
                border-color: @color;
                color: @color;
            }
            .top-content {
                display: flex;
                justify-content: space-around;
                .top {
                    margin-right: 20px;
                    display: inline-block;
                    cursor: pointer;
                    font-weight: bold;
                    font-size: 20px;
                    border: 1px solid #f8f8f8;
                    &:hover {
                        border: 1px solid #bebebe;
                    }
                }
                .right-i-content {
                    // border: 1px solid red;
                    // margin-left: 600px;
                    .right-i {
                        // border: 1px solid red;
                        font-size: 20px;
                        cursor: pointer;
                        margin-right: 10px;
                    }
                    :hover {
                        color: #332222;
                        transition: all 0.3s;
                    }
                }
            }
            .item {
                display: flex;
                .background-left {
                    // border:1px solid red;
                    width: 220px;

                    .left-bottom {
                        // border: 1px solid red;
                        margin-top: 15px;
                        cursor: pointer;
                        .diagnose-detail {
                            border: 1px solid #f8f8f8;
                            display: flex;
                            color: #1d1d1d;

                            .tooth {
                                width: 220px;

                                .tooth-row {
                                    display: flex;
                                    font-size: 16px;

                                    &:not(:last-of-type) {
                                        border-bottom: 2px solid #1d1d1d;
                                        transition: border 0.2s;
                                    }

                                    &:last-of-type {
                                        .tooth-left,
                                        .tooth-right {
                                            padding-top: 6px;
                                        }
                                    }

                                    > div {
                                        flex: 1 auto;
                                    }

                                    .tooth-left {
                                        border-right: 2px solid #1d1d1d;
                                        text-align: right;
                                        transition: border 0.2s;
                                    }

                                    .tooth-right {
                                        padding: 0 0 6px 6px;
                                    }

                                    .tooth-left,
                                    .tooth-right {
                                        letter-spacing: 2px;
                                    }
                                }
                            }
                            &:hover {
                                border: 1px solid #cfcfcf;
                            }
                        }
                    }
                }
                .background-right {
                    // border: 1px solid red;
                    width: 100%;

                    .right-middle {
                        // border: 1px solid red;
                        width: 100%;
                        margin-top: 10px;
                        .middle-input1 {
                            width: 100%;
                            margin-right: 10px;
                            background-color: #f8f8f8;
                            border: 1px solid #f8f8f8;
                            &:focus {
                                background: white;
                            }
                            &:hover {
                                border: 1px solid #cfcfcf;
                            }
                        }
                        .middle-input {
                            display: flex;
                            width: 100px;
                            height: 20px;
                            background-color: #f8f8f8;
                            border: 1px solid #f8f8f8;
                            margin: 0 5px;
                            &:focus {
                                background: white;
                            }
                            &:hover {
                                border: 1px solid #cfcfcf;
                            }
                        }

                        // input::-webkit-input-placeholder {
                        //     color: #000;
                        // }
                        // .middle-lower {
                        //     margin-top: 20px;
                        // }
                        .input-i {
                            font-size: 20px;
                            cursor: pointer;
                        }
                    }
                    .lower-input {
                        margin-right: 15px;
                        background-color: #f8f8f8;
                        margin-top: 10px;
                        width: 100%;
                        border: 1px solid #f8f8f8;
                        &:focus {
                            background: white;
                        }
                        &:hover {
                            border: 1px solid #cfcfcf;
                        }
                    }
                    .right-i-content {
                        // border: 1px solid red;
                        margin-left: 600px;
                        .right-i {
                            // border: 1px solid red;
                            font-size: 20px;
                            cursor: pointer;
                            margin-right: 10px;
                        }
                        :hover {
                            color: #332222;
                            transition: all 0.3s;
                        }
                    }
                    // &:hover {
                    // }

                    .underline {
                        margin-right: 15px;
                        width: 100%;
                        border: 0.5px solid #d5d5d5;
                    }
                }
            }
        }
    }
    .right-bottom {
        display: flex;
        font-size: 23px;
    }
    .disposa_bottom {
        background-color: #e3e3e3;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 59px;
        .dis-button {
            width: 130px;
            margin-left: 10px;
            margin-top: 10px;
        }
    }
}
</style>