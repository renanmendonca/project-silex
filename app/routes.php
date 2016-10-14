<?php

// Register routes
$app->get(
    '/instagram/{tag_name}', "instagram.controller:indexAction"
)->value('tag_name', null);