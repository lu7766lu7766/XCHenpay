// bootstrap wizard//
$("#gender, #gender1").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
$('input[type="checkbox"].custom-checkbox').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    increaseArea: '20%'
});
$("#dob").datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning:{
        vertical:'bottom'
    },
    keepOpen:false,
    useCurrent: false,
    maxDate: moment().add(1,'h').toDate()
});
$("#commentForm").bootstrapValidator({
    fields: {
        company_name: {
            validators: {
                notEmpty: {
                    message: '商户名称请勿留空'
                },
                stringLength: {
                    min: 6,
                    message: '商户名称必须大于6个字元'
                }
            }
        },
        mobile: {
            validators: {
                notEmpty: {
                    message: '联络人手机请勿留空'
                },
                phone: {
                    country: 'CN',
                    message: '请输入有效的手机号码'
                }
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: '电子邮箱请勿留空'
                },
                emailAddress: {
                    message: '请输入有效的电子邮箱'
                }
            }
        },
        QQ_id: {
            validators: {
                integer:{
                    message: 'QQ号必须为数字'
                },
                stringLength: {
                    min: 6,
                    message: 'QQ号必须大于6个字元'
                }
            }
        },
        password: {
            validators: {
                stringLength: {
                    min: 6,
                    message: '密码必须大于6个字元'
                }
            }
        },
        password_confirm: {
            validators: {
                identical: {
                    field: 'password',
                    message: '与密码不符'
                }
            }
        },
        group: {
            validators:{
                notEmpty:{
                    message: '必须选择权限角色'
                }
            }
        }
    }
});

$('#rootwizard').bootstrapWizard({
    'tabClass': 'nav nav-pills',
    'onNext': function(tab, navigation, index) {
        var $validator = $('#commentForm').data('bootstrapValidator').validate();
        return $validator.isValid();
    },
    onTabClick: function(tab, navigation, index) {
        return false;
    },
    onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index + 1;

        // If it's the last tab then hide the last button and show the finish instead
        if ($current >= $total) {
            $('#rootwizard').find('.pager .next').hide();
            $('#rootwizard').find('.pager .finish').show();
            $('#rootwizard').find('.pager .finish').removeClass('disabled');
        } else {
            $('#rootwizard').find('.pager .next').show();
            $('#rootwizard').find('.pager .finish').hide();
        }
    }});


$('#rootwizard .finish').click(function () {
    var $validator = $('#commentForm').data('bootstrapValidator').validate();
    if ($validator.isValid()) {
        document.getElementById("commentForm").submit();
    }

});
$('#activate').on('ifChanged', function(event){
    $('#commentForm').bootstrapValidator('revalidateField', $('#activate'));
});