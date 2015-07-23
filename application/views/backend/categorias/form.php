<div class="campo">
	<label>Nome</label>
	<input type="text" name="nome" value="<?=set_value('nome')?>">
</div>

<fieldset class="grupo">
	<div class="campo grid4-1">
		<label>Categoria para</label>
		<select name="tipo">
			<option value="">-- Selecione --</option>
			<option value="produtos" <?=set_select('tipo','produtos',TRUE)?>>Produtos</option>
			<!-- <option value="notícias" <?=set_select('tipo','notícias')?>>Notícias</option> -->
		</select>
	</div>

	<div class="campo grid4-1">
		<label>Nível <!-- <span>só categoria de produto</span> --></label>
		<select id="snivel" name="nivel">
			<option <?=set_select('nivel','grupo')?> value="grupo">1 - Grupo</option>
			<option <?=set_select('nivel','linha')?> value="linha">2 - Linha</option>
			<option <?=set_select('nivel','categoria')?> value="categoria">3 - Categoria</option>
			<option <?=set_select('nivel','subcategoria')?> value="subcategoria">4 - Subcategoria</option>
		</select>
	</div>

	<div class="campo grid4-1">
		<label>Subcategoria de</label>
		<?php if($grupos != false): ?>
		<select id="smae" name="mae">
			<option value="">-- Selecione</option>
			<?php
				foreach($grupos as $g):
					$linhas = $this->obj->get_all(array('nivel' => 'linha','mae' => $g->id));
			?>
			<option class="select-grupo" value="<?=$g->id?>" <?=set_select('mae',$g->id)?>><?=$g->nome?></option>
				<?php
					if($linhas): foreach($linhas as $l):
						$categorias = $this->obj->get_all(array('nivel' => 'categoria','mae' => $l->id));
				?>
				<option class="select-linha" value="<?=$l->id?>" <?=set_select('mae',$l->id)?>>|--<?=$l->nome?></option>
					<?php if($categorias): foreach($categorias as $c): ?>
					<option class="select-categoria" value="<?=$c->id?>" <?=set_select('mae',$c->id)?>>|--|--<?=$c->nome?></option>
					<?php endforeach; endif; ?>
				<?php endforeach; endif; ?>
			<?php
				endforeach;
			?>
		</select>
		<?php else: ?>
		<p>
			Nenhum item disponível.
		</p>
		<?php endif; ?>
	</div>
</fieldset>

<input type="hidden" name="ativo" value="1">
