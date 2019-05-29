var $software = document.querySelector('#software')

if ($software) {
    new Vue({
        el: '#software',
        components: {
            /** 軟件下載 */
            Download: () => import('./pages/Software/Download'),
        }
    })
}
