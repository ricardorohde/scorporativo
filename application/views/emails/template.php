<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->config->item('site_title')?></title>
</head>
<body style="margin:0; padding:0;" bgcolor="<?=$this->config->item('email_bg')?>">
<table width="100%" align="center"bgcolor="<?=$this->config->item('email_bg')?>" style="font-family:Arial, Tahoma, sans-serif; font-size:12px" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>

<br />

<table width="600" align="center" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td bgcolor="<?=$this->config->item('email_bg')?>"><img style="display: block" src="<?=base_url()?>imagens/estrutura/<?=$this->config->item('arquivo_logo')?>" alt="<?=$this->config->item('site_title')?>" /><br /></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFFF" style="font-family:Arial, Tahoma, sans-serif; font-size:12px" align="left" valign="top">
			<div style="padding: 10px 20px; font-size:12px; text-align:left; color: #000000">
				
				<?=$content?>
				
			</div>
		</td>
	</tr>
</table>

<table width="600" align="center" style="font-family:Arial, Tahoma, sans-serif; font-size:12px" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
			<br />
			<p style="font-size: 11px; color: #333333">
				<strong><?=$this->config->item('site_title')?></strong>
				<br />
				<a href="mailto:<?=$this->config->item('email_principal')?>" style="color: #333333"><?=$this->config->item('email_principal')?></a>
				<br />
				<a href="http://www.<?=$this->config->item('dominio')?>" style="color: #333333">www.<?=$this->config->item('dominio')?></a>
			</p>
		</td>
	</tr>
</table>

</td>		
</tr>
</table>
</body>
</html>