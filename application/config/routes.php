<?php

return [

	'' => [
		'controller' => 'main',
		'action' => 'index',
	],

	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],

	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],

	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout',
	],

	'movie/review/{id:\d+}' => [
		'controller' => 'movie',
		'action' => 'review',
	],

	'movie/add' => [
		'controller' => 'movie',
		'action' => 'add',
	],

	'comment/add' => [
		'controller' => 'comment',
		'action' => 'add',
	],
];