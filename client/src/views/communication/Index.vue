<template>
    <div class="content">
        <div class="left-content">
            <div class="left-content-title">医患沟通</div>
            <div class="left-tree">
                <el-tree
                    :data="communicationData"
                    :props="defaultProps"
                    @node-click="handleNodeClick"
                >
                    <span
                        class="custom-tree-node"
                        slot-scope="{node, data}"
                    >
                        <i
                            v-if="!node.expanded && data.children && data.children.length"
                            class="fa fa-folder"
                        ></i>
                        <i
                            v-if="node.expanded && data.children && data.children.length"
                            class="fa fa-folder-open"
                        ></i>
                        <i
                            v-if="!data.children"
                            class="fa fa-file-video"
                        ></i>
                        <span>{{ node.label }}</span>
                    </span>

                </el-tree>

            </div>
        </div>
        <div class="right-content">
            <el-row>
                <el-col
                    :span="6"
                    class="video-item"
                >
                    <div class="video-cover">
                        <div class="video-mask">
                            <i class="fa fa-play-circle play-icon"></i>

                            <div class="mask-bottom ">
                                <div class="mask-bottom-left">
                                    <i class="fa fa-plus-square"></i>加入
                                </div>
                                <div class="mask-bottom-right">
                                    <i class="fa fa-heart"></i>收藏
                                </div>
                            </div>

                        </div>
                    </div>
                </el-col>
                <el-col
                    :span="6"
                    class="video-item"
                >
                    <div class="video-cover">
                        <div class="video-mask">
                            <i class="fa fa-play-circle play-icon"></i>

                            <div class="mask-bottom">
                                <div class="mask-bottom-left">
                                    <i class="fa fa-plus-square"></i>加入
                                </div>
                                <div class="mask-bottom-right">
                                    <i class="fa fa-heart"></i>收藏
                                </div>
                            </div>

                        </div>

                    </div>
                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
export default {
    name: "Communication",
    data() {
        return {
            communicationData: [
                {
                    label: "收藏",
                    children: [
                        {
                            label: "收藏"
                        }
                    ]
                },
                {
                    label: "播放列表",
                    children: [
                        {
                            label: "播放列表"
                        }
                    ]
                },

                {
                    label: "儿童",
                    children: [
                        {
                            label: "儿童牙齿"
                        }
                    ]
                },
                {
                    label: "半固定义齿",
                    children: [
                        {
                            label: "半固定义齿1"
                        },
                        {
                            label: "半固定义齿2"
                        }
                    ]
                },
                {
                    label: "口腔宣教",
                    children: [
                        {
                            label: "口腔宣教1"
                        }
                    ]
                }
            ],
            defaultProps: {
                children: "children",
                label: "label"
            },

            videoList: []
        };
    },
    created() {},
    mounted() {},
    watch: {},
    computed: {},
    methods: {
        handleNodeClick(data) {}
    }
};
</script>
<style lang="less" scoped>
.content {
    height: 100%;
    box-sizing: border-box;
    display: flex;

    .left-content {
        height: 100%;
        width: 220px;
        background-color: white;
        border-right: 1px solid #d0d0d0;

        .left-content-title {
            padding: 14px;
            background-color: #efefef;
            border-bottom: 1px solid #d0d0d0;
        }

        .left-tree {
            padding: 5px 0 0 5px;

            .custom-tree-node {
                i {
                    padding-right: 5px;
                }
            }
        }
    }

    .right-content {
        // height: 100%;
        flex: 1 auto;
        padding: 5px;

        .video-item {
            height: 200px;
            padding: 5px;
            box-sizing: border-box;

            .video-cover {
                height: 100%;
                background-color: white;
                border: 1px solid #e3e3e3;
                background-size: 100% 100%;
                background-image: url("../../assets/img/empty.png");
                position: relative;
                cursor: pointer;
                border-radius: 8px;
                overflow: hidden;

                .video-mask {
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    background: rgba(0, 0, 0, 0.3);
                    opacity: 0;
                    transition: all 0.3s;

                    .play-icon {
                        position: absolute;
                        font-size: 50px;
                        left: 50%;
                        top: 50%;
                        transform: translate(-50%, -50%);
                    }

                    .mask-bottom {
                        position: absolute;
                        bottom: 0;
                        width: 100%;

                        i {
                            padding-right: 5px;
                        }

                        .mask-bottom-left,
                        .mask-bottom-right {
                            padding: 5px 10px;
                            transition: 0.2s all;

                            &:hover {
                                color: white;
                            }
                        }

                        .mask-bottom-left {
                            float: left;
                        }

                        .mask-bottom-right {
                            float: right;
                        }
                    }
                }

                &:hover {
                    .video-mask {
                        opacity: 1;
                    }
                }
            }
        }
    }
}
</style>