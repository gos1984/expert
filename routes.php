<?php

return array(
	"^(/|)$" => "account/auth",
	"^auth$" => "account/auth",
	"^registr$" => "account/registr",
	"^forgot$" => "account/forgot",
	"^logout$" => "account/logout",
	"^entry$" => "account/entry",
	"^show\?.*$" => "account/show",
	"^confirm\?.*$" => "account/confirm",
	"^password\?.*$" => "account/password",
	"^password$" => "account/password",

	"^attestation(\/$|\?.*$|$)" => "attestation/index",
	"^attestation/show\?.*$" => "attestation/show",
	"^attestation/edit\?.*$" => "attestation/edit",

	"^results(\/$|\?.*$|$)" => "attestation/results",
	"^results/show\?.*$" => "attestation/show",

	"^check$" => "attestation/check",
	
	"^setting$" => "setting/index",
	"^setting/edit\?.*$" => "setting/edit",

	"^directory$" => "directory/index",
	"^directory/edit$" => "directory/edit",

	"^events(\/$|\?.*$|$)" => "events/index",
	"^events/show\?.*$" => "events/show",
	"^events/edit\?.*$" => "events/edit",
	
	"^personal$" => "personal/index",
	"^personal/docs$" => "personal/docs",
	"^personal/sertification$" => "personal/sertification",
	"^personal/password$" => "personal/password",
	"^personal/edit\?.*$" => "personal/edit",
	"^personal/show\?.*$" => "personal/show",

	"^reports$" => "reports/index",
	"^reports/vkk$" => "reports/vkk",
	"^reports/students$" => "reports/students",
	"^reports/experts$" => "reports/experts",
	"^reports/quantity$" => "reports/quantity",
	"^reports/detail$" => "reports/detail",
	"^reports/file\?.*$" => "reports/file",
	
	"^users(\/$|\?.*$|$)" => "users/index",
	"^experts(\/$|\?.*$|$)" => "users/experts",
	"^users/show\?.*$" => "users/show",
	"^users/edit\?.*$" => "users/edit",
);

?>