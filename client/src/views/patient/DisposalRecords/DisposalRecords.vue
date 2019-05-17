<template>
    <div class="disposa_content">
        <div class="disposa_top">
            <div class="background-1">
                <div class="background-2">
                    <div class="background-left">
                        <div class="left-top">
                            <div class="top-1">今天</div>
                            <div class="top-2">17:17</div>
                        </div>
                        <div
                            class="left-bottom"
                            style="display:flex"
                        >
                            <div class="bottom-"></div>
                            <div class="bottom-"></div>
                            <!--  style="border:1px solid red;width:80px;height:0px;margin-top:20px"
 								  style="border:1px solid red;height:20px;width:0px;margin-top:20px" -->
                        </div>
                    </div>
                    <div class="background-right">
                        <div class="right-top">
                            <div class="right-top-1">初诊</div>
                            <div>aaaa</div>
                            <div class="right-i-content">
                                <i class="el-icon-printer right-i"></i>
                                <i class="el-icon-circle-plus-outline right-i"></i>
                                <i class="el-icon-edit right-i"></i>
                                <i class="fa fa-capsules right-i"></i>
                                <i class="fa fa-comments right-i"></i>
                            </div>
                        </div>
                        <div class="right-middle">
                            <div style="display:flex">
                                <input
                                    class="middle-input"
                                    style="margin-left:20px;width:580px"
                                    placeholder="其他"
                                >
                                <i
                                    class="el-icon-circle-plus-outline input-i"
                                    @click="dis_choice"
                                ></i>
                                <input class="middle-input">
                                <input class="middle-input">
                                <input class="middle-input">
                                <i class="el-icon-delete input-i"></i>
                            </div>
                            <div class="underline"></div>
                        </div>
                        <div class="middle-lower">
                            <input
                                class="lower-input"
                                style=" height: 20px;
                                        background-color: #f8f8f8;
                                        margin-top: 10px;
                                        margin-left: 20px;
                                        width: 930px;
                                        border: 0;"
                            >
                            <div class="underline"></div>
                        </div>
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
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.disposa_content {
    height: 100%;
    .disposa_top {
        // border: 1px solid red;
        height: 800px;
        width: 100%;
        position: relative;
        margin-bottom: 10px;
        .background-1 {
            border: 1px solid rgb(202, 202, 202);
            width: 1180px;
            height: 150px;
            margin-top: 10px;
            margin-left: 10px;
            background-color: rgb(202, 202, 202);
        }
        .background-2 {
            display: flex;
            border: 1px solid #f8f8f8;
            height: 140px;
            width: 1145px;
            margin-top: 5px;
            margin-left: 30px;
            background-color: #f8f8f8;
            .background-left {
                // border: 1px solid red;
                height: 140px;
                width: 170px;
                .left-top {
                    font-weight: bold;
                    display: flex;
                    margin-top: 5px;
                    font-size: 20px;
                    .top-1 {
                        margin-right: 30px;
                        margin-left: 10px;
                    }
                    .top-2 {
                    }
                }
                .left-bottom {
                    border: 1px solid red;
                    height: 70px;
                    margin-top: 10px;
                }
            }
            .background-right {
                // border: 1px solid red;
                height: 140px;
                width: 985px;
                .right-top {
                    font-weight: bold;
                    margin-top: 5px;
                    margin-left: 100px;
                    display: flex;
                    font-size: 20px;
                    .right-top-1 {
                        margin-right: 50px;
                    }
                    .right-i-content {
                        margin-left: 570px;
                        .right-i {
                            font-size: 20px;
                            cursor: pointer;
                            margin-right: 10px;
                        }
                    }
                }
                .right-middle {
                    margin-top: 10px;
                    .middle-input {
                        width: 90px;
                        height: 20px;
                        background-color: #f8f8f8;
                        border: 0;
                        margin: 0 5px;

                        &:focus {
                            background: white;
                        }
                    }
                    .input-i {
                        font-size: 20px;
                        cursor: pointer;
                        margin-left: 5px;
                        // &:hover {
                        //     i: blue;
                        // }
                    }
                    input::-webkit-input-placeholder {
                        color: #000;
                    }
                    .middle-lower {
                        margin-top: 20px;
                        .lower-input {
                            height: 20px;
                            background-color: #f8f8f8;
                            margin-top: 10px;
                            margin-left: 20px;
                            width: 930px;
                            border: 0;
                        }
                    }
                }
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
                    margin-left: 20px;
                    width: 930px;
                    border: 0.5px solid #d5d5d5;
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