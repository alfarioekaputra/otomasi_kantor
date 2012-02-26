<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('otomasi', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
