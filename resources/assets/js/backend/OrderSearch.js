import './init'
import OrderSearch from './components/OrderSearch.vue'

new Vue({
    el: '#logQuery',
    // 使用我們建立的 Report(.vue) 元件
    components: {OrderSearch}
});
