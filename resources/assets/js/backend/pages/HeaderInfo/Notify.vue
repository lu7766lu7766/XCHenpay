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
        <li class="dropdown notification-list"
            @click="$linkTo('/user/informationLists')">
            <a class="nav-link arrow-none waves-effect" href="">
                <i class="ti-email noti-icon"></i>
                <span class="badge badge-pill badge-danger noti-icon-badge">{{ count.unread }}</span>
            </a>
        </li>
    </span>
</template>

<script>
    import ReqMixins from 'mixins/request'

    export default {
        api: 'notify',
        mixins: [ReqMixins],
        data: () => ({
            isInit: false,
            count: {
                lend: 0,
                bankAccount: 0,
                unread: 0
            },
            timer: null,
            timer2: null,
        }),
        watch: {
            userInfo() {
                this.getNotifyCount()
                this.getUnreadCount()
            }
        },
        methods: {
            getNotifyCount() {
                this.isInit = true
                this.canBankAccountList && this.proccessAjax('bankAccountList', {}, res => {
                    this.count.bankAccount = res.data
                }, false)
                this.canLendManage && this.proccessAjax('lendManage', {}, res => {
                    this.count.lend = res.data.total
                }, false)
            },
            getUnreadCount() {
                clearInterval(this.timer2)
                this.proccessAjax('unread', {}, res => {
                    this.count.unread = res.data
                    this.timer2 = setTimeout(this.getUnreadCount, 10 * 1000)
                }, false)
            }
        },
        computed: {
            userInfo() {
                return UserInfo.this().getUser()
            },
            canBankAccountList() {
                return this.isInit && (UserInfo.this().has(Permission.BankAccountList) || UserInfo.this().is(Roles.ADMIN))
            },
            canLendManage() {
                return this.isInit && (UserInfo.this().has(Permission.LendManageIndex) || UserInfo.this().has(Permission.LendManage))
            }
        },
        mounted() {
            this.timer = setInterval(this.getNotifyCount, 10 * 1000)
            this.timer2 = setTimeout(this.getUnreadCount, 10 * 1000)
            this.$bus.on('getUnreadCount', this.getUnreadCount)
        },
        destroyed() {
            clearInterval(this.timer)
            clearTimeout(this.timer2)
            this.$bus.off('getUnreadCount')
        }
    }
</script>
