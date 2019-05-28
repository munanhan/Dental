<template>
    <div>
        <el-dialog
            title="连锁店管理"
            :visible.sync="show"
            :before-close="closeDialog"
            class="custom-dialog chain-store"
            :close-on-click-modal="false"
            v-dialog-drag
            width="1010px"
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

                        <div class="store-item" v-for="item in clinicList">
                            <div
                                class="content"
                                @click="showInfo(item.id)"
                            >
                                <div class="title">分店信息</div>
                                <div class="info">{{item.clinic_name}}</div>
                                <div class="info">{{item.phone}}</div>
                                <div class="info">{{item.contact}}</div>
                            </div>
                        </div>

                    </div>
                </el-tab-pane>

                <el-tab-pane
                    label="员工管理"
                    name="StaffManagement"
                >
                    <div class="staff-management">
                        <div class="action-bar">
                            <div class="search-item">
                                <span class="mr-10">所属诊所</span>
                                <el-select
                                    v-model="search.hospital"
                                    collapse-tags
                                >
                                    <el-option
                                        v-for="item in hospitalList"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    >
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="search-item">
                                <el-button
                                    type="primary"
                                    @click="getStaffData"
                                >查询</el-button>
                            </div>
                        </div>

                        <el-table
                            border
                            class="width100 mb-10"
                            :data="tableData"
                            :height="tableHeight"
                            :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                        >
                            <el-table-column
                                prop="aaaa"
                                label="姓名"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="所属门店"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="职位"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="联系电话"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁管理员"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁查看权限"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="单店查看权限"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio>
                                </template>

                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="患者管理"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-checkbox
                                        v-model="scope.row.check"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-checkbox>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="aaaa"
                                label="连锁店管理"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
                                    <el-checkbox
                                        v-model="scope.row.check"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-checkbox>
                                </template>
                            </el-table-column>
                        </el-table>
                        <el-row
                            class="pager"
                            type="flex"
                            justify="end"
                        >
                            <el-pagination
                                @current-change="changePage"
                                @size-change="pageSizeChange"
                                background
                                layout="total, sizes, prev, pager, next, jumper"
                                :page-sizes="[10, 20, 50, 100]"
                                :page-size="pager.size"
                                :total="pager.total"
                                :current-page="pager.current"
                            ></el-pagination>
                        </el-row>
                    </div>
                </el-tab-pane>

                <el-tab-pane
                    label="连锁信息"
                    name="chainInformation"
                >
                    <div class="chain-info">
                        <div
                            v-if="activeName == 'chainInformation'"
                            class="chain-btn"
                        >
                            <div v-if="isDisabled">
                                <el-button
                                    type="primary"
                                    @click="isDisabled = false"
                                    size="medium"
                                >编辑</el-button>
                            </div>

                            <div v-else>
                                <el-button
                                    @click="cancelEditChain(true)"
                                    :disabled="commitLoading"
                                    size="medium"
                                >取 消</el-button>
                                <el-button
                                    type="primary"
                                    @click="editChain"
                                    size="medium"
                                >保存</el-button>
                            </div>

                        </div>

                        <el-form
                            :model="form"
                            :rules="formRules"
                            label-width="100px"
                        >

                            <el-form-item
                                label="企业logo"
                                prop="license_no"
                            >
                                <div class="image-upload">
                                    <el-upload
                                        class="image-uploader"
                                        action="/upload"
                                        :show-file-list="false"
                                        :on-success="handleSuccess"
                                        :before-upload="beforeUpload"
                                        :disabled="isDisabled"
                                        :class="{'disabled': isDisabled }"
                                    >
                                        <img
                                            v-if="form.image_url"
                                            :src="form.image_url"
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
                                        大小不超过2M（.jpg或.png格式）
                                    </div>
                                </div>

                            </el-form-item>

                            <el-form-item
                                label="企业名称"
                                prop="name"
                            >
                                <el-input
                                    :disabled="isDisabled"
                                    v-model.trim="form.name"
                                    autocomplete="off"
                                ></el-input>
                            </el-form-item>
                            <el-form-item
                                label="企业联系人"
                                prop="contact"
                            >
                                <el-input
                                    :disabled="isDisabled"
                                    v-model.trim="form.contact"
                                    autocomplete="off"
                                ></el-input>
                            </el-form-item>
                            <el-form-item
                                label="联系电话"
                                prop="phone"
                            >
                                <el-input
                                    v-model.trim="form.phone"
                                    autocomplete="off"
                                ></el-input>
                            </el-form-item>
                            <el-form-item
                                label="企业地址"
                                prop="addresss"
                            >
                                <div class="address">
                                    <div>
                                        <el-select
                                            v-model="form.province"
                                            collapse-tags
                                            class="width100"
                                            placeholder="省份"
                                            :disabled="isDisabled"
                                        >
                                            <el-option
                                                v-for="item in provinceList"
                                                :key="item.id"
                                                :label="item.label"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div>
                                        <el-select
                                            v-model="form.city"
                                            collapse-tags
                                            class="width100"
                                            placeholder="城市"
                                            :disabled="isDisabled"
                                        >
                                            <el-option
                                                v-for="item in cityList"
                                                :key="item.id"
                                                :label="item.label"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>

                                    </div>
                                    <div>
                                        <el-select
                                            v-model="form.area"
                                            collapse-tags
                                            class="width100"
                                            placeholder="地区"
                                            :disabled="isDisabled"
                                        >
                                            <el-option
                                                v-for="item in areaList"
                                                :key="item.id"
                                                :label="item.label"
                                                :value="item.id"
                                            >
                                            </el-option>
                                        </el-select>

                                    </div>
                                </div>

                                <div>
                                    <el-input
                                        v-model.trim="form.addresss"
                                        autocomplete="off"
                                        placeholder="详细地址"
                                        :disabled="isDisabled"
                                    ></el-input>
                                </div>

                            </el-form-item>
                            <el-form-item
                                label="企业简介"
                                prop="desc"
                            >
                                <el-input
                                    v-model.trim="form.desc"
                                    autocomplete="off"
                                    type="textarea"
                                    :disabled="isDisabled"
                                ></el-input>
                            </el-form-item>
                        </el-form>
                    </div>
                </el-tab-pane>

            </el-tabs>
        </el-dialog>

        <chain-store-info-dialog 
            :show.sync="showInfoDialog"
            :editItem="editItem"
        >    
        </chain-store-info-dialog>
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

            //员工管理
            tableHeight: 370,
            tableData: [{}],
            clinicList:[],
            //分店列表
            search: {
                hospital: 0
            },

            hospitalList: [{ id: 0, label: "全部" }],

            pager: {
                total: 0,
                current: 1,
                size: 20
            },

            //企业信息
            commitLoading: false,
            isDisabled: true,

            form: {
                name: "",
                contact: "",
                phone: "",
                province: -1,
                city: -1,
                area: -1,
                addresss: "",
                desc: "",
                image_url: ""
            },

            formRules: {
                name: [
                    {
                        required: true,
                        message: "请输入企业名称",
                        trigger: "blur"
                    }
                ],
                contact: [
                    {
                        required: true,
                        message: "请输入联系人",
                        trigger: "blur"
                    }
                ],
                phone: [
                    {
                        required: true,
                        message: "请输入联系电话",
                        trigger: "blur"
                    }
                ]
            },

            editItem:{},

            provinceList: [{ id: -1, label: "省份" }],
            cityList: [{ id: -1, label: "城市" }],
            areaList: [{ id: -1, label: "地区" }]
        };
    },
    created() {

    },
    mounted() {},
    watch: {
        show(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();
            }
        }
    },
    computed: {},
    methods: {
        showInfo(id) {
            let that = this;
            that.getById(id);

        },

        changePage(index) {
            let that = this;

            that.pager.current = index;
            that.getStaffData();
        },

        pageSizeChange(val) {
            let that = this;

            that.pager.size = val;
            that.getStaffData();
        },

        //获取员工的信息
        getStaffData() {
            let that = this,
                params = {},
                searchData = JSON.parse(JSON.stringify(that.search));

            params["pageIndex"] = that.pager.current;
            params["pageSize"] = that.pager.size;

            //获取数据
        },

        //监听表格的radio和checkbox的事件
        changeType(row, type, value) {},

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

        editChain(){
            let that = this;
            
            //设置转转
            that.commitLoading = true;

            //拿数据---
            that.commitLoading = false;

            that.cancelEditChain(false);
        },

        cancelEditChain(refresh){
            let that = this;
            that.isDisabled = true;
            
            //重新拿数据，还原原来的数据
            if(refresh){

            }

            
        },
        getData(){
            //获取列表数据
            let that = this;
                that.$api.clinic.get()
                .then(res => {
                   that.clinicList = res.data;
                })
                .catch(res => {

                });
        },
        getById(id){
            let that = this;
            that.$api.clinic.getById({'id':id})
            .then(res => {
               that.editItem = res.data;
               that.showInfoDialog = true;
            })
            .catch(res => {
              // console.log(res)
            });
        },
    }
};
</script>
<style lang="less" scoped>
.transition-3 {
    transition: all 0.3s;
}

.chain-store {
    /deep/ .el-dialog__body {
        height: 550px;
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
            z-index: 99;
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

    .staff-management {
        padding: 10px;
    }

    .chain-info {
        padding: 10px;
        width: 400px;

        .chain-btn {
            position: absolute;
            right: 10px;
            top: -38px;
            z-index: 99;
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

            &.disabled {
                background-color: #e3e3e3;
                opacity: 0.6;
            }

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
</style>