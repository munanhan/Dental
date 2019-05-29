<template>
    <div class="disposa_content">
        <div class="disposa_top">
            <!-- <div class="background-1"> -->
            <div class="medical-top">
                <div class="background">
                    <div class="background-left">
                        <div class="left-top">
                            <div> &nbsp;&nbsp; 2019-05-17 &nbsp;&nbsp; 23:20</div>
                        </div>
                        <div class="left-bottom">
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
                        <div class="right-top">
                            <div style="">初诊 &nbsp; 1212</div>
                            <div class="right-i-content">
                                <i
                                    class="el-icon-printer right-i"
                                    effect="dark"
                                    content="上移"
                                    placement="bottom"
                                ></i>
                                <i class="fa fa-newspaper right-i"></i>
                                <i class="el-icon-edit right-i"></i>
                                <i class="fa fa-capsules right-i"></i>
                                <i class="fa fa-comments right-i"></i>
                            </div>
                        </div>
                        <div class="right-middle">
                            <div style="display:flex">
                                <input
                                    class="middle-input"
                                    style="width:500px;margin-left:10px"
                                    placeholder="其他"
                                >
                                <i
                                    class="el-icon-circle-plus-outline input-i"
                                    @click="dis_choice"
                                ></i>
                                <input
                                    style="margin-left:30px"
                                    class="middle-input"
                                    placeholder="单价"
                                    type="text"
                                    value="0.00"
                                    onfocus="if(value=='0.00') {value=''}"
                                    onblur="if (value=='') {value='0.00'}"
                                    oninput="value=value.replace(/[^\d]/g,'')"
                                >
                                <input
                                    class="middle-input"
                                    type="text"
                                    value="1"
                                    onfocus="if(value=='1') {value=''}"
                                    onblur="if (value=='') {value='1'}"
                                >
                                <input
                                    class="middle-input"
                                    placeholder="费用"
                                    type="text"
                                    value="0.00"
                                    onfocus="if(value=='0.00') {value=''}"
                                    onblur="if (value=='') {value='0.00'}"
                                >
                                <i class="el-icon-delete input-i"></i>
                            </div>
                            <div class="underline"></div>
                        </div>
                        <input class="lower-input">
                        <div class="underline"></div>
                        <div class="right-bottom">
                            <div class="bottom-1">合计</div>
                            <div>100.00</div>
                        </div>
                    </div>
                </div>
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
    </div>

</template>

<script>
// import DisposalChoice from "@/views/base/DisposalChoice";
import DisposalChoice from "./DisposalChoice";
export default {
    name: "DisposalRecords",

    components: {
        DisposalChoice
    },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            dischoice_show: false
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
    computed: {},
    methods: {
        getDisposalRecords() {},

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        },
        dis_choice() {
            this.dischoice_show = true;
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
        position: relative;
        margin-bottom: 10px;
        .medical-top {
            .background {
                margin-right: 15px;
                .transition-2;
                display: flex;
                // width: 1145px;
                margin-top: 5px;
                margin-left: 20px;
                background-color: #f8f8f8;
                border: 2px solid #e3e3e3;
                border-left-width: 10px;
                padding: 10px;
                color: #989797;
                &:hover {
                    color: @color;
                    border-color: @color;
                }
                .background-left {
                    // border:1px solid red;
                    width: 220px;
                    .left-top {
                        // border:1px solid red;
                        font-weight: bold;
                        display: flex;
                        margin-top: 5px;
                        font-size: 20px;
                        // .top-1 {
                        //     margin-right: 30px;
                        //     margin-left: 10px;
                        // }
                        // .top-2 {
                        // }
                    }
                    .left-bottom {
                        // border: 1px solid red;
                        cursor: pointer;
                        .diagnose-detail {
                            border: 1px solid #f8f8f8;
                            display: flex;
                            margin-top: 15px;

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
                            &:hover{
                                color: #1d1d1d;
                                border: 1px solid #cfcfcf;
                            }
                        }
                    }
                }
                .background-right {
                    // border: 1px solid red;
                    .right-top {
                        // border: 1px solid red;
                        font-weight: bold;
                        margin-left:20px;
                        margin-top: 3px;
                        display: flex;
                        font-size: 20px;
                        .right-i-content {
                            // border: 1px solid red;
                            margin-left: 620px;
                            .right-i {
                                // border: 1px solid red;
                                font-size: 20px;
                                cursor: pointer;
                                margin-right: 10px;
                            }
                        }
                    }
                    .right-middle {
                        // border: 1px solid red;
                        margin-top: 10px;
                        .middle-input {
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
                        .input-i {
                            font-size: 20px;
                            cursor: pointer;
                        }
                        // input::-webkit-input-placeholder {
                        //     color: #000;
                        // }
                        // .middle-lower {
                        //     margin-top: 20px;
                        // }
                    }
                    .lower-input {
                        margin-left: 10px;
                        background-color: #f8f8f8;
                        margin-top: 10px;
                        width: 900px;
                        border: 1px solid #f8f8f8;
                        &:focus {
                            background: white;
                        }
                        &:hover {
                            border: 1px solid #cfcfcf;
                        }
                    }
                    // &:hover {
                    // }
                    .right-bottom {
                        display: flex;
                        font-size: 23px;
                        color: rgb(96, 96, 96);
                        margin-top: 5px;
                        height: 60px;
                        float: right;
                        margin-right: 30px;
                        width: 180px;
                        .bottom-1 {
                            margin-left: 30px;
                            margin-right: 30px;
                        }
                    }
                    .underline {
                        margin-left: 10px;
                        width: 900px;
                        border: 0.5px solid #d5d5d5;
                    }
                }
            }
        }
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