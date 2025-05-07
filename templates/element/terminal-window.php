<?php
/**
 * @var \Cake\View\View $this
 * @var string $functionName
 * @var string $text
 */

?>

<div class="terminal-window__header position-relative">
    &nbsp;
    <div class="terminal-window__header__fan ms-3">
        <div class="d-inline">
            Terminal Window &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="d-inline">x</div>
    </div>
    <div class="terminal-window__header__buttons position-absolute translate-middle-y text-white">
        <div class="d-inline pe-3 ps-3">
            -
        </div>
        <div class="d-inline pe-3 ps-3">
            &#x25FB;
        </div>
        <div class="d-inline pe-3 ps-3">
            X
        </div>
    </div>
</div>
<div class="terminal-window__content">
    Windows PowerShell <br>
    Copyright (C) Microsoft Corporation. All rights reserved. <br> <br>

    Install the latest PowerShell for new features and improvements! https://aka.ms/PSWindows <br> <br>

    PS C:\Users\AndreasØstergårdChri>run <?= $functionName ?>('This is an example') <br>
    PS C:\Users\AndreasØstergårdChri>This is an example
</div>
