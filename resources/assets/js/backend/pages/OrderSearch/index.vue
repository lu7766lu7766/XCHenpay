<template>
    <div class="row">
        <div class="col-lg-12">
            <company-selector v-if="hasPermission(Permission.CompanyChange)" v-model="company_id" :options="companies"/>
            <!-- fee start -->

            <!-- order start -->
            <order v-if="company_id !== -1"/>
            <!-- order end -->
        </div>
    </div>
</template>

<script>
    import ReqMixins from 'mixins/request'
    import PermissionMixins from 'mixins/permission'

    export default {
        api: "orderSearch",
        mixins: [ReqMixins, PermissionMixins],
        components: {
            CompanySelector: require('@/CompanySelector'),
            Order: require('./Order'),
        },
        data: () => ({
            company_id: -1,
            companies: [],
        }),
        async mounted() {
            this.proccessAjax('dataInit', {}, res => {
                this.companies = _.concat([{id: '', company_name: '全部'}], _.map(res.companies))
                this.company_id = this.hasPermission(Permission.CompanyChange)
                    ? this.company_id
                    : res.user.id
            })
        }
    }
</script>
