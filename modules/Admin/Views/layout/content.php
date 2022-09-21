<?php
echo view('Modules\Admin\Views\layout/_header');
echo view('Modules\Admin\Views\layout/_sidebar');
echo $this->renderSection('content');
echo view('Modules\Admin\Views\layout/_footer');
