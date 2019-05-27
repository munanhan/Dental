<template>
    <el-dialog
        title="编辑诊所信息"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog chain-store-info"
        :close-on-click-modal="false"
        v-dialog-drag
        width="600px"
        top="2vh"
    >
        <div
            class="content"
            :style="{
                height: contentHeight
            }"
        >        
            <div class="content-left">
                <ul>
                    <li
                        :class="{'active': activeName == 'hospInfo' }"
                        @click.stop.prevent="activeName = 'hospInfo'"
                    >
                        <i class="fa fa-hospital"></i>
                        <span class="ml-10">诊所信息</span>
                    </li>
                    <li
                        :class="{'active': activeName == 'intelligence' }"
                        @click.stop.prevent="activeName ='intelligence'"
                    >
                        <i class="fa fa-address-card"></i>
                        <span class="ml-10">资质认证</span>
                    </li>
                </ul>
            </div>
            <div class="content-right">

                <!-- 诊所信息-------------------------- -->
                <div
                    v-if="activeName == 'hospInfo'"
                    class="hospInfo"
                >
                    <el-form
                        :model="formHosp"
                        :rules="formRulesHosp"
                        label-width="100px"
                    >
                        <div>
                            <el-upload
                                class="company-uploader"
                                action="http://www.laravel.com/clinic/upload?type=1"
                                :show-file-list="false"
                                :on-success="handleSuccess"
                                :before-upload="beforeUpload"
                            >
                                <img
                                    v-if="formHosp.logo"
                                    :src="formHosp.logo"
                                    class="company"
                                >
                                <span
                                    v-else
                                    class="compay-uploader-icon"
                                >
                                    <i class="el-icon-plus "></i>
                                    <br />
                                    <span class="icon-tip">
                                        诊所标志
                                    </span>

                                </span>

                            </el-upload>
                        </div>

                        <el-form-item
                            label="诊所名称"
                            prop="clinic_name"
                        >
                            <el-input
                                v-model.trim="formHosp.clinic_name"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item
                            label="诊所联系人"
                            prop="contact"
                        >
                            <el-input
                                v-model.trim="formHosp.contact"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item
                            label="诊所电话"
                            prop="phone"
                        >
                            <el-input
                                v-model.trim="formHosp.phone"
                                autocomplete="off"
                                :disabled="true"
                            ></el-input>
                        </el-form-item>

                        <el-form-item
                            label="诊所地址"
                            prop="addresss"
                        >
                            <div class="address">
                                <div>
                                    <el-select
                                        v-model="formHosp.province_id"
                                        collapse-tags
                                        class="width100"
                                        placeholder="省份"
                                    >
                                        <el-option
                                            v-for="item in provinceList"
                                            :key="item.area_code"
                                            :label="item.area_name"
                                            :value="item.area_code"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <el-select
                                        v-model="formHosp.city_id"
                                        collapse-tags
                                        class="width100"
                                        placeholder="城市"
                                    >
                                        <el-option
                                            v-for="item in cityList"
                                            :key="item.area_code"
                                            :label="item.area_name"
                                            :value="item.area_code"
                                        >
                                        </el-option>
                                    </el-select>

                                </div>
                                <div>
                                    <el-select
                                        v-model="formHosp.region_id"
                                        collapse-tags
                                        class="width100"
                                        placeholder="地区"
                                    >
                                        <el-option
                                            v-for="item in areaList"
                                            :key="item.area_code"
                                            :label="item.area_name"
                                            :value="item.area_code"
                                        >
                                        </el-option>
                                    </el-select>

                                </div>
                            </div>

                            <div>
                                <el-input
                                    v-model.trim="formHosp.address"
                                    autocomplete="off"
                                    placeholder="详细地址"
                                ></el-input>
                            </div>

                        </el-form-item>

                        <el-form-item
                            label="诊所介绍"
                            prop="introduction"
                        >
                            <el-input
                                v-model.trim="formHosp.introduction"
                                autocomplete="off"
                                type="textarea"
                            ></el-input>
                        </el-form-item>
                    </el-form>

                    <div class="pull-right">
                        <el-button
                            @click="closeDialog"
                            :disabled="commitLoading"
                        >取 消</el-button>
                        <el-button
                            type="primary"
                            @click="editCommit('hosp')"
                            :loading="commitLoading"
                        >确 定</el-button>
                    </div>
                </div>
                <!-- ----------------------------------- -->

                <!-- 资质认证------------------------- -->
                <div
                    v-if="activeName == 'intelligence'"
                    class="intelligence"
                >
                    <el-form
                        :model="formIntell"
                        :rules="formRulesformIntell"
                        label-width="130px"
                    >
                        <el-form-item
                            label="工商注册名称"
                            prop="industry_name"
                        >
                            <el-input
                                v-model.trim="formIntell.industry_name"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item
                            label="营业执照注册号"
                            prop="license_no"
                        >
                            <el-input
                                v-model.trim="formIntell.license_no"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>

                        <el-form-item
                            label="营业执照扫描件"
                            prop="license_no"
                        >
                            <div class="image-upload">
                                <el-upload
                                    class="image-uploader"
                                    action="/clinic"
                                    :show-file-list="false"
                                    :on-success="handleSuccess"
                                    :before-upload="beforeUpload"
                                >
                                    <img
                                        v-if="formIntell.license_image_url"
                                        :src="formIntell.license_image_url"
                                        class="image"
                                    >
                                    <span
                                        v-else
                                        class="image-uploader-icon"
                                    >
                                        <i class="el-icon-plus "></i>
                                    </span>

                                </el-upload>
                                <div class="image-upload-tip">
                                    上传营业执照扫描件，不超过5M（.jpg或.png格式）
                                </div>
                            </div>

                        </el-form-item>

                        <el-form-item
                            label="身份证扫描件"
                            prop="license_no"
                        >
                            <div class="image-upload">
                                <el-upload
                                    class="image-uploader"
                                    action="/upload"
                                    :show-file-list="false"
                                    :on-success="handleSuccess"
                                    :before-upload="beforeUpload"
                                >
                                    <img
                                        v-if="formIntell.card_image_url"
                                        :src="formIntell.card_image_url"
                                        class="image"
                                    >
                                    <span
                                        v-else
                                        class="image-uploader-icon"
                                    >
                                        <i class="el-icon-plus "></i>
                                    </span>

                                </el-upload>
                                <div class="image-upload-tip">
                                    上传营业执照扫描件，不超过5M（.jpg或.png格式）
                                </div>
                            </div>
                        </el-form-item>

                        <el-form-item
                            label="经营年限"
                            prop="operate_year"
                        >
                            <el-input
                                v-model.trim="formIntell.operate_year"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item
                            label="牙椅数量"
                            prop="chair"
                        >
                            <el-input
                                v-model.trim="formIntell.chair"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item
                            label="门店面积"
                            prop="store_area"
                        >
                            <el-input
                                v-model.trim="formIntell.store_area"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                    </el-form>
                    <div class="pull-right">
                        <el-button
                            @click="closeDialog"
                            :disabled="commitLoading"
                        >取 消</el-button>
                        <el-button
                            type="primary"
                            @click="editCommit('license')"
                            :loading="commitLoading"
                        >确 定</el-button>
                    </div>
                </div>
                <!-- ----------------------------------- -->
            </div>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../../base/DialogForm";
export default {
    name: "ChainStoreInfoDialog",

    mixins: [DialogForm],

    components: {},
    props: {
        editItem: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            activeName: "hospInfo",

            //诊所
            commitLoading: false,

            contentHeight: "590px",

            formHosp: {
                clinic_name: "",
                contact: "",
                phone: "",
                province_id: undefined,
                city_id: undefined,
                region_id: undefined,
                address: "",
                logo: "",
                introduction:""
            },
            formRulesHosp: {
                clinic_name: [
                    {
                        required: true,
                        message: "请输入诊所名称",
                        trigger: "blur"
                    }
                ],
                contact: [
                    {
                        required: true,
                        message: "请输入诊所联系人",
                        trigger: "blur"
                    }
                ],
                phone: [
                    {
                        required: true,
                        message: "请输入诊所电话",
                        trigger: "blur"
                    }
                ]
            },

            provinceList: [],
            cityList: [],
            areaList: [],

            //---------------------------

            //资质
            formIntell: {
                industry_name: "",
                license_no: "",
                license_image_url: "",
                card_image_url: "",
                operate_year: "",
                chair: "",
                store_area: ""
            },
            formRulesformIntell: {
                industry_name: [
                    {
                        required: true,
                        message: "请输入工商注册名称",
                        trigger: "blur"
                    }
                ],
                license_no: [
                    {
                        required: true,
                        message: "请输入营业执照注册号",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    created() {},
    mounted() {

    },
    watch: {
        activeName(newValue, oldValue) {
            let that = this;

            switch (newValue) {
                case "hospInfo":
                    that.contentHeight = "590px";
                    break;

                case "intelligence":
                    that.contentHeight = "635px";
                    break;
            }
        },
        show(newValue,oldValue){
            let that = this;

            if (newValue) {
                that.formHosp = that.editItem;
                that.formIntell = that.editItem;
                that.getAreas();

            }

        }

    },
    computed: {},
    methods: {
        //诊所信息
        handleSuccess(res, file) {
            this.formHosp.image_url = URL.createObjectURL(file.raw);
            // this.imageUrl = URL.createObjectURL(file.raw);
        },
        beforeUpload(file) {
            // const isJPG = file.type === "image/jpeg";
            // const isLt2M = file.size / 1024 / 1024 < 2;
            // if (!isJPG) {
            //     this.$message.error("上传头像图片只能是 JPG 格式!");
            // }
            // if (!isLt2M) {
            //     this.$message.error("上传头像图片大小不能超过 2MB!");
            // }
            // return isJPG && isLt2M;
        },

        editCommit(type) {
            let that = this;

            switch (type) {
                case "hosp":
                console.log(that.formHosp);
                    break;

                case "license":
                console.log(that.formIntell);
                    break;
            }
        },
        getAreas(){
            //获取省市区
            let that = this;
            let city_id = that.editItem.city_id;
            let province_id = that.editItem.province_id;
            that.$api.area.getById({'province_id':province_id,'city_id':city_id})
            .then(res => {
               that.provinceList = res.data.province;
               that.cityList = res.data.city;
               that.areaList = res.data.country;
            })
            .catch(res => {

            });
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.chain-store-info {
    /deep/ .el-dialog__body {
        padding: 0;
    }

    .content {
        display: flex;

        .content-left {
            height: 100%;
            width: 180px;
            border-right: 1px solid #e3e3e3;

            ul,
            li {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            li {
                padding: 14px 10px;
                font-size: 16px;
                text-align: center;
                cursor: pointer;
                border-bottom: 1px solid #e3e3e3;

                &.active {
                    color: @linght-font-color;
                }

                &:hover {
                    background-color: @linght-background-color;
                }
            }
        }

        .content-right {
            flex: 1;
            overflow: auto;
            padding: 20px;

            .hospInfo {
                .company-uploader {
                    position: relative;
                    display: inline-block;
                }

                .company {
                    width: 100px;
                    height: 100px;
                    display: block;
                }

                .compay-uploader-icon {
                    font-size: 28px;
                    color: #8c939d;
                    width: 100px;
                    height: 100px;
                    text-align: center;
                    border: 1px solid #e3e3e3;
                    margin-bottom: 20px;
                    display: inline-block;
                    box-sizing: border-box;
                    padding-top: 18px;

                    .icon-tip {
                        font-size: 14px;
                    }
                }

                .address {
                    display: flex;
                    margin-bottom: 22px;

                    > div {
                        flex: 1 auto;
                        margin-right: 1%;

                        :last-of-type {
                            margin-right: 0;
                        }
                    }
                }
            }

            .intelligence {
                .image-upload {
                    display: flex;
                }

                .image-uploader {
                    font-size: 28px;
                    color: #8c939d;
                    width: 100px;
                    height: 100px;
                    line-height: 60px;
                    text-align: center;
                    border: 3px dotted #e3e3e3;
                    display: inline-block;
                    box-sizing: border-box;
                    margin-right: 10px;

                    /deep/ .el-upload {
                        width: 100%;
                        height: 100%;
                        padding-top: 18px;
                        box-sizing: border-box;
                    }
                }

                .image {
                    width: 100px;
                    height: 100px;
                    display: block;
                }

                .image-upload-tip {
                    flex: 1;
                    line-height: 30px;
                }
            }
        }
    }
}
</style>