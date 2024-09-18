<?php

class devesta_product_custom_field extends Module
{

    public function __construct()
    {
        $this->name = 'devesta_product_custom_field';
        $this->tab = 'administration';
        $this->author = 'Devesta.ir';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product Custom Field');
        $this->description = $this->l('Admin Product page Add Custom Fields');
        $this->ps_versions_compliancy = array('min' => '1.7.1', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        if (!parent::install() || !$this->_installSql()
            || !$this->registerHook('displayAdminProductsSeoStepBottom')
            || !$this->registerHook('displayUnderProductName')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->_unInstallSql();
    }

    /**
     * Modifications sql du module
     * @return boolean
     */
    protected function _installSql()
    {
        $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "product "
            . "ADD `custom_field` varchar(128) NULL DEFAULT NULL AFTER `product_type`";
        $returnSql = Db::getInstance()->execute($sqlInstall);
        return $returnSql;
    }

    /**
     * Suppression des modification sql du module
     * @return boolean
     */
    protected function _unInstallSql()
    {
        return Db::getInstance()->execute("ALTER TABLE " . _DB_PREFIX_ . "product " . "DROP custom_field");
    }

    public function hookDisplayUnderProductName($params)
    {
        return $this->display(__FILE__, 'views/templates/hook/custom_field_front.tpl');
    }

    public function hookDisplayAdminProductsSeoStepBottom($params)
    {
        $product = new Product($params['id_product']);
        $languages = Language::getLanguages();
        $this->context->smarty->assign(array(
                'custom_field' => $product->custom_field,
                'languages' => $languages,
                'default_language' => $this->context->employee->id_lang,
            )
        );
        return $this->display(__FILE__, 'views/templates/hook/custom_field.tpl');
    }
}