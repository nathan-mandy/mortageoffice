<?php

$inc = sprintf('%s/includes/', get_stylesheet_directory());
$blocks = sprintf('%s/blocks/', $inc);

require_once $inc . 'mustache.php';
require_once $inc . 'enqueuer.php';
require_once $inc . 'reusable-blocks/taxonomy.php';
require_once $inc . 'post-types/event.php';

