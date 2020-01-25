<!-- Jquery Core Js -->
{{--{{Html::script('bower_components/adminbsb-materialdesign/plugins/jquery/jquery.min.js')}}--}}
{{Html::script('bower_components/jquery/dist/jquery.min.js')}}

<!-- Bootstrap Core Js -->
{{--{{Html::script('bower_components/adminbsb-materialdesign/plugins/bootstrap/js/bootstrap.js')}}--}}
{{Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js')}}

{{--<!-- Slimscroll Plugin Js -->--}}
{{--{{Html::script('bower_components/adminbsb-materialdesign/plugins/jquery-slimscroll/jquery.slimscroll.js')}}--}}
{{Html::script('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}

<!-- Waves Effect Plugin Js -->
{{Html::script('bower_components/adminbsb-materialdesign/plugins/node-waves/waves.js')}}

<!-- Custom Js -->
{{--{{Html::script('bower_components/adminbsb-materialdesign/js/admin.js')}}--}}
{{Html::script('js/adminbsb-admin.js')}}

{{--<!-- Demo Js -->--}}
{{--{{Html::script('bower_components/adminbsb-materialdesign/js/demo.js')}}--}}
{{Html::script('js/plugins/waitMe.js')}}

{{--<!-- Demo Js -->--}}
{{--{{Html::script('bower_components/adminbsb-materialdesign/js/demo.js')}}--}}
{{Html::script('bower_components/adminbsb-materialdesign/plugins/bootstrap-notify/bootstrap-notify.js')}}

<script>

    var $_LOADING_ = {};
    var $_TABLE_ = {};
    var $_DATATABLE_OPTIONS_ = {
        "dom": 'Bfrtip',
        "responsive": true,
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
        },
        "pageLength": 10,
        "order": [2, "asc"]
    };

    function loadingCard(type, $this) {
        if (type == 'show') {
            $_LOADING_ = $($this).parents('.card').waitMe({
                effect: 'pulse',
                text: 'Aguarde...',
                bg: 'rgba(255,255,255,0.90)',
                color: '#555'
            });
        } else {
            $_LOADING_.waitMe('hide');
        }
    }

    $(function () {
        //Tooltip
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });

        //Popover
//        $('[data-toggle="popover"]').popover();
    })

    function showNotification(color, text) {
        $.notify({
                message: text
            },
            {
                type: color,
                allow_dismiss: true,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: 'bottom',
                    align: 'center'
                },
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} p-r-35" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
    }
</script>

@yield('script_content')