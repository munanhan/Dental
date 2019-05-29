<template>
    <div class="clinic-info">
        <div class="clinic-item">
            <div class="title">
                <i class="fa fa-link mr-10 store"></i>
                <span>连锁机构</span>
            </div>
            <div class="org-content clearfix">
                机构名称： <span class="tip">{{tableData.company_name}}</span>

                <div class="pull-right">
                    <el-button type="primary" @click.stop="chainStoreDialog = true">连锁店管理</el-button>
                </div>
            </div>
        </div>

        <div class="clinic-item">
            <div class="title">
                <i class="fa fa-hospital mr-10 hospital"></i>
                <span>我的诊所</span>
            </div>

            <div class="hsp-content clearfix">
                <!-- <span class="hsp-msg">剩余短信数： <span class="tip">500</span> </span> -->
                <div class="info">
                    <div class="info-item">
                        <div class="info-left clinic">诊所名称*：</div>
                        <div class="info-right">{{tableData.clinic_name}}</div>
                    </div>
<!--                     <div class="info-item">
                        <div class="info-left">QQ号：</div>
                        <div class="info-right">123456789</div>
                    </div> -->
                    <div class="info-item">
                        <div class="info-left">联系人：</div>
                        <div class="info-right">{{tableData.contact}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-left">联系电话：</div>
                        <div class="info-right">{{tableData.phone}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-left">邮箱：</div>
                        <div class="info-right">{{tableData.email}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-left">地址：</div>
                        <div class="info-right">{{tableData.address}}</div>
                    </div>
                </div>
            </div>
        </div>
        <chain-store :show.sync="chainStoreDialog"></chain-store>
    </div>

</template>

<script>
import ChainStore from "./ChainStore";
export default {
    name: "ClinicInformation",
    components: { ChainStore },
    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
			chainStoreDialog: false,
            tableData:{
                company_name:'',
                clinic_name:'',
                contact:'',
                phone:undefined,
                email:'',
                address:''
            }
		};
    },
    created() {},
    mounted() {
        let that = this;
        that.getData();
    },
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();

            }
        }
    },
    computed: {},
    methods: {


        /***处理数据***/

        getData(){
            //获取数据
            let that = this;
            that.$api.clinic.getClinic()
            .then(res => {
               that.tableData = res.data;
            })
            .catch(res => {

            });
        },

        getDataDone() {
            setTimeout(() => {
                that.$emit("update:refresh", false);
            }, 6e3);
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.clinic-info {
    padding-left: 60px;

    .clinic-item {
        margin-top: 20px;
        width: 600px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e3e3e3;

        .title {
            font-size: 24px;

            i {
                font-size: 28px;

                &.store {
                    color: orange;
                }

                &.hospital {
                    color: blue;
                }
            }
        }

        .tip {
            color: @color;
            font-size: 18px;
        }

        .org-content {
            margin: 20px;
            margin-left: 20px;
            font-size: 20px;
        }

        .hsp-content {
            .hsp-msg {
                margin: 10px 0 0 10px;
            }

            .info {
                margin-left: 20px;

                .info-item {
                    margin-top: 16px;

                    .info-left {
                        width: 120px;
                        text-align: right;

                        &.clinic {
                            color: orange;
                        }
                    }

                    > div {
                        display: inline-block;
                    }
                }
            }
        }
    }
}
</style>