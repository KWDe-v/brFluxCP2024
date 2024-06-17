<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Reinstalar Esquemas de Banco de Dados</h2>
<p>Você pode reinstalar seus arquivos de esquema de banco de dados (arquivos *.sql) a partir desta interface. Se você tem absoluta certeza de que deseja prosseguir, clique em "continuar".</p>
<p><strong>Nota:</strong> Ao fazer isso, você pode acabar com índices duplicados em suas tabelas MySQL, mas eles não são prejudiciais (esta funcionalidade é altamente experimental).</p>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="reinstall" value="1" />
	<table class="generic-form-table">
		<tr>
			<td><p>Você tem absoluta certeza de que deseja continuar?</p></td>
		</tr>
		<tr>
			<td><input type="submit" value="Continuar" /></td>
		</tr>
	</table>
</form>
