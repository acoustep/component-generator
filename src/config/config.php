<?php

return [
	/*
	 * Folder to retrieve the templates from.
	 * Alternatives may include foundation5, pure1, bootstrap2.
	 * You may create your own folder and put your own templates inside.
	 */
	'framework' => 'bootstrap3',
	/*
	 * Where to place the templates within the views directory.
	 * To put them in the root of views leave empty.
	 * To put them in subdirectories seperate by a forward slash.
	 */
	'target' => 'components',
	/*
	 * Put a prefix on filenames. 
	 * If you come from a Rails background and prefer to use an underscore to prefix partials then you can set that here.
	 */
	'prefix' => '',
	/*
	 * What to end the file in.
	 * If you dislike blade or use another template engine you can change it here for convenience.
	 */
	'postfix' => '.blade.php',
	/* Some templates may make use of PHP or Blade specific syntax.
	 * If you change your postfix to .php then you should change this to 'php'.
	 */
	'syntax' => 'blade',
];

