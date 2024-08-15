var asInitVals = new Array();
$(document).ready(function () {
    var oTable = $('#usuarios').dataTable({
        "oLanguage": {
            "sSearch": "Pesquisar:"
        },
        "aoColumnDefs": [
            {
                'bSortable': false,
                'aTargets': [0]
            } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo base_url('../../templates/TPub/js/datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
        }
    });
    var oTable = $('#novos').dataTable({
        "oLanguage": {
            "sSearch": "Pesquisar:"
        },
        "aoColumnDefs": [
            {
                'bSortable': false,
                'aTargets': [0]
            } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo base_url('../../templates/TPub/js/datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
        }
    });
    var oTable = $('#rejeitados').dataTable({
        "oLanguage": {
            "sSearch": "Pesquisar:"
        },
        "aoColumnDefs": [
            {
                'bSortable': false,
                'aTargets': [0]
            } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo base_url('../../templates/TPub/js/datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
        }
    });
    $("tfoot input").keyup(function () {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
    });
    $("tfoot input").each(function (i) {
        asInitVals[i] = this.value;
    });
    $("tfoot input").focus(function () {
        if (this.className == "search_init") {
            this.className = "";
            this.value = "";
        }
    });
    $("tfoot input").blur(function (i) {
        if (this.value == "") {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    });
});

