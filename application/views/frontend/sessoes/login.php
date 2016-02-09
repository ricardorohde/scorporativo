<h1>Entre na sua Conta</h1>

<div class="opcoes-login grupo">

	<div class="box grid2-1">
		<h2>Já estou cadastrado</h2>
		<div class="form form-padrao">

			<?php if(validation_errors() || $erro): ?>
			<div class="mensagem mensagem-erro">
				<?php if ($erro) echo $erro; ?>
				<?=validation_errors()?>
			</div>
			<?php endif; ?>

			<?=form_open(current_url())?>

			<fieldset class="form-login mb">
				
				<input type="hidden" name="tipo" value="cliente">
				
				<div class="campo">
					<label for="login">E-mail</label>
					<input type="text" autofocus id="login" name="login" value="<?=set_value('login')?>">
				</div>
				<div class="campo">
					<label for="senha">Senha</label>
					<input type="password" id="senha" name="senha">
				</div>
				<button class="botao submit" name="submit">
					Entrar
				</button>

			</fieldset>

			<?=form_close()?>
			
			<p>
				<a href="<?=site_url("sessoes/recuperar_conta")?>">
					Não consigo acessar minha conta
				</a>
			</p>

		</div>
	</div>

	<div class="box grid2-1 ultima">
		<h2>Ainda não tenho cadastro</h2>
	
		<a href="<?=site_url("cadastro")?>" class="botao cadastro">
			Cadastre-se Agora
		</a>
	</div>

</div>

<div class="site-voltar">
	<a href="<?=site_url('home')?>" class="js-voltar">Voltar</a>
</div>