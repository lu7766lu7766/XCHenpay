import FetchMixins from './fetch'
import TimeMixins from './time'

export default {
    mixins: [FetchMixins, TimeMixins],
    methods: {
        async modalProccess($modal, url) {
            $modal.modal('show')
            $modal.find('.modal-content').html('')
            var res = await this.$http.get(url)
            $modal.find('.modal-content').html(res.body)
        },
    }
}
