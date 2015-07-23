$('.js-sortable').sortable({
	cursor: 'move',
	stop: function(event,ui) {
        var funcao = $(this).data('funcao');
        if(!funcao) {
            funcao = 'reordenar_ajax';
        }
		var str = $(this).sortable('serialize');
		var secao = $('#secao_cod').val();
		var obj = $('#obj_id').val();
		var tipo = $('#obj_tipo').val();

		$.post(baseurl+'admin/'+secao+'/'+funcao
			  ,{'ordem': str, 'obj': obj, 'tipo': tipo}
			  ,function() {
					var $resposta = $('.mensagem-resposta');
					$resposta.html('Ordem atualizada.').fadeIn('slow');

					setTimeout (function() { $resposta.fadeOut(); }, 2000);
				}
		);
	}
});
