<h1>
	<?php if($acao == "novo"): ?>
	Cadastre-se
	<?php else: ?>
	Alterar Cadastro
	<?php endif; ?>
</h1>

<?php if(validation_errors()): ?>
<div class="mensagem mensagem-erro">
	<?=validation_errors()?>
</div>
<?php endif; ?>

<?php if($acao == "novo"): ?>
<p>
	Campos marcados com <abbr class="obrigatorio" title="preenchimento obrigatório">*</abbr> são de preenchimento obrigatório.
</p>
<?php endif; ?>

<div class="form form-padrao form-cadastro">
	
	<?=form_open(current_url())?>

	<fieldset>				
		<div class="campo">
			<label for="nome">Nome Completo <?php if($acao == "novo"): ?><abbr title="preenchimento obrigatório">*</abbr><?php endif; ?></label>
			<input type="text" id="nome" name="nome" value="<?=set_value('nome')?>">
		</div>

		<fieldset class="grupo">
			<div class="campo grid2-1">
				<label for="email">E-mail <?php if($acao == "novo"): ?><abbr title="preenchimento obrigatório">*</abbr><?php endif; ?></label>
				<input type="email" id="email" name="email" value="<?=set_value('email')?>">
			</div>

			<?php if($acao == "novo"): ?>
			<div class="campo grid2-1 ultima">
				<label for="emailconf">Confirme seu E-mail <abbr title="preenchimento obrigatório">*</abbr></label>
				<input type="email" id="emailconf" name="emailconf" value="<?=set_value('emailconf')?>">
			</div>
			<?php endif; ?>
		</fieldset>
		
		<?php if($acao == "alterar"): ?>
		<p>
			<strong>Atenção</strong>: apenas preencha a senha caso deseje alterá-la.
		</p>
		<?php endif; ?>

		<fieldset class="grupo">
			<div class="campo grid2-1">
				<label for="senha">Senha <?php if($acao == "novo"): ?><abbr title="preenchimento obrigatório">*</abbr><?php endif; ?></label>
				<input type="password" id="senha" name="senha" value="">
			</div>

			<div class="campo grid2-1 ultima">
				<label for="senhaconf">Confirme sua Senha <?php if($acao == "novo"): ?><abbr title="preenchimento obrigatório">*</abbr><?php endif; ?></label>
				<input type="password" id="senhaconf" name="senhaconf" value="">
			</div>
		</fieldset>
		
		<?php if($acao == "novo"): ?>
		<div class="campo esconde">
			<label for="naopreencher">Não preencher este campo (apenas para barrar spam)</label>
			<input type="text" id="naopreencher" name="naopreencher" value="">
		</div>
		<?php endif; ?>

	</fieldset>
	
	<button type="submit" name="submit" class="botao submit">
		<?php if($acao == "novo"): ?>
		Confirmar Cadastro
		<?php else: ?>
		Alterar Cadastro
		<?php endif; ?>
	</button>

	<?=form_close()?>

</div>

<?php if($acao == "novo"): ?>
<div class="site-voltar">
	<a href="<?=site_url('home')?>" class="js-voltar">Voltar</a>
</div>
<?php endif; ?>