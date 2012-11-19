<?php
/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_TwitterConnect_Helper_Data extends Mage_Core_Helper_Data 
{
    const CONFIG_XML_PATH_SETTINGS_ACTIVE = 'inchoo_twitterconnect/settings/active';
    const CONFIG_XML_PATH_SETTINGS_CONSUMER_KEY = 'inchoo_twitterconnect/settings/consumer_key';
    const CONFIG_XML_PATH_SETTINGS_CONSUMER_SECRET = 'inchoo_twitterconnect/settings/consumer_secret';
    const CONFIG_XML_PATH_SETTINGS_CALLBACK_URL = 'inchoo_twitterconnect/settings/callback_url';
    const CONFIG_XML_PATH_SETTINGS_TWITTER_OAUTH_SITE_URL = 'inchoo_twitterconnect/settings/twitter_oauth_site_url';
    const CONFIG_XML_PATH_SETTINGS_BUTTON_POSITION = 'inchoo_twitterconnect/settings/button_position';
    const CONFIG_XML_PATH_SETTINGS_BUTTON_STYLE = 'inchoo_twitterconnect/settings/button_style';
    const CONFIG_XML_PATH_SETTINGS_CUSTOM_BUTTON_STYLE_IMG = 'inchoo_twitterconnect/settings/custom_button_style_img';
    
    public function isModuleEnabled($moduleName = null)
    {
        if (Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_ACTIVE) == '0') {
            return false;
        }
        
        return parent::isModuleEnabled($moduleName = null);
    }
    
    public function isModuleOutputEnabled($moduleName = null)
    {        
        $consumerKey = $this->getConsumerKey();
        $consumerSecret = $this->getConsumerSecret();
        
        if (empty($consumerKey) OR empty($consumerSecret)) {
            return false;
        }
        
        return parent::isModuleOutputEnabled($moduleName);
    }   
    
    public function getConsumerKey()
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_CONSUMER_KEY);
    }
    
    public function getConsumerSecret()
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_CONSUMER_SECRET);
    }
    
    public function getCallbackUrl()
    {
        return Mage::getUrl(Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_CALLBACK_URL));
    }   
    
    public function getTwitterOauthSiteUrl()
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_TWITTER_OAUTH_SITE_URL);
    }    
        
    
    public function getButtonPosition()
    {
        return (int)Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_BUTTON_POSITION);        
    }
    
    public function getButtonStyle()
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_BUTTON_STYLE);
    }
    
    public function getCustomButtonStyleImg()
    {
        $prefix = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'inchoo/twitterconnect/';
        $sufix = Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_CUSTOM_BUTTON_STYLE_IMG);
        
        if (empty($sufix)) {
            return '';
        }
        
        return $prefix.$sufix;
    }
}
