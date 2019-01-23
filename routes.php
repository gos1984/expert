<?php

return array(
	"^auth$" => "account/auth",
	"^registr$" => "account/registr",
	"^forgot$" => "account/forgot",
	"^logout$" => "account/logout",

	"^attestation(\/$|\?.*$|$)" => "attestation/index",
	"^attestation/show\?.*$" => "attestation/show",
	"^attestation/edit\?.*$" => "attestation/edit",

	"^results(\/$|\?.*$|$)" => "attestation/results",
	"^results/show\?.*$" => "attestation/show",

	"^check$" => "attestation/check",
	
	
	"^reports$" => "reports/index",
	
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
	
	"^users(\/$|\?.*$|$)" => "users/index",
	"^experts(\/$|\?.*$|$)" => "users/experts",
	"^users/show\?.*$" => "users/show",
	"^users/edit\?.*$" => "users/edit",
);

?>