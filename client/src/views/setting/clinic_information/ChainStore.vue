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

                        <div class="store-item" v-for="(item,key) in clinicList" :key="key">
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
                                    v-model="search.clinic_id"
                                    collapse-tags
                                >
                                    <el-option
                                        v-for="item in clinicList"
                                        :key="item.id"
                                        :label="item.clinic_name"
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
                                prop="name"
                                label="姓名"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="clinic_name"
                                label="所属门店"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="role"
                                label="职位"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="phone"
                                label="联系电话"
                                align="center"
                                show-overflow-tooltip
                            >
                            </el-table-column>
                            <el-table-column
                                prop="is_admin"
                                label="连锁管理员"
                                align="center"
                                show-overflow-tooltip
                            >
                                <template slot-scope="scope">
<!--                                     <el-radio
                                        v-model="scope.row.id"
                                        @change="(value) => changeType(scope.row, 'type', vlaue)"
                                    ></el-radio> -->
                                    <el-checkbox 
                                        @change="changeAdmin(scope.row)"
                                        v-if="scope.row.is_admin == 1"
                                        checked
                                    ></el-checkbox>
                                    <el-checkbox 
                                        @change="changeAdmin(scope.row)"
                                        v-if="scope.row.is_admin != 1"
                                    ></el-checkbox>
                                </template>
                            </el-table-column>
<!--                             <el-table-column
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
                            </el-table-column> -->
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
                                prop="company_logo"
                            >
                                <div class="image-upload">
                                    <el-upload
                                        class="image-uploader"
                                        :action="`${uploadUrl}/api/company/upload`"
                                        :show-file-list="false"
                                        :on-success="(res, file) => handleSuccess('company_logo', res, file)"
                                        :on-error="handleError"
                                        :headers="headers"
                                        :with-credentials="true"
                                        :before-upload="beforeUpload"
                                        :disabled="isDisabled"
                                        :class="{'disabled': isDisabled }"
                                        name="company_logo"
                                    >
                                        <img
                                            v-if="form.company_logo"
                                            :src="form.company_logo"
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
                                prop="company_name"
                            >
                                <el-input
                                    :disabled="isDisabled"
                                    v-model.trim="form.company_name"
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
                                        v-model="form.province_id"
                                        collapse-tags
                                        class="width100"
                                        placeholder="省份"
                                        @change="flushCity('city')"
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
                                        v-model="form.city_id"
                                        collapse-tags
                                        class="width100"
                                        placeholder="城市"
                                        @change="flushCity('country')"

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
                                        v-model="form.region_id"
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
                                        v-model.trim="form.address"
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
                                    v-model.trim="form.introduction"
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
import { setCookie,getCookie } from "../../../common/util";
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
            tableData: [],
            clinicList:[],
            //分店列表
            search: {
                clinic_id: undefined
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
            //头信息
            headers:{},
            //上传url
            uploadUrl:'',

            form: {
                company_name: "",
                contact: "",
                company_phone: "",
                province_id: -1,
                city_id: -1,
                region_id: -1,
                address: "",
                introduction: "",
                company_logo: ""
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

            provinceList: [],
            cityList: [],
            areaList: []
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
                that.uploadUrl = (window.HOSTNAME || '');
                let token = getCookie("token");
                that.headers = {'Authorization':token};
            }
        },
        activeName(newValue,oldValue){
            let that = this;
            if (newValue) {
                switch(newValue){
                    case 'StaffManagement':
                    that.getStaffData();
                    break;
                    case 'chainInformation':
                    that.getCompanyById();
                    break;
                    case 'chainStoreManagement':
                    that.getData();
                    break;
                }
            }

        }
    },
    computed: {},
    methods: {
        showInfo(id) {
            let that = this;
            that.getClinicById(id);

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

            params["current_page"] = that.pager.current;
            params["page_size"] = that.pager.size;
            params['clinic_id'] = searchData.clinic_id;
            that.getChainStore(params);


            //获取数据
        },

        //监听表格的radio和checkbox的事件
        changeType(row, type, value) {},

        //诊所信息
        handleSuccess(type, res, file) {

            this.form.company_logo = (window.HOSTNAME || '')+res.data.company_logo;

        },
        handleError(err, file, fileLis){
            //上传失败
            let that = this;
            let data = JSON.parse(err.message);
               that.$message.error(
                    data.msg || "upload error."
                );
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
            
            // //设置转转
            // that.commitLoading = true;

            // //拿数据---
            // that.commitLoading = false;

            // that.cancelEditChain(false);

            that.updateData();

        },

        cancelEditChain(refresh){
            let that = this;
            that.isDisabled = true;
            
            //重新拿数据，还原原来的数据
            if(refresh){
                console.log(refresh);

            }

            
        },
        /***数据***/
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
        getClinicById(id){
            let that = this;
            that.$api.clinic.getById({'id':id})
            .then(res => {
               res.data.logo = res.data.logo != ''?(window.HOSTNAME || '')+res.data.logo:'';
               res.data.license_image_url = res.data.license_image_url != ''?(window.HOSTNAME || '')+res.data.license_image_url:'';
               res.data.card_image_url = res.data.card_image_url != ''?(window.HOSTNAME || '')+res.data.card_image_url:'';
               that.editItem = res.data;
               that.showInfoDialog = true;
            })
            .catch(res => {
              // console.log(res)
            });
        },
        getCompanyById(){
            let that = this;
                that.$api.company.getById()
                .then(res => {
                   res.data.company_logo = res.data.company_logo != ''?(window.HOSTNAME || '')+res.data.company_logo:'';
                   that.form = res.data;
                   that.getAreas();
                })
                .catch(res => {

                });
        },
        updateData(){
            //更新数据
            let that = this;
            that.$api.company.update(that.form)
                .then(res => {
                  if(res.code == 200){
                    res.data.company_logo = res.data.company_logo != ''?(window.HOSTNAME || '')+res.data.company_logo:'';
                    that.form = res.data;
                    that.getAreas();
                    //设置转转
                    that.commitLoading = true;
                    //拿数据---
                    that.commitLoading = false;

                    that.cancelEditChain(false);

                    that.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                    // console.log(res.data);
                   }
                   else{
                       that.$message.error(
                            res.msg || "edit error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        },
        getAreas(){
            //获取省市区
            let that = this;
            let city_id = that.form.city_id;
            let province_id = that.form.province_id;
            that.$api.area.getById({'province_id':province_id,'city_id':city_id})
            .then(res => {
               that.provinceList = res.data.province;
               that.cityList = res.data.city;
               that.areaList = res.data.country;
            })
            .catch(res => {

            });
        },
        flushCity(option){
            //刷新城市
            let that = this;
            let params = {};
            switch(option){
                case 'city':
                let province_id = that.form.province_id;
                params = { 'area_code':province_id };
                break;
                case 'country':
                let city_id = that.form.city_id;
                params = { 'area_code':city_id };
                break;
            }

            that.$api.area.getCity(params)
            .then(res => {
               switch(option){
                    case 'city':
                    that.form.city_id = undefined;
                    that.form.region_id = undefined;
                    that.cityList = res.data;
                    that.areaList = [];
                    break;
                    case 'country':
                    that.form.region_id = undefined;
                    that.areaList = res.data;
                    break;
               }

               
            })
            .catch(res => {

            });
        },
        changeAdmin(row){
            //改变管理员状态
            let that = this;
            row.is_admin = -(row.is_admin);
            let item = {};
            item.id = row.id;
            item.is_admin = row.is_admin;
            that.$api.chain_store.update(item)
            .then(res => {
                if (res.code == 200) {
                    that.$message({
                        message: res.msg,
                        type: "success",
                        duration: 800
                    });
                }
            })
            .catch(res => {

            });
        },
        getChainStore(params){
            //连锁店员工信息
            let that = this;
            that.$api.chain_store.get(params)
            .then(res => {
               that.tableData = res.data.row;
               that.pager.total = res.data.total;
            })
            .catch(res => {

            });
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
                    display: inline-block;
                    box-sizing: border-box;
                    margin-right: 10px;

                    /deep/ .el-upload {
                        width: 100%;
                        height: 100%;
                        /*padding-top: 18px;*/
                        box-sizing: border-box;
                    }
                }

                .image {
                    width: 100%;
                    height: 100%;
                    display: block;
                }

                .image-uploader-icon{
                    border: 3px dotted #e3e3e3;
                    width: 100%;
                    height: 100%;
                    display: inline-block;
                    box-sizing: border-box;

                    i{
                        line-height: 94px;
                    }
                }

                .image-upload-tip {
                    flex: 1;
                    line-height: 30px;
                }
    }
}
</style>