<h2>Dados Gerais</h2>

<?=form_open("admin/$this->kw/upt/dados_gerais"); ?>

<input type="hidden" name="item_id" value="<?=$item->id?>">

<fieldset class="grupo">
	<div class="campo">
		<label>Nome</label>
		<input type="text" name="nome" value="<?=$item->nome?>">
	</div>

	<div class="campo">
		<label>Preço (R$)</label>
		<input type="text" name="preco" value="<?=number_format($item->preco,2,',','')?>">
	</div>

	<div class="campo">
		<label>Peso <span>em gramas</span></label>
		<input type="text" name="peso" value="<?=$item->peso?>">
	</div>
</fieldset>

<!-- <div class="campo">
	<label>Slug</label>
	<input type="text" name="slug" value="<?=set_value('slug')?>">
</div> -->

<div class="campo">
	<label>Descrição</label>
	<textarea name="descricao" style="height: 15em"><?=$item->descricao?></textarea>
</div>

<div class="campo">
	<label>Ativo</label>
	<label class="checkbox"><input type="radio" name="ativo" <?=check_radio($item->ativo,'1')?> value="1"> Sim</label>
	<label class="checkbox"><input type="radio" name="ativo" <?=check_radio($item->ativo,'0')?> value="0"> Não</label>
</div>

<div class="detalhes-controles">
	<button class="botao botao-submit" type="submit" name="submit">
		Atualizar Dados
	</button>
</div>

<?=form_close()?>
