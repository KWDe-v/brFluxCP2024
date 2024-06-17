<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Vendedores</h2>

<?php if ($vendings): ?>
    <?php echo $paginator->infoText() ?>
    <table class="horizontal-table">
        <thead>
            <tr>
                <th><?php echo $paginator->sortableColumn('id', 'ID do Vendedor') ?></th>
                <th> <?php echo $paginator->sortableColumn('char_name', 'Nome do Vendedor') ?></th>
                <th>Title</th>
                <th><?php echo $paginator->sortableColumn('map', 'Mapa') ?></th>
                <th>X</th>
                <th>Y</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendings as $vending): ?>
                <tr>
                    <td width="50" align="right"  style="">
                        <?php if ($auth->actionAllowed('vending', 'viewshop')): ?>
                            <a href="<?php echo $this->url('vending', 'viewshop', array("id" => $vending->id)); ?>"><?php echo $vending->id; ?></a>
                        <?php else: ?>
                            <?php echo $vending->id ?>
                        <?php endif ?>
                    </td>
                    <td style="font-weight:bold;"> <?php echo $vending->char_name; ?></td>
                    
                    <td>
                       <img src="<?php echo $this->iconImage(671) ?>?nocache=<?php echo rand() ?>" />
                      <?php if ($auth->actionAllowed('vending', 'viewshop')): ?>
                            <a href="<?php echo $this->url('vending', 'viewshop', array("id" => $vending->id)); ?>"><?php echo $vending->title; ?></a>
                        <?php else: ?>
                            <?php echo $vending->title ?>
                        <?php endif ?>
                    </td>
                      
                    <td  style="color:blue;">
                      <?php echo $vending->map ?>
                    </td>
                    
                    <td>
                      <?php echo $vending->x ?>
                    </td>
                    
                    <td>
                      <?php echo $vending->y ?>
                    </td>
                    
                     <td>
                      <?php echo $vending->sex ?>
                    </td>
                   
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $paginator->getHTML() ?>
<?php else: ?>
    <p>Nenhum Vendedor encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
