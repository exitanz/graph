<template>
  <div class="row">
    <aside class="col-sm-0 col-md-50 col-lg-20 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-50 col-lg-80 col-xl-8">
      <div class="card">
        <article class="card-body">
          <div id="calendar">
            <h4 class="card-title text-center mb-4 mt-1"> {{month}}月</h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td
                    v-for="(week, key) in weeks"
                    :key="key"
                  >
                    {{week}}
                  </td>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(weekDays, key1) in days"
                  :key="key1"
                >
                  <td
                    v-for="(dayInfo, key2) in weekDays"
                    :key="key2"
                  >
                    {{dayInfo.day}}<br />
                    <span class="text-primary small">{{dayInfo.inc}}</span><br />
                    <span class="text-danger small">{{dayInfo.pay}}</span><br />
                    <span class="text-success small">{{dayInfo.tra}}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>
      </div>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>

</template>

<script>
// import { ApiURL } from "../../constants/ApiURL.js";
// import { CommonUtils } from "../../common/CommonUtils.js";
// import { AxiosConstants } from "../../constants/AxiosConstants.js";
// import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      errors: [],
      month: new Date().getMonth() + 1,
      weeks: ["日", "月", "火", "水", "木", "金", "土"],
      days: [],
      items: [],
    };
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.initialize(); // 初期化処理
      next();
    });
  },
  methods: {
    initialize() {
      // 初期化処理
      // パラメータ生成
      this.calendar();
    },
    calendar(date = new Date()) {
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const startDate = new Date(year, month - 1, 1); // 月の最初の日を取得
      const endDate = new Date(year, month, 0); // 月の最後の日を取得
      const endDayCount = endDate.getDate(); // 月の末日
      const startDay = startDate.getDay(); // 月の最初の日の曜日を取得
      let dayCount = 1; // 日にちのカウント

      // カレンダーAPIにアクセス

      for (let w = 0; w < 6; w++) {
        let weekDays = [];
        for (let d = 0; d < 7; d++) {
          let dayInfo = {
            day: "",
            inc: "",
            pay: "",
            tra: "",
          };
          if (!(w == 0 && d < startDay) && dayCount < endDayCount) {
            dayInfo.day = dayCount;
            dayInfo.pay = dayCount * 10000;
            dayInfo.inc = dayCount * 10000;
            dayInfo.tra = dayCount * 10000;
            dayCount++;
          }
          weekDays.push(dayInfo);
        }
        this.days.push(weekDays);
      }
    },
  },
};
</script>

<style>
</style>
