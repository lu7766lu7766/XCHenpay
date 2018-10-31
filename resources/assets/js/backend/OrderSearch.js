import './init'
import OrderSearch from '@/OrderSearch.vue'
import FeeList from './components/FeeList.vue'

window.vm = new Vue({
    el: '#app',
    // 使用我們建立的 Report(.vue) 元件
    components: {OrderSearch, FeeList}
});
