<?php
use hoaaah\sbadmin2\widgets\Menu;

echo Menu::widget([
  'options' => [
    'ulClass' => "navbar-nav sidebar sidebar-dark accordion",
    'ulId' => "accordionSidebar"
  ],
  // below code required for bs5 (data-bs-toggle & data-bs-target) - Sushil
  'subMenuTemplate' => '
    <li class="{liClass}">
      <a class="nav-link {collapsed-arrow}" href="#" data-bs-toggle="collapse" data-bs-target="#collapse{key}" aria-expanded="true" aria-controls="collapse{key}">
        <i class="{icon}"></i>
        <span>{label}</span>
      </a>
      <div id="collapse{key}" class="collapse {active-show}" aria-labelledby="headingTwo" data-parent="#{ulId}">
        <div class="bg-white py-2 collapse-inner rounded">
          {header}
          {link}
        </div>
      </div>
    </li>
  ',
  'brand' => [
    'url' => ['/'],
    'content' => '<img src="/images/nhm-logo.png" style="height: 50px;"><div>R.K.S. CHC Wangoi</div>'
  ],
  'items' => [
    ['label' => 'OPD Registration', 'url' => ['/opd/index'], 'icon' => 'fas fa-ticket-alt'],
    ['label' => 'Users', 'url' => ['/user/index'], 'icon' => 'fas fa-users'],
    [
      'label' => 'Settings',
      'icon' => 'fa fa-cog',
      'items' => [
        [ 'label' => 'Departments', 'url' => ['/department']],
        [ 'label' => 'OPD Sessions', 'url' => ['/opd-session']],
        [ 'label' => 'Religions', 'url' => ['/religion']],
        [ 'label' => 'OPD Ticket Settings', 'url' => ['/setting']],
      ],
    ],
  ],
]);
