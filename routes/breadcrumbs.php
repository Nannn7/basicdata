<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

if (!Breadcrumbs::exists('basicdata')) {
    Breadcrumbs::for('basicdata', function (BreadcrumbTrail $trail) {
        $trail->push('Basic Data');
    });
}

Breadcrumbs::for('basicdata.currency', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata');
    $trail->push('Mata Uang', route('basicdata.currency.index'));
});

Breadcrumbs::for('basicdata.currency.create', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.currency');
    $trail->push('Tambah Mata Uang', route('basicdata.currency.create'));
});

Breadcrumbs::for('basicdata.currency.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.currency');
    $trail->push('Edit Mata Uang');
});

Breadcrumbs::for('basicdata.branch', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata');
    $trail->push('Cabang', route('basicdata.branch.index'));
});

Breadcrumbs::for('basicdata.branch.create', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.branch');
    $trail->push('Tambah Cabang', route('basicdata.branch.create'));
});

Breadcrumbs::for('basicdata.branch.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.branch');
    $trail->push('Edit Cabang');
});

Breadcrumbs::for('basicdata.holidaycalendar', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata');
    $trail->push('Holiday Calendar', route('basicdata.holidaycalendar.index'));
});

Breadcrumbs::for('basicdata.holidaycalendar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.holidaycalendar');
    $trail->push('Tambah Hari Libur', route('basicdata.holidaycalendar.create'));
});

Breadcrumbs::for('basicdata.holidaycalendar.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('basicdata.holidaycalendar');
    $trail->push('Edit Hari Libur');
});
