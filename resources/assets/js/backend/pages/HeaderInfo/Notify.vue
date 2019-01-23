<template>
    <span>
        <li class="dropdown notification-list"
            v-if="canBankAccountList"
            @click="$linkTo('/admin/bankCard')">
            <a class="nav-link arrow-none waves-effect" href="">
                <i class="ti-credit-card noti-icon"></i>
                <span class="badge badge-pill badge-danger noti-icon-badge">{{ count.bankAccount }}</span>
            </a>
        </li>
        <li class="dropdown notification-list"
            v-if="canLendManage"
            @click="$linkTo('/admin/lendManage')">
            <a class="nav-link arrow-none waves-effect" href="">
                <i class="ti-bell noti-icon"></i>
                <span class="badge badge-pill badge-danger noti-icon-badge">{{ count.lend }}</span>
            </a>
        </li>
        <!--<li class="dropdown notification-list">-->
        <!--<a class="nav-link arrow-none waves-effect" href="">-->
        <!--<i class="ti-email noti-icon"></i>-->
        <!--<span class="badge badge-pill badge-danger noti-icon-badge">10</span>-->
        <!--</a>-->
        <!--</li>-->
    </span>
</template>

<script>
    import ReqMixins from 'mixins/request'
    import PermissionMixins from 'mixins/permission'

    export default {
        api: 'notify',
        mixins: [ReqMixins, PermissionMixins],
        data: () => ({
            // 防止突然消失問題
            isGetUserInfo: false,
            count: {
                lend: 0,
                bankAccount: 0
            },
            timer: null
        }),
        methods: {
            async getNotifyCount() {
                this.isGetUserInfo = true
                this.canBankAccountList && this.proccessAjax('bankAccountList', {}, res => {
                    this.count.bankAccount = res.data
                }, false)
                this.canLendManage && this.proccessAjax('lendManage', {}, res => {
                    this.count.lend = res.data.total
                }, false)
            }
        },
        computed: {
            canBankAccountList() {
                return this.isGetUserInfo && (this.hasPermission(Permission.BankAccountList) || this.isRole(Roles.ADMIN))
            },
            canLendManage() {
                return this.isGetUserInfo && (this.hasPermission(Permission.LendManageIndex) || this.hasPermission(Permission.LendManage))
            }
        },
        mounted() {
            this.$bus.on('userInfo.init', this.getNotifyCount)
            this.timer = setInterval(this.getNotifyCount, 10 * 1000)
        },
        destroyed() {
            this.$bus.off('userInfo.init')
        }
    }
</script>
