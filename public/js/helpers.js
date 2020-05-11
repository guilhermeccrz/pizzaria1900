// Excluir  item pela ID e remove  <TR>
function excluiItemTr(el, url){
    if(confirm("Tem certeza que deseja excluir?")) {
        $.ajax({
            "type": 'GET',
            "url": url,
            "success": function (data) {
                if (data == "1") {
                    $(el).parent().parent().remove();
                }
                else {
                    alert("Não foi possível excluir");
                }
            },
            "error": function (data) {
                alert("Não foi possível excluir");
            }
        });
    }
}

// modal de confirm
function confirmDialog(message, onConfirm){
    var fClose = function(){
        modal.modal("hide");
    };
    var modal = $("#confirmModal");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#confirmOk").unbind().one('click', onConfirm).one('click', fClose);
    $("#confirmCancel").unbind().one("click", fClose);
}

$(document).ready(function() {
    // aplica o datatable caso haja alguma tablela com id (data-table)
    if($('#data-table').length) {
        var oTable = $('#data-table').DataTable({

            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });
    }
});
