<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');


class UniteCreatorTemplateEngineWork{
	
	protected $twig;
	protected $arrTemplates = array();
	protected $arrParams = null;
	protected $arrItems = array();
	protected $addon = null;
	protected $objParamsProcessor;
	
	
	/**
	 * init twig
	 */
	public function __construct(){
		
		$this->objParamsProcessor = new UniteCreatorParamsProcessor();
		
	}
	
	
	public function a_____CUSTOM_FUNCTIONS____(){}
	
	
	/**
	 * output some item
	 */
	private function outputItem($index, $itemParams, $templateName, $sap, $newLine = true){
		
		$params = array_merge($this->arrParams, $itemParams);
		
		$htmlItem = $this->twig->render($templateName, $params);
		
		if(!empty($sap)){
			if($index != 0)
				echo UniteProviderFunctionsUC::escCombinedHtml($sap);
			echo UniteProviderFunctionsUC::escCombinedHtml($htmlItem);
		}else
			echo UniteProviderFunctionsUC::escCombinedHtml($htmlItem);
		
		if($newLine)
			echo "\n";
	}
	
	
	/**
	 * put items actually
	 */
	private function putItemsWork($templateName, $sap=null, $numItem=null){
		
		if(empty($this->arrItems))
		 	return(false);
		
		if($this->isTemplateExists($templateName) == false)
			return(false);
		
			
		if($numItem !== null){
			$itemParams = UniteFunctionsUC::getVal($this->arrItems, $numItem);
			if(empty($itemParams))
				return(false);
			
			$this->outputItem($numItem, $itemParams, $templateName, $sap, false);
			
			return(false);
		}

		//if sap, then no new line
		$newLine = empty($sap);
		
		foreach($this->arrItems as $index => $itemParams)
			$this->outputItem($index, $itemParams, $templateName, $sap, $newLine);
				
	}
	
	
	/**
	 * put items. input can be saporator or number of item, or null
	 */
	public function putItems($input = null, $templateName = "item"){
		
		$sap = null;
		$numItem = null;
		
		if($input !== null){
			if(is_numeric($input))
				$numItem = $input;
			else
				$sap = $input;
		}
		
		$this->putItemsWork($templateName, $sap, $numItem);
	}
	
	/**
	 * get the items for iteration
	 */
	public function getItems($type = null){
		
		$arrItems = array();
		foreach($this->arrItems as $item){
			$item = $item["item"];
			if($type == "clean"){
				unset($item["item_repeater_class"]);
				unset($item["item_index"]);
				unset($item["item_id"]);
			}
			
			$arrItems[] = $item;
		}
		
		return($arrItems);
	}
	
	/**
	 * put items json for js
	 */
	public function putItemsJson($type = null){
		
		//modify items for output
		$arrItems = $this->getItems($type);
		
		//json encode
		$jsonItems = UniteFunctionsUC::jsonEncodeForClientSide($arrItems);
		
		echo $jsonItems;
	}
	
	/**
	 * put data json for js
	 */
	public function putAttributesJson($type = null){
		
		$arrAttr = $this->arrParams;
		
		if($type == "clean")
			$arrAttr = UniteFunctionsUC::removeArrItemsByKeys($arrAttr, GlobalsProviderUC::$arrAttrConstantKeys);
		
		$jsonAttr = UniteFunctionsUC::jsonEncodeForClientSide($arrAttr);
				
		echo $jsonAttr;
	}
	
	
	/**
	 * put items 2
	 */
	public function putItems2($input = null){
		$this->putItems($input, "item2");
	}
	
	/**
	 * put items 2
	 */
	public function putCssItems(){
		$this->putItems(null, "css_item");
	}
	
	
	/**
	 * put font override
	 */
	public function putFontOverride($name, $selector, $useID = false){
		
		$arrFonts = $this->addon->getArrFonts();
		
		if(empty($arrFonts))
			return(false);
		
		$cssSelector = "";
		if($useID == true)
			$cssSelector .= "#".$this->arrParams["uc_id"];
		
		if(!empty($cssSelector))
			$cssSelector .= " ".$selector;
		
		$fontKey = "uc_font_override_".$name;

		$arrFont = UniteFunctionsUC::getVal($arrFonts, $fontKey);
		
		if(empty($arrFont))
			return(false);
		
		$processor = new UniteCreatorParamsProcessor();
		$processor->init($this->addon);
		
		$css = $processor->processFont(null, $arrFont, true, $cssSelector, $fontKey);
		
		if(empty($css))
			return(false);
		
		echo UniteProviderFunctionsUC::escAddParam($css);
	}
	
	
	/**
	 * put font override
	 */
	public function putPostTags($postID){
		
		echo "no tag list for this platform";
	}
	
	
	/**
	 * put post meta function
	 */
	public function putPostMeta($postID, $key){
		
		echo "no meta for this platform";
	}
	
	/**
	 * print post meta function
	 */
	public function printPostMeta($postID){
		
		echo "no meta for this platform";
	}

	
	/**
	 * get term custom field
	 */
	public function getTermCustomFields($termID){
		
		echo "no term custom fields in this platform";
		
	}

	/**
	 * get term meta
	 */
	public function getTermMeta($termID){
		
		echo "no term meta in this platform";
		
	}
	
	
	/**
	 * get post meta
	 */
	public function getPostMeta($postID, $key){
		
		echo "no meta for this platform";
		exit();
	}

	/**
	 * get term meta
	 */
	public function getUserMeta($userID, $key){
		
		echo "no user meta in this platform";
		
	}
	
	
	/**
	 * put font override
	 */
	public function putAcfField($postID, $fieldname){
		
		echo "no acf available for this platform";
	}
	
	/**
	 * put post date
	 */
	public function putPostDate($postID, $dateFormat){
		
		echo "no custom date for this platform";
	}
	
	
	/**
	 * filter uc date, clear html first, then replace the date
	 */
	public function filterUCDate($dateStamp, $format = "d F Y, H:i"){
		
		$hasTags = false;
		$stamp = $dateStamp;
		
		if(is_numeric($dateStamp) == false){
			$hasTags = true;
			$stamp = strip_tags($dateStamp);
			$stamp = trim($stamp);
		}
		
		$strDate = date_i18n($format, $stamp);
		
		if($hasTags == true)
			$strDate = str_replace($stamp, $strDate, $dateStamp);

		return($strDate);
	}
	
	
	/**
	 * show item
	 */
	public function showItem($arrItem){
		dmp($arrItem);
	}
	
	
	/**
	 * get post get variable
	 */
	public function putPostGetVar($varName, $default=""){
		
		$varName = UniteProviderFunctionsUC::sanitizeVar($varName, UniteFunctionsUC::SANITIZE_KEY);
		
		$value = UniteFunctionsUC::getPostGetVariable($varName, $default , UniteFunctionsUC::SANITIZE_TEXT_FIELD);
		
		if(empty($value))
			$value = $default;
		
		echo UniteProviderFunctionsUC::escCombinedHtml($value);
	}
	
	
	/**
	 * convert date to type
	 */
	public function put_date_utc($strDate){
						
		$stamp = strtotime($strDate);
				
		$strUTC = gmdate('Y/m/d H:i:s', $stamp);

		echo UniteProviderFunctionsUC::escCombinedHtml($strUTC);
	}
	
	
	/**
	 * show data
	 */
	public function showData(){
		
		dmp("Params:");
		dmp($this->arrParams);
		
		dmp("Items:");
		dmp($this->arrItems);
		
	}
	
	
	/**
	 * show debug
	 */
	public function showDebug($type = null){
		
		dmp("Showing Debug");
		
		if(!empty($type))
			dmp("$type mode");
		
		$arrDebug = HelperUC::getDebug();
		
		if(empty($arrDebug)){
			dmp("no debug content found");
			return(false);
		}
		
		foreach($arrDebug as $item){
			
			$name = UniteFunctionsUC::getVal($item, "name");
			
			if($type == "query"){
				
				switch($name){
					case "getpostlist_values":
					case "getpostlist_param":
					case "post_filters":
					case "post_additions":
						continue(2);
					break;
				}
			}
			
			$title = UniteFunctionsUC::getVal($item, "title");
			$content = UniteFunctionsUC::getVal($item, "content");
			
			$titleOutput = $title;
			if(!empty($content))
				$titleOutput = "<b>$title:</b>";
			
			dmp($titleOutput);
			dmp($content);
			
		}
		
	}
	
	/**
	 * get all data
	 */
	public function getData(){
		
		$data = $this->arrParams;
		
		return($data);
	}
	
	
	/**
	 * get post tags
	 * Enter description here ...
	 */
	public function getPostTags($postID){
		
		$errorPrefix = "getPostTags function error: ";
		
		if(empty($postID))
			UniteFunctionsUC::throwError("$errorPrefix - no postID argument found");
		
		$arrTerms = UniteFunctionsWPUC::getPostSingleTerms($postID, "post_tag");
		
		if(empty($arrTerms))
			return(array());
		
		$objParamsProcessor = new UniteCreatorParamsProcessor();
		
		$arrTagsOutput = $objParamsProcessor->modifyArrTermsForOutput($arrTerms);
		
		return($arrTagsOutput);
	}
	
	/**
	 * print some variable
	 */
	public function printVar($var){
		
		dmp($var);
	}
	
	
	/**
	 * do some wp action, function for override
	 */
	public function do_action($tag, $param = null, $param2 = null, $param3=null){
		
		UniteFunctionsUC::throwError("The do_action() function exists only in PRO version of the plugin");
		
	}

	
	/**
	 * get data by filters
	 */
	public function apply_filters($tag, $value = null, $param1 = null, $param2=null){
		
		UniteFunctionsUC::throwError("The apply_filters() function exists only in PRO version of the plugin");
		
	}

	/**
	 * get data by filters
	 */
	public function getByPHPFunction($funName){
		
		UniteFunctionsUC::throwError("The getByPHPFunction() function exists only in PRO version of the plugin. You can run any php function that return data and starting with 'get_' by it.");
	}
	
	
	/**
	 * filter truncate
	 * preserve - preserve word
	 * separator - is the ending
	 */
	public function filterTruncate($value, $length = 100, $preserve = true, $separator = '...'){
		
		$value = UniteFunctionsUC::truncateString($value, $length, $preserve, $separator);
        
        return $value;
	}
	
	/**
	 * run filter wp autop
	 * 
	 */
	public function filterWPAutop($text, $br = true){
		
		return wpautop($text, $br);
	}
	
	/**
	 * get post terms
	 */
	public function getPostTerms($postID, $taxonomy, $addCustomFields = false){
		
		dmp("no terms in this platform");
		
		return(null);
	}
	
	/**
	 * function for override
	 */
	protected function initTwig_addExtraFunctionsPro(){
		//function for override
	}
	
	
	/**
	 * get woo child product
	 */
	public function getWooChildProducts($productID, $getCustomFields = true, $getCategory = true){
		
		$objWooIntegrate = UniteCreatorWooIntegrate::getInstance();
		$isActive = UniteCreatorWooIntegrate::isWooActive();
		
		if($isActive == false)
			return(false);
		
		$arrChildProductIDs = $objWooIntegrate->getChildProducts($productID);
		
		if(empty($arrChildProductIDs))
			return(array());

		$arrAdditions = array();
		if($getCustomFields == true)
			$arrAdditions[GlobalsProviderUC::POST_ADDITION_CUSTOMFIELDS] = true;
		
		if($getCategory == true)
			$arrAdditions[GlobalsProviderUC::POST_ADDITION_CATEGORY] = true;
		
		$objProcessor = new UniteCreatorParamsProcessor();
		
		$arrProducts = array();
		
		foreach($arrChildProductIDs as $productID){
			
			$arrProduct = $objProcessor->getPostData($productID, $arrAdditions);
			
			$arrProducts[] = $arrProduct;
		}
				
		return($arrProducts);
	}
	
	
	/**
	 * get post author
	 */
	public function getPostAuthor($authorID){
				
		$arrUserData = UniteFunctionsWPUC::getUserDataById($authorID);
		
		return($arrUserData);		
	}
	
	/**
	 * get user data by username
	 */
	public function getUserData($username, $getMeta = false, $getAvatar = false){
		
		$arrUserData = UniteFunctionsWPUC::getUserDataById($username, $getMeta, $getAvatar);
		
		return($arrUserData);
	}
	
	
	/**
	 * get post data
	 */
	public function getPostData($postID, $getCustomFields = false, $getCategory = false){
		
		if(empty($postID))
			return(null);
		
		if(!is_numeric($postID))
			return(null);

		$arrAdditions = array();
		if($getCustomFields == true)
			$arrAdditions[GlobalsProviderUC::POST_ADDITION_CUSTOMFIELDS] = true;
		
		if($getCategory == true)
			$arrAdditions[GlobalsProviderUC::POST_ADDITION_CATEGORY] = true;
		
		$objParamsProcessor = new UniteCreatorParamsProcessor();
		$data = $objParamsProcessor->getPostData($postID, $arrAdditions);
				
		return($data);
	}
	
	/**
	 * print some variable for javascript json
	 */
	public function printJsonVar($var){
		
		$encoded = json_encode($var);
		
		echo $encoded;
	}
	
	/**
	 * print json html data
	 */
	public function printJsonHtmlData($var){
		
		$strJson = json_encode($var);
		$strJson = htmlspecialchars($strJson);
				
		echo $strJson;
	}
	
	
	/**
	 * put pagination
	 */
	public function putPagination($args = array()){
		
		$objPagination = new UniteCreatorElementorPagination();
		$objPagination->putPaginationWidgetHtml($args);
	}
	
	/**
	 * put listing loop
	 */
	public function putListingItemTemplate($item, $templateID){
				
		HelperProviderCoreUC_EL::putListingItemTemplate($item, $templateID);
		
	}
	
	/**
	 * put dynamic loop template, similar to put listing template
	 */
	public function putDynamicLoopTemplate($item, $templateID){
		HelperProviderCoreUC_EL::putListingItemTemplate($item, $templateID);
	}
	
	
	/**
	 * put listing template
	 */
	/*
	public function putListingTemplate_posts($paramName, $templateID){
		
		global $wp_query;
		
		$originalPost = $GLOBALS['post'];
		
		//backup the original querified object
		$originalQueriedObject = $wp_query->queried_object;
		$originalQueriedObjectID = $wp_query->queried_object_id;
		
		foreach($this->arrItems as $item){

			$item = UniteFunctionsUC::getVal($item, "item");
			
			$postItem = UniteFunctionsUC::getVal($item, $paramName);
			if(empty($postItem))
				UniteFunctionsUC::throwError("Posts List attribute: $paramName not found. please write the correct post list attribute name.");
			
			$postID = $postItem->ID;
			
			
			//set the post qieried object
			$wp_query->queried_object = $postItem;
			$wp_query->queried_object_id = $postID;
			
			$GLOBALS['post'] = $postItem;
			
			$output = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( 1753 );
			
			echo $output;
		}
				
		//restore the original queried object
		$wp_query->queried_object = $originalQueriedObject;
		$wp_query->queried_object_id = $originalQueriedObjectID;
		$GLOBALS['post'] = $originalPost;
		
	}
	
	*/
	
	/**
	 * number format for woocommerce
	 */
	public function filterPriceNumberFormat($price){
		
		if(empty($price))
			return($price);
		
		$type = getType($price);
					
		$price = number_format($price, "2");
		
		$price = str_replace(".00", "", $price);
		
		return($price);
	}

	/**
	 * number format for woocommerce
	 */
	public function filterWcPrice($price){

		if(function_exists("wc_price") == false)
			return($price);
			
		$newPrice = wc_price($price);
		
		return($newPrice);
	}
	
	
	/**
	 * get listing item data
	 */
	public function getListingItemData($type = null, $defaultObjectID = null){
		
		$data = UniteFunctionsWPUC::getQueriedObject($type, $defaultObjectID);
		
		$data = UniteFunctionsUC::convertStdClassToArray($data);
		
		return($data);
	}
	
	/**
	 * put post image attributes
	 */
	public function putPostImageAttributes($arrPost, $thumbName, $isPutPlaceholder = false, $urlPlaceholder = ""){
		
		if(empty($arrPost))
			UniteFunctionsUC::throwError("No post found :(");
		
		$attributes = "";
		
		if(isset($arrPost[$thumbName]) == false)
			$thumbName = "image";

		//dmp("put dummy placeholder");exit();
			
		if(!empty($arrPost[$thumbName])){
			
			$urlImage = $arrPost[$thumbName];
			$width = UniteFunctionsUC::getVal($arrPost, $thumbName."_width");
			$height = UniteFunctionsUC::getVal($arrPost, $thumbName."_height");
			
			$attributes .= "src=\"{$urlImage}\"";
			if(!empty($width) && !empty($height))
				$attributes .= " width=\"{$width}\" height=\"{$height}\"";
				
			return($attributes);
		}
		
		$isPutPlaceholder = UniteFunctionsUC::strToBool($isPutPlaceholder);
		
		if($isPutPlaceholder == false)
			return("");
		
		//put placeholder
		
		if(!empty($urlPlaceholder)){
			
			dmP("put built in placeholder");
			exit();
		}
			
		dmp("image placeholders");
		dmp($arrPost);
		//exit();
		
	}
	
	/**
	 * output elementor template by id
	 */
	public function putElementorTemplate($templateID){
				
		HelperProviderCoreUC_EL::putElementorTemplate($templateID);
		
	}
	
	/**
	 * output various functionality
	 */
	public function ucfunc($type, $arg1 = null, $arg2= null, $arg3=null){
		
		switch($type){
			case "put_date_range":
				
				$dateRange = HelperUC::$operations->getDateRangeString($arg1, $arg2, $arg3);
				echo $dateRange;
				
			break;
			case "get_general_setting":
				
				$value = HelperProviderCoreUC_EL::getGeneralSetting($arg1);
				
				return($value);
			break;
			case "run_code_once":
				
				$isRunOnce = HelperUC::isRunCodeOnce($arg1);
				return($isRunOnce);
			break;
			case "get_from_sql":
				
				$response = HelperUC::getFromSql($arg1,$arg2,$arg3);
				
				return($response);
			break;
			default:
				$strTypes = "put_date_range, get_general_setting, run_code_once";
				
				$type = UniteFunctionsUC::sanitizeAttr($type);
				
				dmp("ucfunc error: unknown action <b>'$type'</b>, allowed actions are: <b>$strTypes</b>");
			break;
		}
		
	}
	
	
	/**
	 * put test html
	 */
	public function putTestHTML($type = null, $data = null){
		
		$objFilters = new UniteCreatorFiltersProcess();
		//$objFilters->putFiltersTabs();
		
		switch($type){
			case "filter_checkbox":
				
				$objFilters->putCheckboxFiltersTest($data);
				
			break;
			default:
				dmp("putTestHTML - type not found: $type");
			break;
		}
		
	}
	
	
	/**
	 * add extra functions to twig
	 */
	protected function initTwig_addExtraFunctions(){
		
		//add extra functions
		
		$putItemsFunction = new Twig_SimpleFunction('put_items', array($this,"putItems"));
		$putItemsFunction2 = new Twig_SimpleFunction('put_items2', array($this,"putItems2"));
		$putItemsJsonFunction = new Twig_SimpleFunction('put_items_json', array($this,"putItemsJson"));
		$putAttributesJson = new Twig_SimpleFunction('put_attributes_json', array($this,"putAttributesJson"));
		
		$getItems = new Twig_SimpleFunction('get_items', array($this,"getItems"));
		$putGetDataFunction = new Twig_SimpleFunction('get_data', array($this,"getData"));
		
		$putCssItemsFunction = new Twig_SimpleFunction('put_css_items', array($this,"putCssItems"));
		$putFontOverride = new Twig_SimpleFunction('put_font_override', array($this,"putFontOverride"));
		$putPostTagsFunction = new Twig_SimpleFunction('putPostTags', array($this,"putPostTags"));
		$putPostMetaFunction = new Twig_SimpleFunction('putPostMeta', array($this,"putPostMeta"));
		$getPostMetaFunction = new Twig_SimpleFunction('getPostMeta', array($this,"getPostMeta"));
		$getUserMeta = new Twig_SimpleFunction('getUserMeta', array($this,"getUserMeta"));
		
		$printPostMetaFunction = new Twig_SimpleFunction('printPostMeta', array($this,"printPostMeta"));
		
		$putACFFieldFunction = new Twig_SimpleFunction('putAcfField', array($this,"putAcfField"));
		$putShowFunction = new Twig_SimpleFunction('show', array($this,"showItem"));
		$putPostDateFunction = new Twig_SimpleFunction('putPostDate', array($this,"putPostDate"));
		$putPostGetVar = new Twig_SimpleFunction('putPostGetVar', array($this,"putPostGetVar"));
		$convertDate = new Twig_SimpleFunction('put_date_utc', array($this,"put_date_utc"));
		$putShowDataFunction = new Twig_SimpleFunction('showData', array($this,"showData"));
		$putShowDebug = new Twig_SimpleFunction('showDebug', array($this,"showDebug"));
		$getPostTags = new Twig_SimpleFunction('getPostTags', array($this,"getPostTags"));
		$getPostData = new Twig_SimpleFunction('getPostData', array($this,"getPostData"));
		$putPagination = new Twig_SimpleFunction('putPagination', array($this,"putPagination"));
		
		$putListingItemTemplate = new Twig_SimpleFunction('putListingItemTemplate', array($this,"putListingItemTemplate"));
		$putDynamicLoopTemplate = new Twig_SimpleFunction('putDynamicLoopTemplate', array($this,"putDynamicLoopTemplate"));
		
		$putElementorTemplate = new Twig_SimpleFunction('putElementorTemplate', array($this,"putElementorTemplate"));
		
		$putPostImageAttributes = new Twig_SimpleFunction('putPostImageAttributes', array($this,"putPostImageAttributes"));
		
		$printVar = new Twig_SimpleFunction('printVar', array($this,"printVar"));
		$printJsonVar = new Twig_SimpleFunction('printJsonVar', array($this,"printJsonVar"));
		$printJsonHtmlData = new Twig_SimpleFunction('printJsonHtmlData', array($this,"printJsonHtmlData"));
		
		$doAction = new Twig_SimpleFunction('do_action', array($this,"do_action"));
		$applyFilters = new Twig_SimpleFunction('apply_filters', array($this,"apply_filters"));
		$getByPHPFunction = new Twig_SimpleFunction('getByPHPFunction', array($this,"getByPHPFunction"));
		$ucfunc = new Twig_SimpleFunction('ucfunc', array($this,"ucfunc"));
		
		$getPostTerms = new Twig_SimpleFunction('getPostTerms', array($this,"getPostTerms"));
		$getPostAuthor = new Twig_SimpleFunction('getPostAuthor', array($this,"getPostAuthor"));
		$getUserData = new Twig_SimpleFunction('getUserData', array($this,"getUserData"));
		$getWooChildProducts = new Twig_SimpleFunction('getWooChildProducts', array($this,"getWooChildProducts"));
		$getListingItemData = new Twig_SimpleFunction('getListingItemData', array($this,"getListingItemData"));
		
		$printTermCustomFields = new Twig_SimpleFunction('printTermCustomFields', array($this,"printTermCustomFields"));
		$getTermCustomFields = new Twig_SimpleFunction('getTermCustomFields', array($this,"getTermCustomFields"));
		$getTermMeta = new Twig_SimpleFunction('getTermMeta', array($this,"getTermMeta"));
		
		$filterTruncate = new Twig_SimpleFilter("truncate", array($this, "filterTruncate"));
		$filterWPAutop = new Twig_SimpleFilter("wpautop", array($this, "filterWPAutop"));
		$filterUCDate = new Twig_SimpleFilter("ucdate", array($this, "filterUCDate"));
		$filterPriceNumberFormat = new Twig_SimpleFilter("price_number_format", array($this, "filterPriceNumberFormat"));
		$filterWcPrice = new Twig_SimpleFilter("wc_price", array($this, "filterWcPrice"));
		
		$putTestHtml = new Twig_SimpleFunction('putTestHTML', array($this,"putTestHTML"));
		
		
		//add extra functions		
		$this->twig->addFunction($putItemsFunction);
		$this->twig->addFunction($putItemsFunction2);
		$this->twig->addFunction($putCssItemsFunction);
		$this->twig->addFunction($putFontOverride);
		$this->twig->addFunction($putPostTagsFunction);
		
		$this->twig->addFunction($putPostMetaFunction);
		$this->twig->addFunction($getPostMetaFunction);
		$this->twig->addFunction($printPostMetaFunction);
		
		$this->twig->addFunction($getUserMeta);
		$this->twig->addFunction($getListingItemData);
		
		$this->twig->addFunction($getTermMeta);
		
		$this->twig->addFunction($putACFFieldFunction);
		$this->twig->addFunction($putShowFunction);
		$this->twig->addFunction($putPostDateFunction);
		$this->twig->addFunction($putPostGetVar);
		$this->twig->addFunction($convertDate);
		$this->twig->addFunction($putShowDataFunction);		
		$this->twig->addFunction($putShowDebug);
		$this->twig->addFunction($putGetDataFunction);
		
		$this->twig->addFunction($getPostTags);
		$this->twig->addFunction($getPostData);
		$this->twig->addFunction($printVar);
		$this->twig->addFunction($printJsonVar);
		$this->twig->addFunction($printJsonHtmlData);		
		$this->twig->addFunction($putPagination);
		$this->twig->addFunction($putListingItemTemplate);
		$this->twig->addFunction($putDynamicLoopTemplate);
		$this->twig->addFunction($putElementorTemplate);
		
		$this->twig->addFunction($getPostTerms);
		$this->twig->addFunction($getPostAuthor);
		$this->twig->addFunction($getUserData);
		$this->twig->addFunction($getWooChildProducts);
		$this->twig->addFunction($getTermCustomFields);
		$this->twig->addFunction($putItemsJsonFunction);
		$this->twig->addFunction($putAttributesJson);
		
		$this->twig->addFunction($getItems);
		$this->twig->addFunction($putPostImageAttributes);
		
		//test functions
		$this->twig->addFunction($putTestHtml);
		
		
		//add filters
		$this->twig->addFilter($filterTruncate);
		$this->twig->addFilter($filterWPAutop);
		$this->twig->addFilter($filterUCDate);
		$this->twig->addFilter($filterPriceNumberFormat);
		$this->twig->addFilter($filterWcPrice);
		
		
		//pro functions
		$this->twig->addFunction($doAction);
		$this->twig->addFunction($applyFilters);
		$this->twig->addFunction($getByPHPFunction);
		$this->twig->addFunction($ucfunc);
		
		$this->initTwig_addExtraFunctionsPro();
		
	}
	
	
	public function a_____OTHER_FUNCTIONS_____(){}
	
	
	/**
	 * init twig
	 */
	private function initTwig(){
		
		if(empty($this->arrTemplates))
			UniteFunctionsUC::throwError("No templates found");
		
		$loader = new Twig_Loader_Array($this->arrTemplates);
		
		$arrOptions = array();
		$arrOptions["debug"] = true;
		
		$this->twig = new Twig_Environment($loader, $arrOptions);
		$this->twig->addExtension(new Twig_Extension_Debug());
		
		$this->initTwig_addExtraFunctions();
		
	}
	
	
	/**
	 * validate that not inited
	 */
	private function validateNotInited(){
		if(!empty($this->twig))
			UniteFunctionsUC::throwError("Can't add template or params when after rendered");
	}

	
	/**
	 * validate that all is inited
	 */
	private function validateInited(){
				
		if($this->arrParams === null){
			UniteFunctionsUC::throwError("Please set the params");
		}		
		
	}
	
	
	/**
	 * return if some template exists
	 * @param $name
	 */
	private function isTemplateExists($name){
		
		$isExists = array_key_exists($name, $this->arrTemplates);
		
		return($isExists);
	}
	
	
	/**
	 * add template
	 */
	public function addTemplate($name, $html){
		
		$this->validateNotInited();
		
		if(isset($this->arrTemplates[$name]))
			UniteFunctionsUC::throwError("template with name: $name already exists");
		
		$this->arrTemplates[$name] = $html;
	}
	
	
	/**
	 * add params
	 */
	public function setParams($params){
		
		$this->arrParams = $params;
		
	}
	
	
	/**
	 * set items
	 * @param $arrItems
	 */
	public function setArrItems($arrItems){
		
		$this->arrItems = $arrItems;
		
		$numItems = 0;
		if(is_array($arrItems))
			$numItems = count($arrItems);
		
		//add number of items
		$this->arrParams["uc_num_items"] = count($arrItems);
		
	}
	
	
	/**
	 * set fonts array
	 */
	public function setArrFonts($arrFonts){
		$this->arrFonts = $arrFonts;
	}
	
	
	/**
	 * get rendered html
	 * @param $name
	 */
	public function getRenderedHtml($name){
		
		UniteFunctionsUC::validateNotEmpty($name);
		$this->validateInited();
		if(array_key_exists($name, $this->arrTemplates) == false)
			UniteFunctionsUC::throwError("Template with name: $name not exists");
		
		if(empty($this->twig))
			$this->initTwig();
		
		$output = $this->twig->render($name, $this->arrParams);
		
		return($output);
	}
	
	
	/**
	 * set addon
	 */
	public function setAddon($addon){
		
		$this->addon = $addon;
	}
	
}