<template>
    <el-dialog
        title="患者牙齿"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
        width="580px"
    >
        <table
            cellspacing="0"
            class="teeth-content"
            style="width:500px;margin-left:20px;height:200px"
        >
            <tbody>
                <tr>
                    <td
                        v-for="(item, index) in 16"
                        :key="index"
                    > 牙</td>
                </tr>

                <tr>
                    <td
                        v-for="(item, index) in 8"
                        :key="index"
                    >
                        {{ 8 - index }}
                    </td>

                    <td
                        v-for="(item, index) in 8"
                        :key="index"
                    >
                        {{ item }}
                    </td>
                    <!-- <td>8</td>
                    <td>7</td>
                    <td>6</td>
                    <td>5</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <div class="border-right">
                        <td style="border:1px solid red">1</td>
                    </div>
                    <td style="padding-left:10px">1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td></td> -->
                </tr>

                <tr>
                    <!-- 处理颜色 -->
                    <!-- <td>左边</td>
                <td>右边</td> -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>E</td>
                    <td>D</td>
                    <td>C</td>
                    <td style="border:1px solid red">B</td>
                    <td class="border-right">A</td>
                    <td style="padding-left:10px">A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    <td>E</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="right-number">
                            <div class="one">19</div>
                            <div class="tow">29</div>
                        </div>
                    </td>
                </tr>

                <tr class="line">
                    <td
                        colspan="8"
                        class="border-right"
                    >
                        <div class="line-aaa"></div>
                        <span class="line-text">左边</span>
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
                    <td class="xxx">E</td>
                    <td class="xxx">D</td>
                    <td class="xxx">C</td>
                    <td class="xxx">B</td>
                    <td class="border-right xxx">A</td>
                    <td
                        class="xxx"
                        style="padding-left:10px"
                    >A</td>
                    <td class="xxx">B</td>
                    <td class="xxx">C</td>
                    <td class="xxx">D</td>
                    <td class="xxx">E</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="width:20px">
                        <div class="right-number">
                            <div>19</div>
                            <div class="bbbbbbb">29</div>
                        </div>

                    </td>
                </tr>

                <tr>
                    <td
                        v-for="(item, index) in 8"
                        :key="index"
                    >
                        {{ 8 - index }}
                    </td>

                    <td
                        v-for="(item, index) in 8"
                        :key="index"
                    >
                        {{ item }}
                    </td>
                    <!-- <td>8</td>
                    <td>7</td>
                    <td>6</td>
                    <td>5</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td class="border-right">1</td>
                    <td style="padding-left:10px">1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td></td> -->
                </tr>
                <tr>
                    <!-- <td
                        v-for="(item, index) in items"
                        :key="index"
                    >

                    </td> -->
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td style="padding-left:10px">牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>
                    <td>牙</td>

                </tr>

                <tr>
                    <!-- <td v-for="(item, index) in items" :key="index">

                </td> -->

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
.teeth-content {
    text-align: center;
    .xxx {
        cursor: pointer;
        &:hover {
            color: aqua;
            border: 1px solid red;
            border-radius: 60px;
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
    }

    .right-number div {
        position: absolute;
    }

    .one {
        margin-top: -20px;
    }

    .bbbbbbb {
        margin-top: 20px;
    }
    // &:hover{
    //     color: red;
    // }
}
</style>