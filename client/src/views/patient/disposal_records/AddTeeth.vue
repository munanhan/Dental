<template>
    <el-dialog
        title="患者牙齿"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="630px"
    >
        <table
            cellspacing="0"
            border="0"
            class="teeth-content"
            style=""
        >
            <tbody>
                <tr>

                    <td
                        v-for="(item, index) in 8"
                        :key="'top-teeth1' +index"
                    > 牙</td>
                    <td></td>
                    <td
                        v-for="(item, index) in 8"
                        :key="'top-teeth2' +index"
                    > 牙</td>
                </tr>

                <tr>

                    <td
                        v-for="(item, index) in 8"
                        :key="'top-num1' +index"
                    >
                        <div class="select-cell">
                            {{ 8 - index }}
                        </div>
                    </td>

                    <td class="line-container">
                        <div class="v-line"></div>
                    </td>

                    <td
                        v-for="(item, index) in 8"
                        :key="'top-num2' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <!-- 处理颜色 -->
                    <!-- <td>左边</td>
                <td>右边</td> -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td
                        v-for="(item, index) in 'ABCDE'"
                        :key="'top-alphabet1' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>
                    <td class="line-container">
                        <div class="v-line"></div>
                    </td>

                    <td
                        v-for="(item, index) in 'EDCBA'"
                        :key="'top-alphabet2' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="right-number">
                            <div class="one">19</div>
                            <div class="two">29</div>
                        </div>
                    </td>
                </tr>

                <tr class="line">
                    <td colspan="8">
                        <div class="line-aaa"></div>
                        <span class="line-text">左边</span>
                    </td>

                    <td class="line-container">
                        <div class="v-line"></div>
                        <div class="h-line"></div>
                    </td>

                    <td colspan="8">
                        <div class="line-aaa"></div>
                        <span class="line-text">右边</span>
                    </td>
                    <td></td>
                </tr>
                <!-- <tr>
                    <td></td>
                </tr> -->
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td
                        v-for="(item, index) in 'ABCDE'"
                        :key="'bottom-alphabet1' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>

                    <td class="line-container">
                        <div class="v-line"></div>
                    </td>

                    <td
                        v-for="(item, index) in 'EDCBA'"
                        :key="'bottom-alphabet2' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:20px">
                        <div
                            class="right-number"
                            style="margin-top:20px"
                        >
                            <div class="one">39</div>
                            <div class="two">49</div>
                        </div>

                    </td>
                </tr>

                <tr>
                    <td
                        v-for="(item, index) in 8"
                        :key="'bottom-num1' +index"
                    >
                        <div class="select-cell">
                            {{ 8 - index }}
                        </div>
                    </td>

                    <td class="line-container">
                        <div class="v-line"></div>
                    </td>

                    <td
                        v-for="(item, index) in 8"
                        :key="'bottom-num2' +index"
                    >
                        <div class="select-cell">
                            {{ item }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td
                        v-for="(item, index) in 17"
                        :key="'bottom-teeth1' +index"
                    >
                        <template v-if="index != 8">
                            牙
                        </template>
                    </td>
                </tr>
            </tbody>

        </table>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">取 消</el-button>
            <el-button
                :loading="commitLoading"
                type="primary"
            >确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "@/views/base/DialogForm";
export default {
    name: "AddTeeth",

    mixins: [DialogForm],

    data() {
        return {};
    },

    methods: {}
};
</script>
<style lang="less" scoped>
/deep/ .el-dialog__body {
    height: 200px;
}

.transition2 {
    transition: all 0.2s;
}

.teeth-content {
    text-align: center;
    width: 580px;
    margin-left: 20px;
    height: 200px;
    .select-cell {
        border: 1px solid white;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        line-height: 30px;
        box-sizing: border-box;
        cursor: pointer;
        .transition2;

        &:hover {
            border-color: #e3e3e3;
            background-color: #f8f8f8;
        }
    }

    .line-container {
        position: relative;

        .v-line {
            height: 120%;
            width: 1px;
            border-right: 1px solid black;
            top: 0;
            position: absolute;
            left: 50%;
            margin-left: -1px;
        }

        .h-line {
            width: 120%;
            height: 1px;
            padding-top: 50%;
            border-top: 1px solid black;
            left: -2px;
            position: absolute;
            top: 3px;
        }
    }
    .border-right {
        border-right: 1px solid black;
        // padding: 10px;
        // margin: 0;
    }

    .line {
        text-align: center;
    }

    .line-aaa {
        height: 1px;
        background-color: black;
    }

    .line-text {
        font-size: 10px;
        position: absolute;
        margin-top: -7px;
        background-color: white;
    }

    .right-number {
        position: relative;
        margin-top: -10px;
        .one {
            margin-top: -28px;
            border: 1px solid white;
            border-radius: 50%;
            cursor: pointer;
            height: 25px;
            width: 25px;
            line-height: 25px;
            .transition2;
            &:hover {
                border-color: #e3e3e3;
                background-color: #f8f8f8;
            }
        }
        .two {
            border: 1px solid white;
            border-radius: 50%;
            height: 25px;
            width: 25px;
            line-height: 25px;
            cursor: pointer;
            .transition2;
            &:hover {
                border-color: #e3e3e3;
                background-color: #f8f8f8;
            }
        }
    }

    .right-number div {
        position: absolute;
    }
}
</style>