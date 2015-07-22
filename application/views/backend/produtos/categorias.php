<h2>Categorias</h2>

<?php if($grupos != false): ?>

<p>
	Escolha uma ou mais categorias:
</p>

<?=form_open("admin/$this->kw/upt/categorias"); ?>

<input type="hidden" name="item_id" value="<?=$item->id?>">

<?php
	foreach($grupos as $g):
		$linhas = $this->cat->getAll(array('nivel' => 'linha', 'mae' => $g->id));
?>
<!-- grupo -->
<div class="categoria-grupo grupo">

<div class="campo check-grupo clear">
	<label class="checkbox">
		<input type="checkbox" name="categorias[]" class="ck-grupo grupo<?=$g->id?>" value="<?=$g->id?>" <?php if(in_array($g->id,$categorias)) echo 'checked'; ?>>
		<?=$g->nome?>
	</label>
</div>

	<?php if($linhas): ?>

	<?php
		foreach($linhas as $l):
			$categorias = $this->cat->getAll(array('nivel' => 'categoria', 'mae' => $l->id, 'orderby' => 'nome ASC'));
	?>
	<!-- linha -->
	<div class="categoria-linha grupo">

	<div class="campo check-linha">
		<label class="checkbox">
			<input type="checkbox" name="categorias[]" class="ck-linha grupo<?=$g->id?> linha<?=$l->id?>" value="<?=$l->id?>" <?php if(in_array($l->id,$categorias)) echo 'checked'; ?>>
			<?=$l->nome?>
		</label>
	</div>

		<?php if($categorias): ?>
		<?php
			foreach($categorias as $c):
				$subcategorias = $this->cat->getAll(array('nivel' => 'subcategoria', 'mae' => $c->id));
		?>
		<!-- categoria -->
		<div class="categoria-categoria grupo">

		<div class="campo check-categoria f-esq">
			<label class="checkbox">
				<input type="checkbox" name="categorias[]" class="ck-cat grupo<?=$g->id?> linha<?=$l->id?> cat<?=$c->id?>" value="<?=$c->id?>" <?php if(in_array($c->id,$categorias)) echo 'checked'; ?>>
				<?=$c->nome?>
			</label>
		</div>

				<!-- subcategoria -->
				<div class="categoria-subcategoria grupo">

				<?php if($subcategorias): ?>
				<?php foreach($subcategorias as $s): ?>

				<div class="campo check-subcategoria f-esq">
					<label class="checkbox">
						<input type="checkbox" name="categorias[]" class="ck-subcat grupo<?=$g->id?> linha<?=$l->id?> cat<?=$c->id?> subcat<?=$s->id?>" value="<?=$s->id?>" <?php if(in_array($s->id,$categorias)) echo 'checked'; ?>>
						<?=$s->nome?>
					</label>
				</div>

				<?php endforeach; ?>
				<?php endif; ?>

				</div>
				<!-- /subcategoria -->
		</div>
		<!-- /categoria -->
		<?php endforeach; ?>

		<?php endif; ?>
	</div>
	<!-- /linha -->
	<?php endforeach; ?>

	<?php endif; ?>

</div>
<!-- /grupo -->
<?php endforeach; ?>

<div class="detalhes-controles">
	<button class="botao botao-submit" type="submit" name="submit">
		Atualizar Dados
	</button>
</div>

<?=form_close()?>

<?php else: ?>
<p>
    Nenhuma categoria cadastrada.
</p>
<?php endif; ?>
