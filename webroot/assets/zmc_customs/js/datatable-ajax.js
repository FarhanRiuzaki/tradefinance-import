var DatatableRemoteAjaxDemo = {
    init:function(urlTarget,options,token) {
        var defaultOptions = {
            responsive:!0, 
            searchDelay:500, 
            processing:!0, 
            serverSide:!0, 
            ajax:{
                url: urlTarget,
                headers: {
                    'X-CSRF-Token': token
                },
                type : 'post',
                dataType : 'json'
            }
        };
        
        $.extend( defaultOptions, options );
        var dT = $("#kt_table_default").DataTable(defaultOptions)
        $("body").on("click", ".btn-delete-on-table", function(e) {
            e.preventDefault();
            var a = $(this).attr("href");
            var judul = ($(this).data('judul') == undefined ? 'Apakah Anda Yakin?' : $(this).data('judul'));
            var textmsg = ($(this).data('textmsg') == undefined ? 'Data ini akan terhapus secara permanen, pastikan anda yakin untuk menghapus data ini?' : $(this).data('textmsg'));
            var textok = ($(this).data('textok') == undefined ? 'Ok' : $(this).data('textok'));
            var textno = ($(this).data('textno') == undefined ? 'Batal' : $(this).data('textno'));
            swal.fire({
                title: judul,
                text: textmsg,
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: textok,
                cancelButtonText: textno
            }).then(e => {
                e.value ? $.ajax({
                    url: a,
                    type: "delete",
                    dataType: "json",
                    data: {
                        _csrfToken: token
                    },
                    beforeSend: function() {
                        swal.fire("Harap Menunggu", "Sedang melakukan penghapusan data.", "info")
                    },
                    success: function(e) {
                        200 == e.code ? (swal.fire("Success", e.message, "success"), dT.ajax.reload()) : (e.code, swal.fire("Ooopp!!!", e.message, "error"))
                    },
                    error: function() {
                        swal("Ooopp!!!", "Failed to deleted record, please try again", "error")
                    }
                }) : e.dismiss
            })
        })
    }
};

// jQuery(document).ready(function() {
//     DatatablesDataSourceAjaxServer.init()
// });