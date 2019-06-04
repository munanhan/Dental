<template>
  <div ref="menuContent" class="content">
    <el-container>
      <el-aside class="left" style="width: 320px;" :style="{'height':menuHeight+'px'}">
        <el-row class="left_top" style="width: 95%;">
          <el-col :span="6" class="top_font">操作时间</el-col>
          <el-col :span="3">
            <el-button
              type="primary"
              icon="el-icon-arrow-left"
              size="mini"
              circle
              class="top_btn"
              @click="prev"
            ></el-button>
          </el-col>
          <el-col :span="2" class="top_font">
            <span @click="selectThis" style="cursor: pointer;">今</span>
          </el-col>
          <el-col :span="3">
            <el-button
              type="primary"
              icon="el-icon-arrow-right"
              size="mini"
              circle
              class="top_btn"
              @click="next"
            ></el-button>
          </el-col>
          <el-col :span="10" class="top_font">
            <el-radio-group v-model="radio_date">
              <el-radio :label="1" @change="selectToday">天</el-radio>
              <el-radio :label="2" @change="selectWeek">周</el-radio>
              <el-radio :label="3" @change="selectMonth">月</el-radio>
            </el-radio-group>
          </el-col>
        </el-row>

        <el-row class="search">
          <span class="search_font">从</span>
          <el-date-picker
            v-model="search.dtfm"
            type="date"
            placeholder="选择日期"
            class="search_input"
            value-format="yyyy-MM-dd"
            @change="resetDate"
            :clearable="false"
            :editable="false"
          ></el-date-picker>
        </el-row>
        <el-row
          class="search"
          style="border-bottom: 1px solid rgba(33, 37, 43, 0.26);padding-bottom: 30px;"
        >
          <span class="search_font">到</span>
          <el-date-picker
            v-model="search.dtto"
            type="date"
            placeholder="选择日期"
            class="search_input"
            value-format="yyyy-MM-dd"
            @change="resetDate"
            :clearable="false"
            :editable="false"
          ></el-date-picker>
        </el-row>

        <el-row class="search">
          <span class="search_font">用户</span>
          <el-select v-model="search.ct_user" placeholder="请选择" class="search_input">
            <el-option
              v-for="item in user_list"
              :key="item.name"
              :label="item.name"
              :value="item.name"
            ></el-option>
          </el-select>
        </el-row>

        <el-row class="search">
          <span class="search_font">患者</span>
          <el-input v-model="search.patient" placeholder="患者" class="search_input"></el-input>
        </el-row>

        <el-row class="search">
          <span class="search_font">模块</span>
          <el-select v-model="search.module" placeholder="请选择" class="search_input">
            <el-option
              v-for="item in module_list"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </el-row>

        <el-row class="search" style="margin-top: 20px;">
          <el-col :span="12">
            <el-button type="primary" @click="searchData">查询</el-button>
          </el-col>
          <el-col :span="12">
            <el-button type="primary" @click="clearSearch">清空</el-button>
          </el-col>
        </el-row>
      </el-aside>

      <el-main class="right" style="padding: 0;">
        <el-row class="right_top">{{show_time.dtfm}} - {{show_time.dtto}}(共{{show_time.total_day}}天)</el-row>
        <el-row class="table_data">
          <el-table
            :data="tableData"
            stripe
            :height="tableHeight"
            highlight-current-row
            style="width: 100%"
          >
            <el-table-column label="操作人" prop="created_by"></el-table-column>
            <el-table-column label="操作时间" prop="created_at" width="160"></el-table-column>
            <el-table-column label="相关患者" prop="patient"></el-table-column>
            <el-table-column label="功能模块" prop="module"></el-table-column>
            <el-table-column label="操作平台" prop="platform"></el-table-column>
            <el-table-column label="操作方式" prop="operation_type"></el-table-column>
            <el-table-column label="操作记录" prop="operation_content" width="500"></el-table-column>
          </el-table>
        </el-row>
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  name: "OperationRecord",
  components: {},
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      radio_date: 1,
      //高度设定
      tableHeight: 700,
      menuHeight: 667,
      tableData: [
        // {
        //    ct_user:'root',
        //    ct_time:'2019-05-02 12:33:56',
        //    patient:'小明',
        //    module:'预约',
        //    platform:'pc',
        //    operation_type:'添加',
        //    operation_content:'添加预约，医生:root，预约时间:2019-05-03 12:30:00'
        // },
        // {
        //    ct_user:'root',
        //    ct_time:'2019-05-02 12:33:56',
        //    patient:'小明',
        //    module:'预约',
        //    platform:'pc',
        //    operation_type:'修改',
        //    operation_content:'修改预约，医生:root->doc，预约时间:2019-05-03 12:30:00'
        // },
        // {
        //    ct_user:'root',
        //    ct_time:'2019-05-02 12:33:56',
        //    patient:'小明',
        //    module:'预约',
        //    platform:'pc',
        //    operation_type:'删除',
        //    operation_content:'删除预约，医生:root，预约时间:2019-05-03 12:30:00'
        // },
        // {
        //    ct_user:'root',
        //    ct_time:'2019-05-02 12:33:56',
        //    patient:'小明',
        //    module:'预约',
        //    platform:'pc',
        //    operation_type:'添加',
        //    operation_content:'添加预约，医生:root，预约时间:2019-05-03 12:30:00'
        // },
        // {
        //    ct_user:'root',
        //    ct_time:'2019-05-02 12:33:56',
        //    patient:'小明',
        //    module:'预约',
        //    platform:'pc',
        //    operation_type:'添加',
        //    operation_content:'添加预约，医生:root，预约时间:2019-05-03 12:30:00'
        // },
      ],
      search: {
        //搜索参数
        dtfm: "",
        dtto: "",
        ct_user: "",
        patient: "",
        module: ""
      },
      show_time: {
        //显示计算总共时间
        dtfm: "",
        dtto: "",
        total_day: 0
      },
      user_list: [
        // {
        //   value:1,
        //   label:'刘伟'
        // },
        // {
        //   value:2,
        //   label:'张三'
        // },
        // {
        //   value:3,
        //   label:'李四'
        // },
        // {
        //   value:4,
        //   label:'王五'
        // },
        // {
        //   value:5,
        //   label:'赵六'
        // },
      ],
      module_list: [
        // {
        //   value:1,
        //   label:'系统'
        // },
        // {
        //   value:2,
        //   label:'患者'
        // },
        // {
        //   value:3,
        //   label:'预约'
        // },
        // {
        //   value:4,
        //   label:'沟通'
        // },
        // {
        //   value:5,
        //   label:'设置'
        // },
      ]
    };
  },
  created() {},
  mounted() {
    let that = this;

    that.$nextTick(() => {
        that.selectToday(1);
        that.calculation();
        that.getData();
        that.getUserData();
        that.getModuleData();
        that.resizeTable();
    });
    //监听事件,由layout那边的resize抛出的
    if (window.addEventListener) {
      window.addEventListener("bodyChange", that.resizeTable);
    } else {
      window.attachEvent("bodyChange", that.resizeTable);
    }
  },
  watch: {
    refresh(newValue, oldValue) {
      let that = this;

      if (newValue) {
        that.resizeTable();

        //更新原来的refresh, 防止下次点击时不通知更新
        that.$emit("update:refresh", false);

        // that.getData();
        this.selectToday(1);
        this.calculation();
        that.getData();
        that.getUserData();
        that.getModuleData();
      }
    }
  },
  computed: {},
  methods: {
    resizeTable() {
      let that = this;
      let tableHeight = that.$refs.menuContent.clientHeight;
      // console.log(tableHeight);
      // that.tableHeight = tableHeight;
      that.menuHeight = tableHeight;
      that.tableHeight = tableHeight - 70;
    },
    resetDate() {
      //重置时间
      this.calculation();
    },
    calculation() {
      //计算总共时间
      var dtfm = new Date(this.search.dtfm);
      var dtto = new Date(this.search.dtto);
      this.show_time.total_day =
        (dtto - dtfm + 60 * 60 * 24 * 1000) / (60 * 60 * 24 * 1000); //计算天数
      this.show_time.dtfm = this.formatDate(new Date(dtfm), 1);
      this.show_time.dtto = this.formatDate(new Date(dtto), 1);
    },
    prev() {
      //往上
      var option = this.radio_date;
      var date = this.search.dtfm;
      if (date != "") {
        date = new Date(Date.parse(date.replace(/-/g, "/")));
        //转化成时间戳
        date = date.getTime();
      }
      var yesterday =
        this.search.dtfm == ""
          ? new Date(new Date() - 1000 * 60 * 60 * 24)
          : new Date(date - 1000 * 60 * 60 * 24);
      switch (option) {
        case 1:
          //获取上一天
          this.selectToday(yesterday);
          this.calculation();
          break;
        case 2:
          //上周
          this.selectWeek(yesterday);
          this.calculation();
          break;
        case 3:
          //上月
          this.selectMonth(yesterday);
          this.calculation();
      }
    },
    next() {
      //往下
      var option = this.radio_date;
      var date = this.search.dtto;
      console.log(date);
      if (date != "") {
        date = new Date(Date.parse(date.replace(/-/g, "/")));
        //转化成时间戳
        date = date.getTime();
      }
      var tomorrow =
        this.search.dtto == ""
          ? new Date(new Date() + 1000 * 60 * 60 * 24)
          : new Date(date + 1000 * 60 * 60 * 24);
      switch (option) {
        case 1:
          //获取下一天
          this.selectToday(tomorrow);
          this.calculation();
          break;
        case 2:
          //下周
          this.selectWeek(tomorrow);
          this.calculation();
          break;
        case 3:
          //下月
          this.selectMonth(tomorrow);
          this.calculation();
      }
    },
    searchData() {
      //查数据
      // console.log(this.search);
      this.getData();
    },
    selectThis() {
      //选择今天/本周/本月
      var option = this.radio_date;
      switch (option) {
        case 1:
          this.selectToday(1);
          this.calculation();
          break;
        case 2:
          this.selectWeek(2);
          this.calculation();
          break;
        case 3:
          this.selectMonth(3);
          this.calculation();
      }
    },
    selectToday(date = "") {
      //选择今天
      var now = date == 1 ? new Date() : new Date(date); //当前日期 (1代表是取今天,值来源于单选radio的label)
      this.search.dtfm = now.toLocaleDateString();
      this.search.dtto = now.toLocaleDateString();
      this.calculation();
      this.getData();
    },
    selectWeek(date = "") {
      //选择这周
      var now = date == 2 ? new Date() : new Date(date); //当前日期 (2代表是取本周,值来源于单选radio的label)
      var nowDayOfWeek = now.getDay(); //今天本周的第几天
      var nowDay = now.getDate(); //当前日
      var nowMonth = now.getMonth(); //当前月
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //

      var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek);
      this.search.dtfm = this.formatDate(weekStartDate); //本周第一天

      var weekEndDate = new Date(
        nowYear,
        nowMonth,
        nowDay + (6 - nowDayOfWeek)
      );
      this.search.dtto = this.formatDate(weekEndDate); //本周最后一天
      this.calculation();
      this.getData();
    },
    selectMonth(date = "") {
      //选择本月
      var now = date == 3 ? new Date() : new Date(date); //当前日期 (3代表是取本月,值来源于单选radio的label)
      var nowDayOfWeek = now.getDay(); //今天本周的第几天
      var nowDay = now.getDate(); //当前日
      var nowMonth = now.getMonth(); //当前月
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //

      var monthStartDate = new Date(nowYear, nowMonth, 1);
      this.search.dtfm = this.formatDate(monthStartDate); //本月第一天

      var monthEndDate = new Date(
        nowYear,
        nowMonth,
        this.getMonthDays(nowMonth)
      );
      this.search.dtto = this.formatDate(monthEndDate); //本月最后一天
      this.calculation();
      this.getData();
    },
    clearSearch() {
      //清空搜索
      // this.search.dtfm = '';
      // this.search.dtto = '';
      this.search.ct_user = "";
      this.search.patient = "";
      this.search.module = "";
    },
    getData() {
      let that = this;
      //表单数据
      that.$api.operation_log
        .get(that.search)
        .then(res => {
          that.tableData = res.data;
        })
        .catch(res => {});
    },
    getUserData() {
      //用户下拉
      let that = this;
      that.$api.operation_log
        .get_user_list()
        .then(res => {
          that.user_list = res.data;
        })
        .catch(res => {});
    },
    getModuleData() {
      //模块列表
      let that = this;
      that.$api.operation_log
        .get_module_list()
        .then(res => {
          that.module_list = res.data;
        })
        .catch(res => {});
    },
    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    },

    formatDate(date, option = "") {
      //时间转化
      var myyear = date.getFullYear();
      var mymonth = date.getMonth() + 1;
      var myweekday = date.getDate();

      var year = "-"; //年/月/日
      var month = "-";
      var day = "";

      if (option != "") {
        year = "年";
        month = "月";
        day = "日";
      }

      if (mymonth < 10) {
        mymonth = "0" + mymonth;
      }
      if (myweekday < 10) {
        myweekday = "0" + myweekday;
      }
      return myyear + year + mymonth + month + myweekday + day; //拼接,年月日
    },
    getMonthDays(myMonth, date = "") {
      //获得某月的天数
      var now = date == "" ? new Date() : new Date(date); //当前日期
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //
      var monthStartDate = new Date(nowYear, myMonth, 1);
      var monthEndDate = new Date(nowYear, myMonth + 1, 1);
      var days = (monthEndDate - monthStartDate) / (1000 * 60 * 60 * 24);
      return days;
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
/deep/
  .el-table--striped
  .el-table__body
  tr.el-table__row--striped.current-row
  td,
/deep/ .el-table__body tr.current-row > td {
  background-color: @linght-background-color;
}
/deep/ .el-aside {
  background-color: #efefef;
  color: #333;
  text-align: center;
  font-size: 17px;
}
.content {
  height: 100%;
}
.left {
  height: 100%;
  /*border:1px solid black;*/
  .left_top {
    border-bottom: 1px solid rgba(33, 37, 43, 0.26);
    height: 40px;
    /*padding: 10px;*/
    /deep/ .el-radio {
      margin-right: 5px;
    }
    /deep/ .el-radio__input.is-checked .el-radio__inner {
      border-color: rgba(33, 37, 43, 0.26);
      background: rgba(33, 37, 43, 0.26);
    }
    /deep/ .el-radio__input.is-checked + .el-radio__label {
      color: black;
    }
    /deep/ .el-radio__label {
      padding-left: 5px;
    }
  }
  .top_font {
    padding-left: 7px;
    padding-top: 10px;
  }
  .top_btn {
    margin-top: 5px;
    margin-left: 5px;
    background-color: #efefef;
    border: 1px solid rgba(33, 37, 43, 0.26);
    color: #909399;
  }
  .search {
    padding: 10px;
    width: 95%;

    .search_font {
      margin-right: 10px;
      float: left;
      margin-top: 10px;
      margin-left: 10px;
    }
    .search_input {
      width: 200px;
      float: right;
      margin-right: 5px;
    }
  }
}
.right {
  /*border:1px solid black;*/
  height: 100%;
}
.right_top {
  color: black;
  font-size: 22px;
  /*font-weight: bold;*/
  height: 40px;
  padding: 5px;
  border: 1px solid #efefef;
}
.table_data {
  /deep/ .el-table--enable-row-hover .el-table__body tr:hover > td {
    background-color: @linght-background-color;
    cursor: pointer;
  }
  /deep/ .el-table__body td {
    padding: 3px 0;
  }
}
</style>