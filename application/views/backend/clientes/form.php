<fieldset class="grupo">
	<div class="campo grid2-1">
		<label>Nome</label>
		<input type="text" name="nome" value="<?=set_value('nome')?>">
	</div>

	<div class="campo grid2-1 ultima">
		<label>E-mail</label>
		<input type="email" name="email" value="<?=set_value('email')?>">
	</div>
</fieldset>

<fieldset class="grupo">
	<div class="campo grid2-1">
		<label>Senha</label>
		<input type="password" name="senha">
	</div>

	<div class="campo grid2-1 ultima">
		<label>Confirmação de Senha</label>
		<input type="password" name="senha_conf">
	</div>
</fieldset>

<div class="campo">
	<label>Ativo?</label>
	<label class="checkbox"><input type="radio" name="ativo" <?=set_radio('ativo','1',TRUE)?> value="1"> Sim</label>
	<label class="checkbox"><input type="radio" name="ativo" <?=set_radio('ativo','0')?> value="0"> Não</label>
</div>