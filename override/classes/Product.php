<?php
/**
 * Override Class ProductCore
 */
class Product extends ProductCore {

	public $custom_field;

	 
	public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null){
	 
			self::$definition['fields']['custom_field'] = [
	            'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
	            'required' => false, 'size' => 128
	        ];
	        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}



}