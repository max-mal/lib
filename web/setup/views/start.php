<?php
    $canStart = true;
?>
<div class="requirements">
    <h4>Системные требования</h4>

    <table rules="1" border="1" style="border-collapse: collapse;"> 
    <?php foreach ($this->requiredModules as $module) :?>
        <tr>
            <td><?=$module?></td>
            <?php
            $isInstalled = extension_loaded($module);

            if (!$isInstalled) {
                $canStart = false;
            }
            ?>  
            <td <?=$isInstalled? '' : 'style="background: red;"'?> ><?=$isInstalled? 'Установленно' : 'Не установлено'?></td>
        </tr>
    <?php endforeach; ?>
    </table>

    <?php if ($canStart) :?>
        <a href="/setup/?start=1"><button>Начать установку</button></a>
    <?php endif;?>
</div>