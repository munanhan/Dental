<template>
    <div>
        <el-dialog
            title="处置选择"
            :visible.sync="show"
            width="1200px"
            :before-close="closeDialog"
            :close-on-click-modal="false"
            v-dialog-drag
        >
            <!-- <el-form ref="form" :model="form" :rules="rules" label-width="80px">
          <el-form-item label="组合名称" prop="combo_name">
            <el-input v-model="form.combo_name"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('form')">确定</el-button>
            <el-button @click="closethisDialog">关闭</el-button>
          </el-form-item>

        </el-form> -->
            <el-container>
                <el-header
                    class="header"
                    style="height: 37px;"
                >
                    <div class="title">处置选择</div>
                </el-header>
                <el-container>
                    <el-aside
                        style="height:600px;"
                        class="aside"
                    >
                        <el-row>
                            <div class="cost_type">费用大类</div>
                        </el-row>
                        <el-row>
                            <el-col
                                :span="24"
                                class="left_menu"
                            >
                                <div class="menu_content">
                                    <el-table
                                        :data="menuData"
                                        stripe
                                        border
                                        :show-header="false"
                                        highlight-current-row
                                        @row-click="getMenuTableData"
                                    >
                                        <el-table-column prop="category">
                                        </el-table-column>
                                    </el-table>

                                </div>
                            </el-col>
                        </el-row>
                    </el-aside>
                    <el-container>
                        <el-main class="main">
                            <el-row>
                                <div class="search">
                                    <el-col :span="8">
                                        <span class="mr10">
                                            <el-input
                                                v-model="search.disposal_name"
                                                placeholder="名字"
                                            ></el-input>
                                        </span>
                                    </el-col>
                                    <el-col
                                        :span="2"
                                        style="margin-left: 10px;"
                                    >
                                        <span class="">
                                            <el-button
                                                type="primary"
                                                @click="searchData"
                                            >查询</el-button>
                                        </span>
                                    </el-col>
                                    <el-col
                                        :span="2"
                                        :offset="11"
                                    >
                                        <!-- <i
                            class="fa fa-cog"
                            style="margin-top:10px;
                                   font-size:20px;
                                   cursor:pointer;
                                   margin-left:10px;
                                   float:right;"
                                   @click="showDisposalDialog"
                            ></i> -->
                                    </el-col>

                                </div>
                            </el-row>
                            <el-table
                                :data="tableData"
                                stripe
                                border
                                highlight-current-row
                                height="260px"
                                @row-click="selectDisposal"
                            >

                                <el-table-column
                                    label="添加"
                                    prop="add"
                                    width="60px"
                                >
                                    <template slot-scope="scope">
                                        <i
                                            class="fa fa-plus"
                                            style="
                               font-size:20px;
                               cursor:pointer;
                               margin-left: 10px;
                               "
                                            @click="addDisposal(scope.row)"
                                        ></i>

                                    </template>
                                </el-table-column>
                                <el-table-column
                                    label="处置代码"
                                    prop="disposal_code"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="处置名称"
                                    prop="disposal_name"
                                    width="150px"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="单位"
                                    prop="unit"
                                    width="100px"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="单价"
                                    prop="price"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="是否医保"
                                    prop="medical_insurance"
                                    width="80px"
                                >
                                    <!--                     <template slot-scope="scope">
                      <div v-if="scope.row.medical_insurance == 1">
                         是
                      </div>
                      <div v-if="scope.row.medical_insurance == 0">
                         否
                      </div>
                    </template> -->
                                </el-table-column>
                                <el-table-column
                                    label="处置备注"
                                    prop="remarks"
                                >
                                </el-table-column>
                                <el-table-column
                                    label="费用类型"
                                    prop="category"
                                >
                                </el-table-column>
                            </el-table>
                            <el-row>
                                <span style="margin: 5px">已选择处置项目:</span>
                                <el-button
                                    style="margin: 5px"
                                    type="success"
                                    size="mini"
                                    @click="addSelectDesposal"
                                >↓ 添加</el-button>
                                <el-button
                                    style="margin: 5px"
                                    type="warning"
                                    size="mini"
                                    @click="delSelectForm"
                                >↑ 删除</el-button>
                            </el-row>
                            <el-row>
                                <el-table
                                    :data="form"
                                    stripe
                                    border
                                    highlight-current-row
                                    height="200px"
                                    @row-click="selectForm"
                                    :row-class-name="getSelectFormIndex"
                                >
                                    <el-table-column
                                        label="删除"
                                        width="60px"
                                    >
                                        <template slot-scope="scope">
                                            <i
                                                class="fa fa-trash-alt"
                                                style="
                                 font-size:20px;
                                 cursor:pointer;
                                 margin-left: 10px;
                                 "
                                                @click="delDisposal(scope.row,scope.$index)"
                                            ></i>

                                        </template>
                                    </el-table-column>
                                    <el-table-column
                                        label="处置代码"
                                        prop="disposal_code"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        label="处置名称"
                                        prop="disposal_name"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        label="单位"
                                        prop="unit"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        label="单价"
                                        prop="price"
                                    >
                                    </el-table-column>
                                    <el-table-column
                                        label="费用类型"
                                        prop="category"
                                    >
                                    </el-table-column>
                                </el-table>
                            </el-row>
                            <el-row>
                            </el-row>
                        </el-main>
                    </el-container>
                </el-container>
                <el-footer class="footer">
                    <el-row>
                        <el-col
                            :span="4"
                            :offset="20"
                        >
                            <el-button
                                type="primary"
                                @click="submitForm('form')"
                            >确定</el-button>
                            <el-button @click="closethisDialog">关闭</el-button>
                        </el-col>
                    </el-row>
                </el-footer>
            </el-container>
        </el-dialog>
        <!-- 设置弹窗 -->
        <!-- <disposal-charging
      :show.sync="disposalChargingDialog"
    >
    </disposal-charging> -->

    </div>
</template> 
<script>
import AddDialogForm from "@views/base/AddDialogForm";
// import DisposalCharging from "./DisposalChargingDialog"

export default {
    name: "Add",
    mixins: [AddDialogForm],
    components: {
        //   DisposalCharging
    },
    props: {
        itemList: {
            type: Array
        },
        comboId: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            disposalChargingDialog: false,
            select_disposal: {}, //选择的处置
            select_form: {}, //选择的表单
            menuData: [
                // {
                //   id:0,
                //   catepory:'全部'
                // },
                // {
                //   id:1,
                //   catepory:'西药费'
                // },
                // {
                //   id:2,
                //   catepory:'放射费'
                // },
                // {
                //   id:3,
                //   catepory:'检查费'
                // },
                // {
                //   id:4,
                //   catepory:'诊疗费'
                // },
                // {
                //   id:5,
                //   catepory:'补牙费'
                // },
                // {
                //   id:6,
                //   catepory:'手术费'
                // },
                // {
                //   id:7,
                //   catepory:'正崎费'
                // },
                // {
                //   id:8,
                //   catepory:'拔牙费'
                // },
                // {
                //   id:9,
                //   catepory:'修复费'
                // },
                // {
                //   id:10,
                //   catepory:'其  他'
                // },
            ],
            tableData: [
                // {
                //    id:1,
                //    disposal_code:7002,
                //    disposal_name:'必兰麻',
                //    unit:'项',
                //    price:50.00,
                //    medical_insurance:1,
                //    remarks:'无',
                //    cost_type:'西药费'
                // },
                // {
                //    id:2,
                //    disposal_code:7003,
                //    disposal_name:'保丽净',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'西药费'
                // },
                // {
                //    id:3,
                //    disposal_code:7005,
                //    disposal_name:'芬必得',
                //    unit:'项',
                //    price:20.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'西药费'
                // },
                // {
                //    id:4,
                //    disposal_code:5001,
                //    disposal_name:'口内根尖片',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'放射费'
                // },
                // {
                //    id:5,
                //    disposal_code:5002,
                //    disposal_name:'头颅定位侧位片',
                //    unit:'项',
                //    price:100.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'放射费'
                // },
                // {
                //    id:6,
                //    disposal_code:5003,
                //    disposal_name:'头颅定位正位片',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'放射费'
                // },
                // {
                //    id:7,
                //    disposal_code:7001,
                //    disposal_name:'口腔检查',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'检查费'
                // },
                // {
                //    id:8,
                //    disposal_code:2001,
                //    disposal_name:'单面洞',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'诊疗费'
                // },
                // {
                //    id:9,
                //    disposal_code:2005,
                //    disposal_name:'超声波洁牙',
                //    unit:'全口',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'手术费'
                // },
                // {
                //    id:10,
                //    disposal_code:1010,
                //    disposal_name:'齿槽骨修正术',
                //    unit:'次',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'手续费'
                // },
                // {
                //    id:11,
                //    disposal_code:4002,
                //    disposal_name:'固定矫正',
                //    unit:'项',
                //    price:60.00,
                //    medical_insurance:0,
                //    remarks:'无',
                //    cost_type:'正畸费'
                // }
            ],
            form: [
                // {
                //   disposal_id:1,
                //   disposal_code:2005,
                //   disposal_name:'超声波洁牙',
                //   unit:'全口',
                //   price:120.00,
                //   cost_type:'诊疗费'
                // }
            ],
            rules: {
                combo_name: [
                    {
                        required: true,
                        message: "请输入目录名称.",
                        trigger: "blur"
                    }
                ]
            },
            search: {
                disposal_name: ""
            },
            //         //要检查的字段
            // checkField: {
            //     name: "请输入姓名.",
            //     phone: "请填写移动电话.",
            //     password:'请输入密码',
            //     role:'请选择职位'
            // },
            commitLoading: false
            // tableData:[]
        };
    },
    created() {},
    mounted() {},
    watch: {
        // refresh(newValue, oldValue) {
        //   let that = this;

        //   if (newValue) {
        //     that.getPatientInfo();
        //   }
        // }
        show(newValue, oldValue) {
            if (newValue) {
                let that = this;
                that.getMenu();
                // console.log(that.itemList);
                that.form = that.itemList;
            }
        }
    },
    computed: {},
    methods: {
        showDisposalDialog() {
            this.disposalChargingDialog = true;
        },
        getSelectFormIndex({ row, rowIndex }) {
            //获取选中已选择处置的index
            row.index = rowIndex; //每一行加入索引
        },
        selectDisposal(row) {
            //被选中的处置行
            // console.log(row);
            this.select_disposal = row;
        },
        selectForm(row, event, column) {
            console.log(row.index);
            this.select_form = row;
        },
        addSelectDesposal() {
            //添加被选中的处置
            this.addDisposal(this.select_disposal);
        },
        delSelectForm() {
            //删除被选中的处置
            console.log(this.select_form);
            if (Object.keys(this.select_form).length == 0) {
                alert("请选择一项");
            } else {
                // console.log(this.select_form);
                this.form = this.form
                    .slice(0, this.select_form.index)
                    .concat(
                        this.form.slice(
                            parseInt(this.select_form.index, 10) + 1
                        )
                    );
            }
        },
        delDisposal(data, index) {
            //删除处置
            console.log(index);
            this.form = this.form
                .slice(0, index)
                .concat(this.form.slice(parseInt(index, 10) + 1));
            //删除元素
        },
        addDisposal(data) {
            //添加处置
            console.log(data);
            if (Object.keys(data).length == 0) {
                alert("请选择一项");
            } else {
                let new_data = JSON.parse(JSON.stringify(data));
                new_data.desposal_id = new_data.id;
                delete new_data.id;
                this.form.push(new_data);
            }
            // let new_data = JSON.parse(JSON.stringify(data));
            // new_data.desposal_id = new_data.id;
            // delete new_data.id;
            // this.form.push(new_data);
        },
        searchData() {
            //查询
            let that = this;
            that.getData();
        },
        getData(id = "") {
            //获取列表数据
            let that = this;
            let disposal_name = that.search.disposal_name;

            that.$api.disposal
                .get({ id: id, disposal_name: disposal_name })
                .then(res => {
                    that.tableData = res.data;
                })
                .catch(res => {});
        },
        getMenu() {
            //获取菜单
            let that = this;
            that.$api.cost_category
                .get()
                .then(res => {
                    that.menuData = res.data;
                })
                .catch(res => {});
        },

        // getData(){
        //   //搜索
        //   console.log(this.search);
        // },
        getMenuTableData(row) {
            let that = this;
            that.search.disposal_name = "";
            that.getData(row.id);
        },

        submitForm(formName) {
            let that = this;
            let data = {};
            data.list = that.form;
            data.combo_id = that.comboId;

            that.$api.disposal_combo
                .add(data)
                .then(res => {
                    if (res.code == 200) {
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        that.closethisDialog();
                        that.$emit("flush");
                    } else {
                        that.$message.error(res.msg || "add error.");
                    }
                })
                .catch(res => {
                    // console.log(res);
                });

            // this.$refs[formName].validate((valid) => {
            //   if (valid) {
            //     this.form.p_id = this.p_id;
            // console.log(this.form);
            // console.log(this.comboId);
            //   } else {
            //     console.log('error submit!!');
            //     return false;
            //   }
            // });
        },
        closethisDialog() {
            let that = this;

            that.closeDialog();
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
/deep/ .el-dialog__body {
    padding: 0 0 0 0;
}
/deep/ .el-table__body td {
    padding: 3px 0;
}

/deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
    background-color: @linght-background-color;
    cursor: pointer;
}
.header {
    border-top: 1px solid #dbdbdb;
    border-bottom: 1px solid #dbdbdb;
    /*padding-top: 10px;*/
    padding: 10px 0 0 0;
    .title {
        color: @color;
        font-weight: bold;
        font-size: 16px;
        border-bottom: 3px solid @color;
        padding: 0 0 5px 38px;
        width: 100px;
    }
}
.aside {
    border-top: 1px solid #dbdbdb;
    border-bottom: 1px solid #dbdbdb;
    padding: 10px 25px 0 25px;
    .cost_type {
        color: @color;
        font-weight: bold;
        font-size: 16px;
        border-bottom: 3px solid @color;
        padding: 0 0 5px 25px;
        width: 86px;
    }

    .left_menu {
        border: 1px solid #dbdbdb;
        height: 560px;
        .menu_content {
        }
    }
}
.main {
    border: 1px solid #dbdbdb;
}
.footer {
    border: 1px solid #dbdbdb;
    padding: 10px;
}

.el-main {
    padding: 0;
}
.search {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;
    height: 40px;
    /*width: 100%;*/
}
</style>
