window._ = require('lodash');
window.Vue = require('vue');
window.moment = require('moment');

// 匯入 Report.vue 檔，不需加副檔名
import Report from './components/Report'
import numFormat from 'vue-filter-number-format';
import VueResource from 'vue-resource';

Vue.config.productionTip = false;
Vue.filter('numFormat', numFormat);
Vue.use(VueResource);
Vue.http.interceptors.push(function (request, next) {
    request.headers.set('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content);
    next();
});

var vm = new Vue({
    el: '#app',
    // 使用我們建立的 Report(.vue) 元件
    components: {Report}
});
