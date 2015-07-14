<h2>Informações principais</h2>

<div class="campo">
	<label>Nome <span>nome no menu do site</span></label>
	<input name="nome" type="text" value="<?=set_value('nome')?>">
</div>

<div class="campo">
	<label>Título <span>título que aparece dentro da página</span></label>
	<input name="titulo" type="text" value="<?=set_value('titulo')?>">
</div>

<div class="campo">
	<label>Texto <span>a formatação do texto e o tamanho da fonte serão ajustados automaticamente quando este texto for publicado no site</span></label>
	<textarea name="texto" style="height: 20em"><?=set_value('texto')?></textarea>
</div>

<h2>Informações Complementares</h2>

<p>
	<strong>Uso interno do sistema.</strong>
</p>

<div class="campo">
	<label>Página mãe <span>para criar submenus</span></label>
	<?php if($paginas): ?>
	<select name="mae">
		<option value="">-- Nenhuma --</option>
		<?php foreach($paginas as $row): ?>
		<option value="<?=$row->id?>" <?=set_select('mae',$row->id)?>><?=$row->nome?></option>
		<?php endforeach; ?>
	</select>
	<?php else: ?>
	<p>
		Nenhuma página cadastrada.
	</p>
	<?php endif; ?>
</div>

<fieldset class="grupo">
	<div class="campo grid4-2">
		<label>Editável</label>
		<select name="editavel">
			<option value="1" <?=set_select('editavel','1')?>>Sim</option>
			<option value="0" <?=set_select('editavel','0')?>>Não</option>
		</select>
	</div>

	<div class="campo grid4-1">
		<label>Menu</label>
		<input type="text" name="menu" value="<?=set_value('menu',1)?>">
	</div>

	<div class="campo grid4-1 ultima">
		<label>Submenu</label>
		<input type="text" name="submenu" value="<?=set_value('submenu',0)?>">
	</div>
</fieldset>

<div class="campo">
	<label>Código <span>não alterar - usado para identificar a página no sistema do site</span></label>
	<input name="codigo" type="text" value="<?=set_value('codigo')?>">
</div>

<div class="campo">
	<label>Ativa</label>
	<label class="checkbox">
		<input type="radio" name="ativo" <?=set_radio('ativo','1',TRUE)?> value="1">
		Sim
	</label>
	<label class="checkbox">
		<input type="radio" name="ativo" <?=set_radio('ativo','0')?> value="0">
		Não
	</label>
</div>