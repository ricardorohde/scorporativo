<h2>Categorias</h2>

<?php if($grupos != false): //1 ?>

<p>
	Escolha uma ou mais categorias:
</p>

<?=form_open("admin/$this->kw/upt/categorias"); ?>

<input type="hidden" name="item_id" value="<?=$item->id?>">

<?php
	foreach($grupos as $g): //fe1
		$linhas = $this->cat->get_all(array('nivel' => 'linha', 'mae' => $g->id));
?>
<!-- grupo -->
<ul class="categoria-grupo grupo">
	<li class="campo check-grupo clear">
		<label class="checkbox">
			<input type="checkbox" name="categorias[]" class="ck-grupo grupo<?=$g->id?>" value="<?=$g->id?>" <?php if(in_array($g->id,$produto_categorias)) echo 'checked'; ?>>
			<?=$g->nome?>
		</label>
	</li>

	<?php if($linhas): //2 ?>
	<!-- linha -->
	<ul class="categoria-linha grupo">
		<?php
			foreach($linhas as $l): //fe2
				$categorias = $this->cat->get_all(array('nivel' => 'categoria', 'mae' => $l->id));
		?>
		<li class="campo check-linha">
			<label class="checkbox">
				<input type="checkbox" name="categorias[]" class="ck-linha grupo<?=$g->id?> linha<?=$l->id?>" value="<?=$l->id?>" <?php if(in_array($l->id,$produto_categorias)) echo 'checked'; ?>>
				<?=$l->nome?>
			</label>
		</li>

		<?php if($categorias): //3 ?>
		<!-- categoria -->
		<ul class="categoria-categoria grupo">
			<?php
				foreach($categorias as $c): //fe3
					$subcategorias = $this->cat->get_all(array('nivel' => 'subcategoria', 'mae' => $c->id));
			?>
			<li class="campo check-categoria f-esq">
				<label class="checkbox">
					<input type="checkbox" name="categorias[]" class="ck-cat grupo<?=$g->id?> linha<?=$l->id?> cat<?=$c->id?>" value="<?=$c->id?>" <?php if(in_array($c->id,$produto_categorias)) echo 'checked'; ?>>
					<?=$c->nome?>
				</label>
			</li>

			<?php if($subcategorias): //4 ?>
			<!-- subcategoria -->
			<ul class="categoria-subcategoria grupo">
				<?php foreach($subcategorias as $s): //fe4 ?>
				<li class="campo check-subcategoria f-esq">
					<label class="checkbox">
						<input type="checkbox" name="categorias[]" class="ck-subcat grupo<?=$g->id?> linha<?=$l->id?> cat<?=$c->id?> subcat<?=$s->id?>" value="<?=$s->id?>" <?php if(in_array($s->id,$produto_categorias)) echo 'checked'; ?>>
						<?=$s->nome?>
					</label>
				</li>
			<?php endforeach; //fe4 ?>
			</ul><!-- /subcategoria -->
			<?php endif; //4 ?>
			<?php endforeach; //fe3 ?>
		</ul> <!-- /categoria -->
		<?php endif; //3 ?>
		<?php endforeach; //fe2 ?>
	</ul> <!-- /linha -->
	<?php endif; //2 ?>
<?php endforeach; //fe1 ?>
</ul> <!-- /grupo -->

<div class="detalhes-controles">
	<button class="botao botao-submit" type="submit" name="submit">
		Atualizar Dados
	</button>
</div>

<?=form_close()?>

<?php else: //1 ?>
<p>
    Nenhuma categoria cadastrada.
</p>
<?php endif; //1 ?>
