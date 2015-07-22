//
// JS Frontend - Main
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

	//links com rel="external" abrirão em outra página
	$("a[rel='external']").click(function() {
		window.open( $(this).attr('href') );
		return false;
	});

})();
