import Vue from 'vue'
import VueResource from 'vue-resource';
import ApplyNotice from './components/ApplyNotice';

Vue.config.productionTip = false;
Vue.use(VueResource);

let an = new Vue({
    el: '#applyNotice',
    components: {'apply-notice': ApplyNotice}
});

setInterval(() => an.$refs.applyNotice.fetch(), 10000)
