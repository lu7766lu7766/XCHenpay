<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-if="UserInfo.this().has(Permission.CompanyChange)" v-model="company_id"
                              :options="companies"/>
            <!-- fee start -->

            <!-- order start -->
            <order v-if="company_id !== -1"/>
            <!-- order end -->
        </div>
    </div>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        mixins: [ReqMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            Order: require('./Order'),
        },
        data: () => ({
            company_id: -1,
            companies: [],
        }),
        async mounted() {
            const res = await this.$api.search.orderSearch.getDataInit()
            this.companies = _.concat([{id: '', company_name: '全部'}], _.map(res.companies))
            this.company_id = UserInfo.this().has(Permission.CompanyChange)
                ? this.company_id
                : res.user.id
        }
    }
</script>
