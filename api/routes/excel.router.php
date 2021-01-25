<?php

    $router->post('/masukData', 'TestController@masukData');
    $router->get('/keluarData', 'TestController@keluarData');
    $router->get('/cetak_pdf', 'TestCOntroller@cetak_pdf');