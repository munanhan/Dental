<template>
    <div>
        <el-dialog
            title="连锁店管理"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog chain-store"
            :close-on-click-modal="false"
            v-dialog-drag
            width="810px"
            top="2vh"
        >
            <el-tabs v-model="activeName">
                <el-tab-pane
                    label="分店管理"
                    name="chainStoreManagement"
                >
                    <div class="store-container">
                        <div
                            v-if="activeName == 'chainStoreManagement'"
                            class="add-store"
                        >
                            <el-button
                                type="primary"
                                @click="addStoreDialog = true"
                                size="medium"
                            >新增分店</el-button>
                        </div>

                        <div class="store-item">
                            <div
                                class="content"
                                @click="showInfo('1')"
                            >
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>

                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                        <div class="store-item">
                            <div class="content">
                                <div class="title">分店信息</div>
                                <div class="info">测试</div>
                                <div class="info">3116</div>
                                <div class="info">root</div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>

                <el-tab-pane
                    label="员工管理"
                    name="StaffManagement"
                >

                </el-tab-pane>

                <el-tab-pane
                    label="连锁信息"
                    name="chainInformation"
                >

                </el-tab-pane>

            </el-tabs>
        </el-dialog>

        <chain-store-info-dialog :show.sync="showInfoDialog"></chain-store-info-dialog>
        <add-store-dialog :show.sync="addStoreDialog"></add-store-dialog>
    </div>
</template>

<script>
import DialogForm from "../../base/DialogForm";
import ChainStoreInfoDialog from "./ChainStoreInfoDialog";
import AddStoreDialog from "./AddStoreDialog";
export default {
    name: "ChainStore",
    mixins: [DialogForm],

    components: { ChainStoreInfoDialog, AddStoreDialog },
    props: {},
    data() {
        return {
            activeName: "chainStoreManagement",
            showInfoDialog: false,

            addStoreDialog: false,
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        showInfo(id) {
            let that = this;

            that.showInfoDialog = true;
        }
    }
};
</script>
<style lang="less" scoped>
.transition-3 {
    transition: all 0.3s;
}

.chain-store {
    /deep/ .el-dialog__body {
        height: 530px;
        padding: 0;

        .el-tabs__content {
            overflow: unset;
        }
    }

    .store-container {
        width: 100%;
        height: 100%;
        overflow: auto;

        .add-store {
            position: absolute;
            right: 10px;
            top: -38px;
            z-index: 9999;
        }

        .store-item {
            display: inline-block;
            height: 230px;
            width: 200px;
            padding: 16px 10px 10px;
            box-sizing: border-box;

            .content {
                border: 1px solid #e3e3e3;
                border-radius: 8px;
                height: 100%;
                background-color: #f7c466;
                text-align: center;
                cursor: pointer;
                .transition-3;

                &:hover {
                    transform: translateY(-6px);
                    box-shadow: 6px 6px 6px #e3e3e3;
                }

                .title {
                    padding: 20px;
                    font-size: 18px;
                    font-weight: bold;
                    color: #a06904;
                }

                .info {
                    padding: 10px;
                    font-size: 16px;
                    font-weight: bold;
                }
            }
        }
    }
}
</style>