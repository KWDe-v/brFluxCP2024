<?php if (!defined('FLUX_ROOT')) exit; ?>
							</td>
							<td bgcolor="#8888f9"></td>
						</tr>

						<tr>
							<td><img src="<?php echo $this->themePath('img/content_bl.gif') ?>" style="display: block" /></td>
							<td bgcolor="#8888f9"></td>
							<td><img src="<?php echo $this->themePath('img/content_br.gif') ?>" style="display: block" /></td>
						</tr>
					</table>
				</td>
				<!-- Spacing between content and horizontal end-of-page -->
				<td style="padding: 10px"></td>
			</tr>
			<?php if (Flux::config('ShowCopyright')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="copyright">
					<p>
						<strong>Desenvolvido Por <a href="https://github.com/rathena/FluxCP" target="_blank"  style="color: #555!important;">FluxCP</a></strong>
						<br>
						<strong>Traduzido & Otimizado Por <a href="https://discord.gg/RbGj9sUYzw" target="_blank" style="color: #555!important;">KWDev</a></strong>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>
			<?php if (Flux::config('ShowRenderDetails')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="info">
					<p>
					    Página gerada em <strong><?php echo round(microtime(true) - __START__, 5) ?></strong> segundo(s).
					    Número de consultas executadas: <strong><?php echo (int)Flux::$numberOfQueries ?></strong>.
					    <?php if (Flux::config('GzipCompressOutput')): ?>Compactação Gzip: <strong>Ativada</strong>.<?php endif ?>
					</p>

				</td>
				<td></td>
			</tr>
			<?php endif ?>
						<?php if (count(Flux::$appConfig->get('ThemeName', false)) > 1): ?>
			<tr>
				<td colspan="3"></td>
				<td align="right">
				<span>Tema:
					<select name="preferred_theme" onchange="updatePreferredTheme(this)">
						<?php foreach (Flux::$appConfig->get('ThemeName', false) as $themeName): ?>
    						<?php if($themeName == 'default'){?> 
						        <option value="<?php echo htmlspecialchars($themeName) ?>"<?php if ($session->theme == $themeName) echo ' selected="selected"' ?>><?php echo 'Padrão' ?></option>
						    <?php }else{ ?>
						        <option value="<?php echo htmlspecialchars($themeName) ?>"<?php if ($session->theme == $themeName) echo ' selected="selected"' ?>><?php echo htmlspecialchars($themeName) ?></option>
						    <?php } ?>
						<?php endforeach ?>
					</select>
					</span>
					
					<form action="<?php echo $this->urlWithQs ?>" method="post" name="preferred_theme_form" style="display: none">
						<input type="hidden" name="preferred_theme" value="" />
					</form>
				</td>
				<td></td>
			</tr>
			<?php endif ?>

            <tr>
                <td colspan="3"></td>
                <td align="right">
                            <span>Idioma:
                                <select name="preferred_language" onchange="updatePreferredLanguage(this)">
                                    <?php foreach (Flux::getAvailableLanguages() as $lang_key => $lang): ?>
                                        <option value="<?php echo htmlspecialchars($lang_key) ?>"<?php if (!empty($_COOKIE['language']) && $_COOKIE['language'] == $lang_key) echo ' selected="selected"' ?>><?php echo htmlspecialchars($lang) ?></option>
                                    <?php endforeach ?>
                                    </select>
                                </span>
                </td>
                <td></td>
            </tr>
		</table>
	</body>
</html>
