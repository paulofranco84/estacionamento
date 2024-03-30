$(document).ready(function () {

    $("select.precificacao").change(function () {

        var categoria_selecionada = $(this).children("option:selected").val().split("-");

        $(".estacionar_valor_hora").val(categoria_selecionada[1]);        

    });

});