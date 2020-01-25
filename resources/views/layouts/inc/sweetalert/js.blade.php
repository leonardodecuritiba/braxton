<!-- SweetAlert Plugin Js -->
{{Html::script('bower_components/sweetalert2/dist/sweetalert2.min.js')}}

<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>


<script>
    function removeDataTableByAjax($el) {
        $.ajax({
            url: $($el).data('href'),
            type: 'post',
            data: {"_method": 'delete', "_token": "{{ csrf_token() }}"},
            dataType: "json",

            beforeSend: function () {
                loadingCard('show', $el);
            },
            complete: function (xhr, textStatus) {
                loadingCard('hide', $el);
            },
            error: function (xhr, textStatus) {
                console.log('xhr-error: ' + xhr);
                console.log('textStatus-error: ' + textStatus);
            },
            /**/
            success: function (json) {
                console.log(json);
                if (json) {
                    swal(
//                "<i class='em em-disappointed_relieved'></i>",
                        "",
//                    "<i class='em em-disappointed_relieved'></i> Removido (a)!",
                        "<b>" + $($el).data('entity') + "</b> removido (a) com sucesso!",
                        "success"
                    )
                    var $_table_ = $($el).parents('table').DataTable();
                    // $_TABLE_
                    $_table_
                        .row($($el).parents('tr'))
                        .remove()
                        .draw();
                } else {
                    swal(
//                "<i class='em em-disappointed_relieved'></i>",
                        "",
//                    "<i class='em em-disappointed_relieved'></i> Removido (a)!",
                        "<b>Erro!</b> Nenhuma alteração realizada",
                        "error"
                    )
                }
            }
        });
    }

    function showDeleteTableMessage($el) {
        var entity = $($el).data('entity');
        swal({
            title: "Você tem certeza?",
            text: "Esta ação será irreversível!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
//            confirmButtonText: "<i class='em em-triumph'></i> Sim! ",
//            cancelButtonText: "<i class='em em-cold_sweat'></i> Não, cancele por favor! ",
            confirmButtonText: "Sim! ",
            cancelButtonText: "Não, cancelar! "
        }).then(
            function () {
                removeDataTableByAjax($el);
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    swal(
                        "Cancelado",
                        "Nenhuma alteração realizada!",
                        //                    "<i class='em em-heart_eyes'></i>",
                        //                    "Ufa, <b>" + entity + "</b> está a salvo :)",
                        "error"
                    )
                } else {
                    alert(1);
                }
            }
        );
    }
</script>