//
// JS Backend - Main
// Por Guilherme Müller
// http://guilhermemuller.com.br
// contato@guilhermemuller.com.br
//

(function() {

    //links com a classe 'js-voltar' voltam uma página na história
	$('a.js-voltar').click(function() {
		history.back();
		return false;
	});

    //funcionalidade de impressão
    $('a.js-imprimir').click(function() {
		window.print();
		return false;
	});

	//links com rel="external" abrirão em outra página
	$("a[rel='external']").click(function() {
		window.open( $(this).attr('href') );
		return false;
	});

    $('a.excluir-imagem').click(function() {
		if(confirm('Excluir esta imagem?')) {
			return true;
		} else {
			return false;
		}
	});

	$('a.excluir').click(function() {
		if(confirm('Confirma a exclusão?')) {
			return true;
		} else {
			return false;
		}
	});

    $.datepicker.setDefaults({
							 dateFormat: 'dd/mm/yy',
							 dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
							 dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
							 monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
							 monthNamesShort: ['Jan','Feb','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dec']
							 });

	$('.calendario').datepicker();

    /*
    -- Múltipla seleção
    */

	$('.tritem').on('click', function() {
		var chk = $(this).find('.chkselec');

		if(chk.prop('checked')) {
			chk.prop('checked',false);
		} else {
			chk.prop('checked',true);
		}
		chk.change();
	});

	$('.seleciona-todos').on('click', function() {
		var inputs = $('input.ck-selec');

		inputs.each(function() {
			var ck = $(this);

			if(ck.prop('checked')) {
				ck.prop('checked',false);
			} else {
				ck.prop('checked',true);
			}
			ck.change();
		});
	});

	$('input.ck-selec').on('click', function(event) {
		event.stopPropagation();
	});

	$('input.ck-selec').on('change',function(event) {
		var tr = $(this).parent().parent();

		//alert($(this).prop('checked'));

		if($(this).prop('checked')) {
			tr.addClass('trselec');
		} else {
			tr.removeClass('trselec');
		}

		//event.stopPropagation();
	});

    $('.excluir-varios').click(function() {
		if(!confirm('Confirma a exclusão dos itens selecionados?')) {
			return false;
		}

		var funcao = 'excluirvarios';
		var userfuncao = $(this).attr('data-funcao');
		if(userfuncao != undefined) {
			funcao = userfuncao;
		}

		var selecarray = [];

		var selecionados  = $('input[name="selecionados[]"]');
		selecionados.each(function() {
			if($(this).prop('checked')) {
				selecarray.push($(this).val());
			}
		});

		$.post(baseurlc+funcao,{'selecionados':selecarray},function(data) {
			//alert(data);

			selecionados.each(function() {
				if($(this).prop('checked')) {
					$(this).parent().parent().fadeOut();
				}
			});

			selecionados.prop('checked',false);
		});

		return false;
	});

    /*
    -- Tratamento de campos
    */

    function remove_extra(str) {
    	str = str.replace(/\./g,'');
    	str = str.replace(/\-/g,'');
    	str = str.replace(/\//g,'');
    	str = str.replace(/\(/g,'');
    	str = str.replace(/\)/g,'');
    	return str;
    }

    function format_num(num) {
    	num += ''; //transforma para string
    	num = num.replace(/\,/g,'.');
    	num = parseFloat(num);

    	if(isNaN(num)) {
    		return;
    	}

    	return num.toFixed(2).replace(/\./g,',');
    }

    function to_num(num) {
    	num += '';
    	num = num.replace(/\,/g,'.');
    	num = parseFloat(num);

    	return num;
    }

    $('.input-limpa').blur(function() {
		$(this).val(remove_extra($(this).val()).toUpperCase());
	});

	$('.input-email').blur(function() {
		$(this).val($(this).val().toLowerCase());
	});

    /*
    -- Autocompletar
    */

    function set_auto_complete(keyword) {
        //autocomplete
    	$(".ac-" + keyword).autocomplete({
    		source: function(request, response) {
    					$.ajax({
    						url: baseurl+'admin/' + keyword + 'pacotes/getjson',
    						data: { item: request.term },
    						dataType: "json",
    						type: "POST",
    						success: function(data) {
    							response(data);
    						}
    					});
    			  	},
    		select: function(event, ui) {
    					//console.log(ui.item.label);
    					$('.ac-' + keyword).val(ui.item.label);
    					$('.input-' + keyword).val(ui.item.value).trigger('change');

    					event.preventDefault();
    				},
    		minLength: 3
    	});
    }

})();
