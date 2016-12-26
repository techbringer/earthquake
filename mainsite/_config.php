<?php
use SaltedHerring\Debugger;

global $project;
$project = 'mainsite';

global $database;
$database = SS_DATABASE_NAME;

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");

// GD::set_default_quality(90);
// Image::set_backend("OptimisedGDBackend");
ImagickBackend::set_default_quality(90);
Image::set_backend("ImagickBackend");

SS_Cache::set_cache_lifetime('Person', 31536000, 1000); //cache for a year

Requirements::set_write_js_to_body(false);

if (Director::isLive()) {
	SS_Log::add_writer(new SS_LogEmailWriter('leo@leochen.co.nz'), SS_Log::ERR);
}

i18n::set_locale('en_NZ');
Translatable::set_default_locale('en_NZ');
Translatable::set_allowed_locales(
	array(
		'zh_Hans',
		'zh_Hant',
		'en_NZ',
		'ja_JP',
		'ko_KR',
		'th_TH'
	)
);
Object::add_extension('SiteTree', 'Translatable');
Object::add_extension('SiteConfig', 'Translatable');
