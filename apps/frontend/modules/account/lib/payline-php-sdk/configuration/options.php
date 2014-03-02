<?php
	DEFINE( 'PAYMENT_CURRENCY', 978 ); // Default payment currency (ex: 978 = EURO)
	DEFINE( 'ORDER_CURRENCY', PAYMENT_CURRENCY );

	DEFINE( 'SECURITY_MODE', '' ); // Protocol (ex: SSL = HTTPS)
	DEFINE( 'LANGUAGE_CODE', 'eng' ); // Payline pages language

	DEFINE( 'PAYMENT_ACTION', 101 ); // Default payment method
	DEFINE( 'PAYMENT_MODE', 'CPT' ); // Default payment mode

	DEFINE('CANCEL_URL', 'http://www.payline.com'); // Default cancel URL
	DEFINE('NOTIFICATION_URL','http://www.payline.com'); // Default notification URL
	DEFINE('RETURN_URL', 'http://www.payline.com'); // Default return URL
	DEFINE('CUSTOM_PAYMENT_TEMPLATE_URL', ''); // Default payment template URL
	DEFINE( 'CUSTOM_PAYMENT_PAGE_CODE', '' );

	DEFINE( 'CONTRACT_NUMBER', '1234567' ); // Contract type default (ex: 001 = CB, 003 = American Express...)
	DEFINE( 'CONTRACT_NUMBER_LIST', '1234567' ); // Contract type multiple values (separator: ;)
	
	// Chemin d'accès au fichier wsdl d'homologation primaire
	DEFINE( 'PRIMARY_HOMO_WSDL_SOAP', dirname(__FILE__).'/../wsdl/homologation/WebPaymentAPI.wsdl' );
	DEFINE( 'PRIMARY_HOMO_WSDL_DIRECT_SOAP', dirname(__FILE__).'/../wsdl/homologation/DirectPaymentAPI.wsdl' );
	DEFINE( 'PRIMARY_HOMO_WSDL_EXTENDED_SOAP', dirname(__FILE__).'/../wsdl/homologation/ExtendedAPI.wsdl' );
	
	// Chemin d'accès aux fichiers wsdl d'homologation secondaire
	DEFINE( 'SECONDARY_HOMO_WSDL_SOAP', dirname(__FILE__).'/../wsdl/homologationHD/WebPaymentAPI.wsdl' );
	DEFINE( 'SECONDARY_HOMO_WSDL_DIRECT_SOAP', dirname(__FILE__).'/../wsdl/homologationHD/DirectPaymentAPI.wsdl' );
	DEFINE( 'SECONDARY_HOMO_WSDL_EXTENDED_SOAP', dirname(__FILE__).'/../wsdl/homologationHD/ExtendedAPI.wsdl' );
	
	// Chemin d'accès aux fichiers wsdl de production primaire
	DEFINE( 'PRIMARY_PROD_WSDL_SOAP', dirname(__FILE__).'/../wsdl/production/WebPaymentAPI.wsdl' );
	DEFINE( 'PRIMARY_PROD_WSDL_DIRECT_SOAP', dirname(__FILE__).'/../wsdl/production/DirectPaymentAPI.wsdl' );
	DEFINE( 'PRIMARY_PROD_WSDL_EXTENDED_SOAP', dirname(__FILE__).'/../wsdl/production/ExtendedAPI.wsdl' );
	
	// Chemin d'accès aux fichiers wsdl de production secondaire
	DEFINE( 'SECONDARY_PROD_WSDL_SOAP', dirname(__FILE__).'/../wsdl/productionHD/WebPaymentAPI.wsdl' );
	DEFINE( 'SECONDARY_PROD_WSDL_DIRECT_SOAP', dirname(__FILE__).'/../wsdl/productionHD/DirectPaymentAPI.wsdl' );
	DEFINE( 'SECONDARY_PROD_WSDL_EXTENDED_SOAP', dirname(__FILE__).'/../wsdl/productionHD/ExtendedAPI.wsdl' );
		
	// Durées du timeout d'appel des webservices
	DEFINE( 'PRIMARY_CALL_TIMEOUT', 15);
	DEFINE( 'SECONDARY_CALL_TIMEOUT', 15 );
	
	// Nombres de tentatives sur les chaines primaire et secondaire par transaction
	DEFINE( 'PRIMARY_MAX_FAIL_RETRY', 1 );
	DEFINE( 'SECONDARY_MAX_FAIL_RETRY', 2 );
	
	// Durées d'attente avant le rejoue de la transaction
	DEFINE( 'PRIMARY_REPLAY_TIMER', 15 );
	DEFINE( 'SECONDARY_REPLAY_TIMER', 15 );
		
	DEFINE( 'PAYLINE_ERR_CODE', '02101,02102,02103' ); // Codes erreurs payline qui signifie l'échec de la transaction
		
	DEFINE( 'PAYLINE_WS_SWITCH_ENABLE',  ''); // Nom des services web autorisés à basculer

	DEFINE( 'PAYLINE_SWITCH_BACK_TIMER', 600 ); // Durées d'attente pour rebasculer en mode nominal
		
	DEFINE( 'PRIMARY_TOKEN_PREFIX', '1' ); // Préfixe du token sur le site primaire
	
	DEFINE( 'SECONDARY_TOKEN_PREFIX', '2' ); // Préfixe du token sur le site secondaire
	DEFINE( 'INI_FILE' , dirname(__FILE__).'/../properties/HighDefinition.ini'); // Chemin du fichier ini
	
	DEFINE( 'PAYLINE_ERR_TOKEN', '02317,02318' ); // Préfixe du token sur le site primaire

?>