<?php
//
// Payline Class
// Copyright Monext
//
	require_once('jIniFileModifier.php');
//
// OBJECTS DEFINITIONS
//

class paylineUtil{

	/**
	 * make an array from a payline server response object.
	 * @params : $response : Objet response from experian
	 * @return : Object convert in an array
	**/
	static function responseToArray($response){

		$array = array();
		foreach($response as $k=>$v){
			if (is_object($v))  { $array[$k] = paylineUtil::responseToArray($v); }
			else { $array[$k] = $v; }
			//			elseif(is_array($v)){ $array[$k] = paylineUtil::responseToArray($v); }

		}
		return $array;

	return $response;
	}
}

//
// PL_PAYMENT OBJECT DEFINITION
//
class pl_payment{

	// ATTRIBUTES LISTING
	public $amount;
	public $currency;
	public $action;
	public $mode;
	public $contractNumber;
	public $differedActionDate;

	function __construct() {
		$this->currency = PAYMENT_CURRENCY;
		$this->action = PAYMENT_ACTION;
		$this->mode = PAYMENT_MODE;
		$this->contractNumber = CONTRACT_NUMBER;
	}
}

//
// PL_ORDER OBJECT DEFINITION
//
class pl_order{

	// ATTRIBUTES LISTING
	public $ref;
	public $origin;
	public $country;
	public $taxes;
	public $amount;
	public $currency;
	public $date;
	public $quantity;
	public $comment;
	public $details;

	function __construct() {
		$this->date = date('d/m/Y H:i', time());
		$this->currency = ORDER_CURRENCY;
		$this->details = array();
	}
}

//
// PL_PRIVATEDATA OBJECT DEFINITION
//
class pl_privateData{

	// ATTRIBUTES LISTING
	public $key ;
	public $value;
}

//
// PL_AUTHORIZATION OBJECT DEFINITION
//
class  pl_authorization{

	// ATTRIBUTES LISTING
	public $number;
	public $date;
}

//
// PL_ADDRESS OBJECT DEFINITION
//
class  pl_address{

	// ATTRIBUTES LISTING
	public $name;
	public $street1;
	public $street2;
	public $cityName;
	public $zipCode;
	public $country;
	public $phone;
}

//
// PL_BUYER OBJECT DEFINITION
//
class pl_buyer{

	// ATTRIBUTES LISTING
	public $lastName;
	public $firstName;
	public $email;
	public $walletId;
	public $shippingAdress;
	public $accountCreateDate;
	public $accountAverageAmount;
	public $accountOrderCount;

	function __construct() {
		$this->accountCreateDate = date('d/m/y', time());
	}
}

//
// PL_ORDERDETAIL OBJECT DEFINITION
//
class pl_orderDetail{

	// ATTRIBUTES LISTING
	public $ref;
	public $price;
	public $quantity;
	public $comment;
}

//
// PL_CARD OBJECT DEFINITION
//
class pl_card{

	// ATTRIBUTES LISTING
	public $number;
	public $type;
	public $expirationDate;
	public $cvx;
	public $ownerBirthdayDate;
	public $password;

	function __construct($type) {
		$this->accountCreateDate = date('d/m/y', time());
	}
}

//
// PL_TRANSACTION OBJECT DEFINITION
//
class pl_transaction{

	// ATTRIBUTES LISTING
	public $id;
	public $isPossibleFraud;
	public $isDuplicated;
	public $date;
}


//
// PL_RESULT OBJECT DEFINITION
//
class pl_result{

	// ATTRIBUTES LISTING
	public $code;
	public $shortMessage;
	public $longMessage;
}

//
// PL_CAPTURE OBJECT DEFINITION
//
class pl_capture{

	// ATTRIBUTES LISTING
	public $transactionID;
	public $payment;
	public $sequenceNumber;

	function __construct() {
		$this->payment = new pl_payment();
	}
}

//
// PL_REFUND OBJECT DEFINITION
//
class pl_refund extends pl_capture {
	function __construct() {
		parent::__construct();
	}
}

//
// PL_WALLET OBJECT DEFINITION
//
class pl_wallet{

	// ATTRIBUTES LISTING
	public $walletId;
	public $lastName;
	public $firstName;
	public $email;
	public $shippingAddress;
	public $card;
	public $comment;

	function __construct() {
	}
}

//
// PL_RECURRING OBJECT DEFINITION
//
class pl_recurring{

	// ATTRIBUTES LISTING
	public $firstAmount;
	public $amount;
	public $billingCycle;
	public $billingLeft;
	public $billingDay;
	public $startDate;

	function __construct() {
	}
}

//
// PL_AUTHENTIFICATION 3D SECURE
//
class pl_authentication3DSecure{

	// ATTRIBUTES LISTING
	public $md ;
	public $pares ;
	public $xid ;
	public $eci ;
	public $cavv ;
	public $cavvAlgorithm ;
	public $vadsResult ;

	function __construct() {
	}
}

//
// PL_BANKACCOUNTDATA 
//
class pl_bankAccountData{


 	// ATTRIBUTES LISTING
	public $countryCode ;
 	public $bankCode ;
	public $accountNumber ;
	public $key ;


	function __construct() {
	}
}

//
// PL_CHEQUE
//
class pl_cheque{

 	// ATTRIBUTES LISTING
	public $number ;

	function __construct() {
	}
}



//
// PAYLINESDK CLASS
//
class paylineSDK{

	// SOAP URL's
	const URL_SOAP = "http://obj.ws.payline.experian.com";
	public $WSDL_SOAP = "../../wsdl/homologation/WebPaymentAPI.wsdl";
	public $WSDL_DIRECT_SOAP = "../../wsdl/homologation/DirectPaymentAPI.wsdl";
	public $WSDL_EXTENDED_SOAP = "../../wsdl/homologation/ExtendedAPI.wsdl";

	// SOAP ACTIONS CONSTANTS
	const soap_result = 'result';
	const soap_authorization = 'authorization';
	const soap_card = 'card';
	const soap_order = 'order';
	const soap_orderDetail = 'orderDetail';
	const soap_payment = 'payment';
	const soap_transaction = 'transaction';
	const soap_privateData = 'privateData';
	const soap_buyer = 'buyer';
	const soap_address = 'address';
	const soap_capture = 'capture';
	const soap_refund = 'refund';
	const soap_refund_auth = 'refundAuthorization';
	const soap_authentication3DSecure = 'authentication3DSecure';
	const soap_bankAccountData = 'bankAccountData';
	const soap_cheque = 'cheque';

	// ARRAY
	public $header_soap;
	public $items;
	public $privates;

	// OPTIONS
	public $cancelURL = CANCEL_URL;
	public $securityMode = SECURITY_MODE;
	public $notificationURL = NOTIFICATION_URL;
	public $returnURL = RETURN_URL;
	public $customPaymentTemplateURL = CUSTOM_PAYMENT_TEMPLATE_URL;
	public $customPaymentPageCode = CUSTOM_PAYMENT_PAGE_CODE;
	public $languageCode = LANGUAGE_CODE;

	// WALLET
	public $walletIdList;

	// SWITCHING VAR
	public $NMAX_TENTATIVE = PRIMARY_MAX_FAIL_RETRY;
	public $CALL_TIMEOUT = PRIMARY_CALL_TIMEOUT;
	public $RETRY_TIMEOUT = PRIMARY_REPLAY_TIMER;
	public $PRIMARY = true ;
	public $CURRENT_NUMBER_CALL = 0;
	public $DEFAULT_SOCKET_TIMEOUT = 0;
	
	/**
	 * contructor of PAYLINESDK CLASS
	**/
	function __construct() {
	
		$this->header_soap = array();
		$this->header_soap['proxy_host'] = $this->proxy_host = PROXY_HOST;
		$this->header_soap['proxy_port'] = $this->proxy_port = PROXY_PORT;
		$this->header_soap['proxy_login'] = $this->proxy_login = PROXY_LOGIN;
		$this->header_soap['proxy_password'] = $this->proxy_password = PROXY_PASSWORD;
		$this->header_soap['login'] = $this->login = MERCHANT_ID;
		$this->header_soap['password'] = $this->password = ACCESS_KEY;
		$this->header_soap['style'] = SOAP_DOCUMENT;
		$this->header_soap['use'] = SOAP_LITERAL;
		$this->header_soap['version'] = "kit version 1.1";
		$this->header_soap['connection_timeout'] = $this->CALL_TIMEOUT;
		$this->items = array();
		$this->privates = array();
		$this->walletIdList = array();// WALLET
	}

	/**
	 * function payment
	 * @params : $array : array. the array keys are listed in pl_payment CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_payment instance from $array and make SoapVar object for payment.
	**/
	protected function payment($array) {
		$payment = new pl_payment();
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $payment)&&(strlen($v))){
					$payment->$k = $v;
				}
			}
		}
		return new SoapVar($payment, SOAP_ENC_OBJECT, paylineSDK::soap_payment, paylineSDK::URL_SOAP);
	}

	/**
	 * function order
	 * @params : $array : array. the array keys are listed in pl_order CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_order instance from $array and make SoapVar object for order.
	**/
	protected function order($array) {
		$order = new pl_order();
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $order)&&(strlen($v))){
					$order->$k = $v;
				}
			}
		}
		$allDetails = array();
		// insert orderDetails
		$order->details = $this->items;
		return new SoapVar($order, SOAP_ENC_OBJECT, paylineSDK::soap_order, paylineSDK::URL_SOAP);
	}

	/**
	 * function address
	 * @params : $address : array. the array keys are listed in pl_address CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_address instance from $array and make SoapVar object for address.
	**/
	protected function address($array) {
		$address = new pl_address();
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $address)&&(strlen($v)))$address->$k = $v;
			}
		}
		return new SoapVar($address, SOAP_ENC_OBJECT, paylineSDK::soap_address, paylineSDK::URL_SOAP);
	}

	/**
	 * function buyer
	 * @params : $array : array. the array keys are listed in pl_buyer CLASS.
	 * @params : $address : array. the array keys are listed in pl_address CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_buyer instance from $array and $address and make SoapVar object for buyer.
	**/
	protected function buyer($array,$address) {
		$buyer = new pl_buyer();
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $buyer)&&(strlen($v)))$buyer->$k = $v;
			}
		}
		$buyer->shippingAdress = $this->address($address);
		return new SoapVar($buyer, SOAP_ENC_OBJECT, paylineSDK::soap_buyer, paylineSDK::URL_SOAP);
	}

	/**
	 * function contracts
	 * @params : $contracts : array. array of contracts
	 * @return : $contracts : array. the same as params if exist, or an array with default contract defined in
	 * configuration
	 * @description : Add datas to contract array
	**/
	protected function contracts($contracts) {
		if($contracts && is_array($contracts)){
			return $contracts;
		}
		return array(CONTRACT_NUMBER);
	}

	/**
	 * function getHeader
	 * @return : header_soap : array. see class contructor for array keys listing.
	 * @description : Return soap header
	**/
	public function getHeader() {
		return $this->header_soap;
	}

	/**
	 * function authentification 3Dsecure
	 * @params : $array : array. the array keys are listed in pl_card CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_authentication3DSecure instance from $array and make SoapVar object for authentication3DSecure.
	**/
	protected function authentication3DSecure($array) {
		$authentication3DSecure = new pl_authentication3DSecure($array);
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $authentication3DSecure)&&(strlen($v))){
					$authentication3DSecure->$k = $v;
				}
			}
		}
		return new SoapVar($authentication3DSecure, SOAP_ENC_OBJECT, paylineSDK::soap_authentication3DSecure, paylineSDK::URL_SOAP);
	}

	/**
	 * function authorization
	 * @params : $array : array. the array keys are listed in pl_card CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_authentication3DSecure instance from $array and make SoapVar object for authentication3DSecure.
	**/
	protected function authorization($array) {
		$authorization = new pl_authorization($array);
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $authorization)&&(strlen($v))){
					$authorization->$k = $v;
				}
			}
		}
		return new SoapVar($authorization, SOAP_ENC_OBJECT, paylineSDK::soap_authorization, paylineSDK::URL_SOAP);
	}

	/**
	 * function card
	 * @params : $array : array. the array keys are listed in pl_card CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_card instance from $array and make SoapVar object for card.
	**/
	protected function card($array) {
		$card = new pl_card($array['type']);
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $card)&&(strlen($v))){
					$card->$k = $v;
				}
			}
		}
		return new SoapVar($card, SOAP_ENC_OBJECT, paylineSDK::soap_card, paylineSDK::URL_SOAP);
	}

	/**
	 * function setItem
	 * @params : $item : array. the array keys are listed in PL_ORDERDETAIL CLASS.
	 * @description : Make $item SoapVar object and insert in items array
	**/
	public function setItem($item) {
		$orderDetail = new pl_orderDetail();
		if($item && is_array($item)){
			foreach($item as $k=>$v){
				if(array_key_exists($k, $orderDetail)&&(strlen($v)))$orderDetail->$k = $v;
			}
		}
		$this->items[] = new SoapVar($orderDetail, SOAP_ENC_OBJECT, paylineSDK::soap_orderDetail, paylineSDK::URL_SOAP);
	}

	/**
	 * function setPrivate
	 * @params : $private : array.  the array keys are listed in PRIVATE CLASS.
	 * @description : Make $setPrivate SoapVar object  and insert in privates array
	**/
	public function setPrivate($array) {
		$private = new pl_privateData();
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $private)&&(strlen($v)))$private->$k = $v;
			}
		}
		$this->privates[] = new SoapVar($private, SOAP_ENC_OBJECT, paylineSDK::soap_privateData, paylineSDK::URL_SOAP);
	}
	
	
		/**
	 * function bankAccountData 
	 * @params : $array : array. the array keys are listed in pl_bankAccountData CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_bankAccountData instance from $array and make SoapVar object for bankAccountData.
	**/
	protected function bankAccountData($array) {
		$bankAccountData = new pl_bankAccountData($array);
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $bankAccountData)&&(strlen($v))){
					$bankAccountData->$k = $v;
				}
			}
		}
		return new SoapVar(null, SOAP_ENC_OBJECT, paylineSDK::soap_bankAccountData, paylineSDK::URL_SOAP);
	}
	
		/**
	 * function cheque 
	 * @params : $array : array. the array keys are listed in pl_cheque CLASS.
	 * @return : SoapVar : object
	 * @description : build pl_authentication3DSecure instance from $array and make SoapVar object for cheque.
	**/
	protected function cheque($array) {
		$cheque = new pl_cheque($array);
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(array_key_exists($k, $cheque)&&(strlen($v))){
					$cheque->$k = $v;
				}
			}
		}
		return new SoapVar($cheque, SOAP_ENC_OBJECT, paylineSDK::soap_cheque, paylineSDK::URL_SOAP);
	}
	

	/****************************************************/
	//						WEB							//
	/****************************************************/

	/**
	 * function do_webpayment
	 * @params : $array : array. the array keys are :
	 * payment, returnURL, cancelURL, order, notificationURL,customPaymentTemplateURL, contracts,
	 * customPaymentPageCode, languageCode, securityMode, buyer, address, recurring
	 * @params : $debug : boolean . TRUE/FALSE or 0/1
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment request
	**/
	public function do_webpayment($array,$debug=0) {
				try{
			$Method = "doWebPayment";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			if($array && is_array($array)){
				if(isset($array['cancelURL'])&& strlen($array['cancelURL'])) $this->cancelURL = $array['cancelURL'];
				if(isset($array['notificationURL']) && strlen($array['notificationURL'])) $this->notificationURL = $array['notificationURL'];
				if(isset($array['returnURL'])&& strlen($array['returnURL'])) $this->returnURL = $array['returnURL'];
				if(isset($array['customPaymentTemplateURL'])&& strlen($array['customPaymentTemplateURL'])) $this->customPaymentTemplateURL = $array['customPaymentTemplateURL'];
				if(isset($array['customPaymentPageCode'])&& strlen($array['customPaymentPageCode'])) $this->customPaymentPageCode = $array['customPaymentPageCode'];
				if(isset($array['languageCode'])&& strlen($array['languageCode'])) $this->languageCode = $array['languageCode'];
				if(isset($array['securityMode'])&& strlen($array['securityMode'])) $this->securityMode = $array['securityMode'];
				if(!isset($array['payment']))$array['payment'] = null;
				if(!isset($array['contracts'])||!strlen($array['contracts'][0]))$array['contracts'] = explode(";", CONTRACT_NUMBER_LIST);
				if(!isset($array['buyer']))$array['buyer'] = null;
				if(!isset($array['address']))$array['address'] = null;
				if(!isset($array['recurring']))$array['recurring'] = null;
				$WSRequest = array (
					'payment' => $this->payment($array['payment']),
					'returnURL' => $this->returnURL,
					'cancelURL' => $this->cancelURL,
					'order' => $this->order($array['order']),
					'notificationURL' => $this->notificationURL,
					'customPaymentTemplateURL' => $this->customPaymentTemplateURL,
					'selectedContractList' => $this->contracts($array['contracts']),
					'privateDataList' => $this->privates,
					'languageCode' => $this->languageCode,
					'customPaymentPageCode' => $this->customPaymentPageCode,
					'buyer' => $this->buyer($array['buyer'],$array['address']),
					'securityMode' => $this->securityMode);
					
				if(isset($array['payment']['mode'])){
				if(($array['payment']['mode'] == "REC") || ($array['payment']['mode'] == "NX")) {
						$WSRequest['recurring'] = $this->recurring($array['recurring']);
					}
				}
				
				
				if($debug) {
					return paylineUtil::responseToArray($WSRequest);
				} else {
				
					$this->SetCallSocketTimeOut();
					$DateDebut = time();
					$this->VerifyIfAnotherWShasSwitch($Method);
					$client = new SoapClient( $this->WSDL_SOAP, $this->header_soap);
					$WSresponse = $client->doWebPayment($WSRequest);
					$this->CURRENT_NUMBER_CALL++;
					$this->SetDefaultSocketTimeOut();
					$response = paylineUtil::responseToArray($WSresponse);
					$response = $this->AddResponseSwitchingChain($Method,$response);

					if($this->CheckForError($response)){
						throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
					}else{
						if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
							if(!$this->CheckIniValue('EndSwitchTry',0)){
								$jIniFileModifier = new jIniFileModifier(INI_FILE);
								$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
								$jIniFileModifier->save();						
							}
						}
						return $response;
					}
				}
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function get_webPaymentDetails
	 * @params : $token : string
	 * @return : Array. Array from a payline server response object.
	 * @description : Get payment details
	**/
	public function get_webPaymentDetails($token,$array) {
		try{
		$Method = "getWebPaymentDetails";
		$this->TokenSwitch($token);
		$getWebPaymentDetailsRequest = array ('token' => $token,
											  'version' => $array['version']
											  );
		$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
		$getWebPaymentDetailsResponse = $client->getWebPaymentDetails($getWebPaymentDetailsRequest);
		$response = paylineUtil::responseToArray($getWebPaymentDetailsResponse);
		$response = $this->AddResponseSwitchingChain($Method,$response);
		if($this->CheckForTokenError($response)){
			if($this->PRIMARY){
				$this->SwitchToSecondary();
			}else{
				$this->SwitchToPrimary();
			}
			$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
			$getWebPaymentDetailsResponse = $client->getWebPaymentDetails($getWebPaymentDetailsRequest);
			$response = paylineUtil::responseToArray($getWebPaymentDetailsResponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);
			return $response;
		}else{
			return $response;
		}
		}catch ( Exception $e ) {
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}

	}


	/****************************************************/
	//						DIRECT						//
	/****************************************************/

	/**
	 * function do_authorization
	 * @params : $array : array. the array keys are :
	 * payment, card, order, privateDataList, buyer
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment authorization
	**/
	public function do_authorization($array) {
		try{
			$Method = "doAuthorization";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'card' =>  $this->card($array['card']),
				'order' => $this->order($array['order']),
				'buyer' => $this->buyer($array['buyer'],$array['address']),
				'privateDataList' =>  $this->privates,
				'authentication3DSecure' =>$this->authentication3DSecure($array['3DSecure']),
				'bankAccountData' => $this->bankAccountData($array['BankAccountData']),
				'version' => $array['version']
				);	
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doAuthorization($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function do_capture
	 * @params : $array : array. the array keys are: transactionID, payment
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment capture
	**/
	public function do_capture($array) {
	
		try{
			$Method = "doCapture";
if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionID' =>$array['transactionID'],
				'payment' =>  $this->payment($array['payment']),
				'privateDataList' =>  $this->privates,
				'sequenceNumber'=>$array['sequenceNumber']);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doCapture($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function do_refund
	 * @params : $array : array. the array keys are :
	 * transactionID, payment, comment
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment refund
	**/
	public function do_refund($array) {
	
			try{
			$Method = "doRefund";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionID' =>$array['transactionID'],
				'payment' =>$this->payment($array['payment']),
				'comment' =>$array['comment'],
				'privateDataList' =>  $this->privates,
				'sequenceNumber'=>$array['sequenceNumber']);	
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doRefund($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && !$this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function do_credit
	 * @params : $array : array. the array keys are :
	 * transactionID, payment, card, comment
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment credit
	**/
	public function do_credit($array) {
	
	
			try{
			$Method = "doCredit";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'card' =>  $this->card($array['card']),
				'buyer' => $this->buyer($array['buyer'],$array['address']),
				'privateDataList' => $this->privates,
				'order' => $this->order($array['order']),
				'comment' =>$array['comment'],
				'version' => $array['version']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doCredit($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function verify_Enrollment
	 * @params : $array : array. the array keys are :
	 * card, payment, orderRef
	 * @return : Array. Array from a payline server response object.
	 * @description : verify enrollment
	**/
	public function verify_Enrollment($array) {
	
	try{
			$Method = "verifyEnrollment";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'card' =>  $this->card($array['card']),
				'orderRef' => $array['orderRef'],
				'userAgent' => $array['userAgent']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->verifyEnrollment($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function do_debit
	 * @params : $array : array. the array keys are :
	 * contractNumber, pares, md
	 * @return : Array. Array from a payline server response object.
	 * @description : verify an authentication
	**/
	public function do_debit($array) {
	
		try{
			$Method = "doDebit";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'card' =>  $this->card($array['card']),
				'order' => $this->order($array['order']),
				'privateDataList' =>  $this->privates,
				'buyer' => $this->buyer($array['buyer'],$array['address']),
				'authentication3DSecure' =>$this->authentication3DSecure($array['3DSecure']),
				'authorization' =>$this->authorization($array['authorization']),
				'version' => $array['version']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doDebit($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

	/**
	 * function do_reset
	 * @params : $array : array. the array keys are :
	 * transactionID, comment
	 * @return : Array. Array from a payline server response object.
	 * @description : Do a payment refund
	**/
	public function do_reset($array) {
	
			try{
			$Method = "doReset";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionID' =>$array['transactionID'],
				'comment' =>$array['comment']);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doReset($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
	}

/****************************************************/
// 						WALLET						//
/****************************************************/

/**
 * function wallet
 * @params : array : array.  the array keys are listed in pl_wallet CLASS.
 * @params : address : array.  the array keys are listed in pl_address CLASS.
 * @params : card : array.  the array keys are listed in pl_card CLASS.
 * @return : wallet: pl_wallet Object.
 * @description : build a wallet object.
**/
protected function wallet($array,$address,$card) {
	$wallet = new pl_wallet();
	if($array && is_array($array)){
		foreach($array as $k=>$v){
			if(array_key_exists($k, $wallet)&&(strlen($v)))$wallet->$k = $v;
		}
	}

	$wallet->shippingAddress = $this->address($address);
	$wallet->card = $this->card($card);

	return $wallet;
}

/**
 * function create_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, wallet, address, card
 * @return : Array. Array from a payline server response object.
 * @description : create a new wallet.
**/
public function create_Wallet($array){

			try{
			$Method = "createWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'privateDataList' => $this->privates,
				'authentication3DSecure' =>$this->authentication3DSecure($array['3DSecure']),
				'wallet' =>  $this->wallet($array['wallet'],$array['address'],$array['card']),
				'version' => $array['version']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->createWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function get_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, walletId
 * @return : Array. Array from a payline server response object.
 * @description : get an existing wallet from payline server .
**/
public function get_Wallet($array){

			try{
			$Method = "getWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'walletId' =>  $array['walletId'],
				'cardInd' => $array['cardInd'],
				'version' => $array['version']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->getWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}

}

/**
 * function update_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, walletId
 * @return : Array. Array from a payline server response object.
 * @description : update an existing wallet from payline server .
**/
public function update_Wallet($array){

			try{
			$Method = "updateWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'privateDataList' => $this->privates,
				'authentication3DSecure' =>$this->authentication3DSecure($array['3DSecure']),
				'wallet' => $this->wallet($array['wallet'],$array['address'],$array['card']),
				'cardInd' => $array['cardInd'],
				'version' => $array['version']
				);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->updateWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function create_Web_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, selected contact list, updatePersonalDetails, buyer,
 * returnURL, cancelURL, notificationURL, languageCode, customPaymentPageCode, securityMode
 * @return : Array. Array from a payline server response object.
 * @description : create a new web wallet.
**/
public function create_WebWallet($array){

			try{
			$Method = "createWebWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'selectedContractList' => $this->contracts($array['contracts']),
				'updatePersonalDetails' => $array['updatePersonalDetails'],
				'buyer' => $this->buyer($array['buyer'],$array['address']),
				'returnURL' => $this->returnURL,
				'cancelURL' => $this->cancelURL,
				'notificationURL' => $this->notificationURL,
				'languageCode' => $this->languageCode,
				'customPaymentPageCode' => $this->customPaymentPageCode,
				'securityMode' => $this->securityMode);
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
			$WSresponse = $client->createWebWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function get_WebWallet
 * @params : $token : string
 * @return : Array. Array from a payline server response object.
 * @description : get a wallet.
**/
public function get_WebWallet($token,$array){

		try{
		$Method = "getWebWallet";
		$this->TokenSwitch($token);
		$getWebWalletRequest  = array ('token' => $token,
										'version' => $array['version']
										);
		$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
		$getWebWalletResponse = $client->getWebWallet($getWebWalletRequest);
		$response = paylineUtil::responseToArray($getWebWalletResponse);
		$response = $this->AddResponseSwitchingChain($Method,$response);
		if($this->CheckForTokenError($response)){
			if($this->PRIMARY){
				$this->SwitchToSecondary();
			}else{
				$this->SwitchToPrimary();
			}
			$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
			$getWebWalletResponse = $client->getWebWallet($getWebWalletRequest);
			$response = paylineUtil::responseToArray($getWebWalletResponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);
			return $response;
		}else{
			return $response;
		}
		}catch ( Exception $e ) {
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}


/**
 * function update_Web_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, selected contact list, updatePersonalDetails, buyer,
 * returnURL, cancelURL, notificationURL, languageCode, customPaymentPageCode, securityMode
 * @return : Array. Array from a payline server response object.
 * @description : create a new wallet.
**/
public function update_WebWallet($array){


			try{
			$Method = "updateWebWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'walletId' => $array['walletId'],
				'updatePersonalDetails' => $array['updatePersonalDetails'],
				'updatePaymentDetails' => $array['updatePaymentDetails'],
				'languageCode' => $this->languageCode,
				'customPaymentPageCode' => $this->customPaymentPageCode,
				'securityMode' => $this->securityMode,
				'returnURL' => $this->returnURL,
				'cancelURL' => $this->cancelURL,
				'notificationURL' => $this->notificationURL,
				'privateDataList' => $this->privates,
				'customPaymentTemplateURL' => $this->customPaymentTemplateURL,
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_SOAP, $this->header_soap);
			$WSresponse = $client->updateWebWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}


/**
 * function setWalletIdList
 * @params : sting : string if wallet id separated by ';'.
 * @return :
 * @description : make an array of wallet id .
**/
public function setWalletIdList($walletIdList) {
		if ($walletIdList) $this->walletIdList = explode(";", $walletIdList);
		if(empty($walletIdList))$this->walletIdList = array(0) ;
}

/**
 * function disable_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, walletId
 * @return : Array. Array from a payline server response object.
 * @description : disable an existing wallet from payline server .
**/
public function disable_Wallet($array){

			try{
			$Method = "disableWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'walletIdList' =>  $this->walletIdList,
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->disableWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function enable_Wallet
 * @params : array : array. the array keys are :
 * contractNumber, walletId
 * @return : Array. Array from a payline server response object.
 * @description : enable an existing wallet from payline server .
**/
public function enable_Wallet($array){

			try{
			$Method = "enableWallet";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'walletId' =>  $array['walletId'],
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->enableWallet($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function do_immediate_wallet_payment
 * @params : array : array. the array keys are :
 * payment, order, walletId
 * @return : Array. Array from a payline server response object.
 * @description : do an immediate payment from a wallet
**/
public function do_immediate_wallet_payment($array){

			try{
			$Method = "doImmediateWalletPayment";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'order' =>  $this->order($array['order']),
				'walletId' =>  $array['walletId'],
				'privateDataList' => $this->privates,
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doImmediateWalletPayment($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function do_sheduled_wallet_payment
 * @params : array : array. the array keys are :
 * payment, orderRef, orderDate, walletId, scheduledDate
 * @return : Array. Array from a payline server response object.
 * @description : do a scheduled payment from a wallet
**/
public function do_sheduled_wallet_payment($array){

			try{
			$Method = "doScheduledWalletPayment";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'orderRef' => $array['orderRef'],
				'orderDate' => $array['orderDate'],
				'order' =>  $this->order($array['order']),
				'walletId' =>  $array['walletId'],
				'scheduledDate' => $array['scheduled'],
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doScheduledWalletPayment($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}

}

/**
 * function recurring
 * @params : array : array. the array keys are listed in pl_recurring CLASS.
 * @return : recurring object.
 * @description : build a recurring object.
**/
protected function recurring($array) {
	if($array){
	$recurring = new pl_recurring();
	if($array && is_array($array)){
		foreach($array as $k=>$v){
			if(array_key_exists($k, $recurring)&&(strlen($v)))$recurring->$k = $v;
		}
	}
	//return new SoapVar($recurring, SOAP_ENC_OBJECT, 'recurring', paylineSDK::URL_SOAP);
	return $recurring;
	}
	else return null;
}

/**
 * function do_recurrent_wallet_payment
 * @params : array : array. the array keys are :
 * payment, orderRef, orderDate, walletId, recurring
 * @return : Array. Array from a payline server response object.
 * @description : do a recurrent payment from a wallet
**/
public function do_recurrent_wallet_payment($array){

			try{
			$Method = "doRecurrentWalletPayment";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'payment' => $this->payment($array['payment']),
				'orderRef' => $array['orderRef'],
				'orderDate' => $array['orderDate'],
				'order' => $this->order($array['order']),
				'privateDataList' =>  $this->privates,
				'walletId' =>  $array['walletId'],
				'scheduledDate' => $array['scheduled'],
				'recurring' =>  $this->recurring($array['recurring']),
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doRecurrentWalletPayment($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function get_payment_record
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : get a payment record
**/
public function get_payment_record($array){

			try{
			$Method = "getPaymentRecord";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'paymentRecordId' =>  $array['paymentRecordId']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->getPaymentRecord($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function disable_payment_record
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function disable_payment_record($array){

			try{
			$Method = "disablePaymentRecord";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'paymentRecordId' =>  $array['paymentRecordId']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->disablePaymentRecord($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function reAuthorization
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function reAuthorization($array){

			try{
			$Method = "doReAuthorization";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionID' => $array['transactionID'],
				'payment' => $this->payment($array['payment']),
				'order' => $this->order($array['order']),
				'privateDataList' =>  $this->privates
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doReAuthorization($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function doScoringCheque
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function doScoringCheque($array){

			try{
			$Method = "doScoringCheque";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'cheque' => $this->cheque($array['cheque']),
				'payment' => $this->payment($array['payment']),
				'order' => $this->order($array['order']),
				'privateDataList' =>  $this->privates
				);
				
			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->doScoringCheque($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function getEncryptionKey
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function getEncryptionKey($array){

			try{
			$Method = "getEncryptionKey";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array();

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->getEncryptionKey($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function verify_Authentication
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function verify_Authentication($array){

			try{
			$Method = "verify_Authentication";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'pares' =>  $array['pares'],
				'md' =>  $array['md'],
				'card' =>  $this->card($array['card'])
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->verifyAuthentication($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function getCards
 * @params : array : array. the array keys are :
 * contractNumber, paymentRecordId
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function getCards($array){

			try{
			$Method = "getCards";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'contractNumber' => $array['contractNumber'],
				'walletId' =>  $array['walletId'],
				'cardInd' => $array['cardInd']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_DIRECT_SOAP, $this->header_soap);
			$WSresponse = $client->getCards($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_DIRECT_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/****************************************************/
// 				EXTENDED					        //
/****************************************************/

/**
 * function getTransactionDetails
 * @params : array : array. the array keys are :
 * transactionId, orderRef
 * @return : Array. Array from a payline server response object.
 * @description : disable a payment record
**/
public function get_TransactionDetails($array){

			try{
			$Method = "getTransactionDetails";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionId' => $array['transactionId'],
				'orderRef' =>  $array['orderRef'],
				'startDate' => $array['startDate'],
				'endDate' => $array['endDate'],
				'version' => $array['version']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_EXTENDED_SOAP, $this->header_soap);
			$WSresponse = $client->getTransactionDetails($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_EXTENDED_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}

/**
 * function transactionsSearch
 * @params : array : array. the array keys are :
 * transactionId, orderRef, startDate,endDate, authorizationNumber,paymentMean
 * transactionType, name, firstName, email, cardNumber, currency,
 * minAmount, maxAmount, walletId
 * @return : Array. Array from a payline server response object.
 * @description : search transactions
**/
public function transactionsSearch($array){

			try{
			$Method = "transactionsSearch";
			if(isset($array['Switch']['Forced'])){
				$this->init_config($Method,$array['Switch']['Forced'],$array['Switch']['Choice']);
			}else{
				$this->init_config($Method,'','');
			}
			if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$this->NMAX_TENTATIVE = 1;
			}
			set_time_limit(0);
			$WSRequest = array (
				'transactionId' => $array['transactionId'],
				'orderRef' => $array['orderRef'],
				'startDate' =>  $array['startDate'],
				'endDate' =>  $array['endDate'],
				'authorizationNumber' =>  $array['authorizationNumber'],
				'paymentMean' =>  $array['paymentMean'],
				'transactionType' =>  $array['transactionType'],
				'name' =>  $array['name'],
				'firstName' =>  $array['firstName'],
				'email' =>  $array['email'],
				'cardNumber' =>  $array['cardNumber'],
				'currency' =>  $array['currency'],
				'minAmount' =>  $array['minAmount'],
				'maxAmount' =>  $array['maxAmount'],
				'walletId' =>  $array['walletId'],
				'contractNumber' => $array['contractNumber'],
				'returnCode'  => $array['returnCode']
				);

			$this->SetCallSocketTimeOut();
			$DateDebut = time();
			$this->VerifyIfAnotherWShasSwitch($Method);
			$client = new SoapClient($this->WSDL_EXTENDED_SOAP, $this->header_soap);
			$WSresponse = $client->transactionsSearch($WSRequest);
			$this->CURRENT_NUMBER_CALL++;
			$this->SetDefaultSocketTimeOut();
			$response = paylineUtil::responseToArray($WSresponse);
			$response = $this->AddResponseSwitchingChain($Method,$response);

			if($this->CheckForError($response)){
				throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
			}else{
				if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
					if(!$this->CheckIniValue('EndSwitchTry',0)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
						$jIniFileModifier->save();						
					}
				}
				return $response;
			}
		}catch ( Exception $e ) {
			if($this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
				$WS = $Method;
				return $this->Switcher($DateDebut,$Method,$WS,$WSRequest,$this->WSDL_EXTENDED_SOAP);				
			}
			echo '<strong>ERROR : ' . $e->getMessage() . '</strong><br/>';
		}
}
			public function IsSwitchingEnabled($Method){
		$Enabled = false;
		$ListeWS = PAYLINE_WS_SWITCH_ENABLE;
		$ArrayWS = explode(",",$ListeWS);
		foreach($ArrayWS as $Key => $Value){
			if($Method === $Value){
				$Enabled = true;
			}
		}
		return $Enabled;
	}
	
	// Param�trage Switch Primary
	public function SwitchToPrimary(){
		$this->NMAX_TENTATIVE = PRIMARY_MAX_FAIL_RETRY;
		$this->CALL_TIMEOUT = PRIMARY_CALL_TIMEOUT;
		$this->RETRY_TIMEOUT = PRIMARY_REPLAY_TIMER;
		$this->PRIMARY = true;
		$this->CURRENT_NUMBER_CALL = 0;
		$this->header_soap['connection_timeout'] = $this->CALL_TIMEOUT;
		if(PRODUCTION){
			$this->WSDL_SOAP = PRIMARY_PROD_WSDL_SOAP ;
			$this->WSDL_DIRECT_SOAP = PRIMARY_PROD_WSDL_DIRECT_SOAP ;
			$this->WSDL_EXTENDED_SOAP = PRIMARY_PROD_WSDL_EXTENDED_SOAP ;
		}else{
			$this->WSDL_SOAP = PRIMARY_HOMO_WSDL_SOAP;
			$this->WSDL_DIRECT_SOAP = PRIMARY_HOMO_WSDL_DIRECT_SOAP;
			$this->WSDL_EXTENDED_SOAP = PRIMARY_HOMO_WSDL_EXTENDED_SOAP;
		}
	}
	
	// Param�trage Switch Secondary
	public function SwitchToSecondary(){
		$this->NMAX_TENTATIVE = SECONDARY_MAX_FAIL_RETRY;
		$this->CALL_TIMEOUT = SECONDARY_CALL_TIMEOUT;
		$this->RETRY_TIMEOUT = SECONDARY_REPLAY_TIMER;
		$this->PRIMARY = false;
		$this->CURRENT_NUMBER_CALL = 0;
		$this->header_soap['connection_timeout'] = $this->CALL_TIMEOUT;
		if(PRODUCTION){
			$this->WSDL_SOAP = SECONDARY_PROD_WSDL_SOAP;
			$this->WSDL_DIRECT_SOAP = SECONDARY_PROD_WSDL_DIRECT_SOAP;
			$this->WSDL_EXTENDED_SOAP = SECONDARY_PROD_WSDL_EXTENDED_SOAP;
		}else{
			$this->WSDL_SOAP = SECONDARY_HOMO_WSDL_SOAP;
			$this->WSDL_DIRECT_SOAP = SECONDARY_HOMO_WSDL_DIRECT_SOAP;
			$this->WSDL_EXTENDED_SOAP = SECONDARY_HOMO_WSDL_EXTENDED_SOAP;
		}
	}	
	
	public function IsForceSwitch($Force){
		$bool = false;
		if(isset($Force) && !empty($Force)){
			$bool = true;
		}else{
			$bool = false;
		}
		return $bool;
	}

	public function CheckForSwitching(){
		$bool = false ;
		$ini_array = parse_ini_file(INI_FILE);
		$TimeEndSwitch = $ini_array['TimeEndSwitch'];
		$CurrentTime = time();
		if(isset($TimeEndSwitch) && !empty($TimeEndSwitch)){
			if($TimeEndSwitch > $CurrentTime){
				$bool = true;
				return $bool;
			}else{
				$bool = false;
				return $bool;
			}
		}else{
			$bool = false;
			return $bool;
		}
	}
	public function CheckForError($response){
		$ErrCheck = false;
		$ErrList = PAYLINE_ERR_CODE;
		$ArrayErr = explode(",",$ErrList);
		foreach($ArrayErr as $Key => $Value){
			if($response['result']['code'] === $Value){
				$ErrCheck = true;
			}
		}
		return $ErrCheck;
	}

	public function CheckForTokenError($response){
		$ErrCheck = false;
		$ErrList = PAYLINE_ERR_TOKEN;
		$ArrayErr = explode(",",$ErrList);
		foreach($ArrayErr as $Key => $Value){
			if($response['result']['code'] === $Value){
				$ErrCheck = true;
			}
		}
		return $ErrCheck;
	}
	
	public function init_config($Method,$ForceSwitch,$ForceValue){
		if($this->IsSwitchingEnabled($Method)){
			if(isset($ForceSwitch) && $this->IsForceSwitch($ForceSwitch)){
				if(isset($ForceValue) && $ForceValue == "Primaire"){
					$this->SwitchToPrimary();
				}else if(isset($ForceValue) && $ForceValue == "Secondaire"){
					$this->SwitchToSecondary();
				}
			}else{
				if($this->CheckForSwitching()){ 
					$this->SwitchToSecondary();
				}else{
					$this->SwitchToPrimary();
				}
			}
		}else{
			if(isset($ForceSwitch) && $this->IsForceSwitch($ForceSwitch)){
				if(isset($ForceValue) && $ForceValue == "Primaire"){
					$this->SwitchToPrimary();
				}else if(isset($ForceValue) && $ForceValue == "Secondaire"){
					$this->SwitchToSecondary();
				}
			}else{
				$this->SwitchToPrimary();
			}
		}
	}
	
	public function CheckEndSwitch(){
		$bool = false ;
		$ini_array = parse_ini_file(INI_FILE);
		$TimeEndSwitch = $ini_array['TimeEndSwitch'];
		$EndSwitch = $ini_array['EndSwitchTry'];
		$CurrentTime = time();
		if(isset($TimeEndSwitch) && !empty($TimeEndSwitch)){
			if(($CurrentTime > $TimeEndSwitch) && $EndSwitch == 1 && $this->PRIMARY){
				$bool = true;
			}
		}
		return $bool;
	}

		
	public function SetCallSocketTimeOut(){
		$this->DEFAULT_SOCKET_TIMEOUT = ini_get('default_socket_timeout');
		ini_set('default_socket_timeout', $this->CALL_TIMEOUT);
	}
	public function SetDefaultSocketTimeOut(){
		ini_set('default_socket_timeout', $this->DEFAULT_SOCKET_TIMEOUT);
	}
	public function VerifyIfAnotherWShasSwitch($Method){
		if($this->IsSwitchingEnabled($Method) && $this->CheckForSwitching() && $this->PRIMARY){
			$this->SwitchToSecondary();
		}
	}
	public function AddResponseSwitchingChain($Method,$response){
		if($this->IsSwitchingEnabled($Method)){
			$response['Switch']['Wsdl File'] = "$this->WSDL_DIRECT_SOAP";
		}
		return $response;
	}
	
	public function CheckIniValue($key,$value){
		$bool = false ;
		$ini_array = parse_ini_file(INI_FILE);
		$EndSwitch = $ini_array[$key];
		if(isset($EndSwitch) && !empty($EndSwitch) && $EndSwitch == $value){
				$bool = true;
		}
		
		return $bool;
	}
		
	public function Switcher($DateDebut,$Method,$WS,$WSRequest,$WDSL){
		$DateFin = time();
		$this->SetDefaultSocketTimeOut();
		$response = array();
		while($this->NMAX_TENTATIVE >= $this->CURRENT_NUMBER_CALL){
			if($this->PRIMARY){
				if(($this->RETRY_TIMEOUT - ($DateDebut-$DateFin)) >= 0){
					sleep(($this->RETRY_TIMEOUT - ($DateDebut-$DateFin)));
					$DateDebut = 0;
					$DateFin = 0;
				}
			}else{
				sleep($this->RETRY_TIMEOUT);	
			}
			try{
				$this->SetCallSocketTimeOut();
				$this->VerifyIfAnotherWShasSwitch($Method);
				$client = new SoapClient($WDSL, $this->header_soap);
				$DateDebut = time();
				$WSresponse = $this->WSCall("$WS",$WSRequest,$client);
				$this->SetDefaultSocketTimeOut();
				$response = paylineUtil::responseToArray($WSresponse);	
				$response = $this->AddResponseSwitchingChain($Method,$response);	
				if($this->CheckForError($response)){
					throw new Exception('Technical Error : '+$response['result']['code']+' : '+$response['result']['shortMessage']+' : '+$response['result']['longMessage']);
				}else{
					if($this->CheckEndSwitch() && $this->IsSwitchingEnabled($Method) && !(isset($array['Switch']['Forced']) && $this->IsForceSwitch($array['Switch']['Forced']))){
						if(!$this->CheckIniValue('EndSwitchTry',0)){
							$jIniFileModifier = new jIniFileModifier(INI_FILE);
							$jIniFileModifier->setValue('EndSwitchTry', 0, 'Switcher', null);
							$jIniFileModifier->save();
						}
					}
					return $response;
				}
			}catch (Exception $e){
				$DateFin = time();
				$this->CURRENT_NUMBER_CALL++;
				if(!($this->NMAX_TENTATIVE >= $this->CURRENT_NUMBER_CALL) && $this->PRIMARY){
					$this->SwitchToSecondary();
					$this->CURRENT_NUMBER_CALL = 0;
					$jIniFileModifier = new jIniFileModifier(INI_FILE);
					$jIniFileModifier->setValue('TimeEndSwitch', time()+PAYLINE_SWITCH_BACK_TIMER, 'Switcher', null);
					$jIniFileModifier->save();
					if(!$this->CheckIniValue('EndSwitchTry',1)){
						$jIniFileModifier = new jIniFileModifier(INI_FILE);
						$jIniFileModifier->setValue('EndSwitchTry', 1, 'Switcher', null);
						$jIniFileModifier->save();
					}
				}
				
			}
						
		}
		return $response;
	}
	
	public function WSCall($Method,$WSRequest,$client){
		$response = null ;
		switch ($Method) {
			case "doWebPayment":
				$response = $client->doWebPayment($WSRequest);
				break;
			case "doAuthorization":
				$response = $client->doAuthorization($WSRequest);
				break;
			case "doCapture":
				$response = $client->doCapture($WSRequest);
				break;
			case "doRefund":
				$response = $client->doRefund($WSRequest);
				break;
			case "doCredit":
				$response = $client->doCredit($WSRequest);
				break;
			case "verifyEnrollment":
				$response = $client->verifyEnrollment($WSRequest);
				break;
			case "doDebit":
				$response = $client->doDebit($WSRequest);
				break;
			case "doReset":
				$response = $client->doReset($WSRequest);
				break;
			case "createWallet":
				$response = $client->createWallet($WSRequest);
				break;
			case "getWallet":
				$response = $client->getWallet($WSRequest);
				break;
			case "updateWallet":
				$response = $client->updateWallet($WSRequest);
				break;
			case "createWebWallet":
				$response = $client->createWebWallet($WSRequest);
				break;
			case "updateWebWallet":
				$response = $client->updateWebWallet($WSRequest);
				break;
			case "disableWallet":
				$response = $client->disableWallet($WSRequest);
				break;
			case "enableWallet":
				$response = $client->enableWallet($WSRequest);
				break;
			case "doImmediateWalletPayment":
				$response = $client->doImmediateWalletPayment($WSRequest);
				break;
			case "doScheduledWalletPayment":
				$response = $client->doScheduledWalletPayment($WSRequest);
				break;
			case "doRecurrentWalletPayment":
				$response = $client->doRecurrentWalletPayment($WSRequest);
				break;
			case "getPaymentRecord":
				$response = $client->getPaymentRecord($WSRequest);
				break;
			case "disablePaymentRecord":
				$response = $client->disablePaymentRecord($WSRequest);
				break;
			case "getTransactionDetails":
				$response = $client->getTransactionDetails($WSRequest);
				break;
			case "transactionsSearch":
				$response = $client->transactionsSearch($WSRequest);
				break;
			case "verifyAuthentication":
				$response = $client->verifyAuthentication($WSRequest);
				break;
			case "getEncryptionKey":
				$response = $client->getEncryptionKey($WSRequest);
				break;
			case "getCards":
				$response = $client->getCards($WSRequest);
				break;
			case "doScoringCheque":
				$response = $client->doScoringCheque($WSRequest);
				break;
			case "doReAuthorization":
				$response = $client->doReAuthorization($WSRequest);
				break;
		}
		return $response;
	}
	
	public function TokenSwitch($token){
		$Check = substr($token,0,1);
		if($Check == PRIMARY_TOKEN_PREFIX){
			$this->SwitchToPrimary();
		}else if($Check == SECONDARY_TOKEN_PREFIX){
			$this->SwitchToSecondary();
		}
	}

	
}

?>