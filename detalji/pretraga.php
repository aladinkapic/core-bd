<?php

$data = [
[
'table' => 'sluzbenici',
'columns' => [
'ime' => 'Aladin|Gab',
'jmbg' => '305994112460',
'datum_rodjenja' => Carbon::createFromFormat('d.m.Y', '10.04.2019')
],
'master' => true
]
];

$search = SearchController::search($data);