window._ = require('lodash');
window.Vue = require('vue');
window.moment = require('moment');


// 匯入 Report.vue 檔，不需加副檔名
import numFormat from 'vue-filter-number-format';
import VueResource from 'vue-resource';

Vue.config.productionTip = false;
Vue.filter('numFormat', numFormat);
Vue.use(VueResource);
Vue.prototype._ = _
Vue.prototype.moment = moment

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

Vue.http.interceptors.push(function (request, next) {
    request.headers.set('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content);
    next();
});
