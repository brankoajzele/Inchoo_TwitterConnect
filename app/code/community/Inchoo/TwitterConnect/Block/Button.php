<?php
/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_TwitterConnect_Block_Button extends Mage_Core_Block_Template
{
//    protected function _construct()
//    {
//        parent::_construct();
//        $this->setTemplate('inchoo/twitterconnect/button.phtml');
//    }
    
    protected function _toHtml()
    { 
        
        if (!$this->helper('inchoo_twitterconnect')->isModuleOutputEnabled()) {
            return '';
        }
        
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            return '';
        }
        
        $helper = Mage::helper('inchoo_twitterconnect');
        
        $config=array(
            'callbackUrl' => $helper->getCallbackUrl(),
            'siteUrl' => $helper->getTwitterOauthSiteUrl(),
            'consumerKey' => $helper->getConsumerKey(),
            'consumerSecret' => $helper->getConsumerSecret()
        );
        
        $oauth = new Zend_Oauth_Consumer($config);

        try{
            $request_token = $oauth->getRequestToken();
            
            $_SESSION['inchoo_twitterconnect_request_token']=serialize($request_token);
            $exploded_request_token=explode('=',str_replace('&','=',$request_token));
            $oauth_token=$exploded_request_token[1];
            
            $imgSrc = $helper->getCustomButtonStyleImg();
            
            if (!empty($imgSrc)) {
                return '<a href="'.$helper->getTwitterOauthSiteUrl().'/authorize?oauth_token='.$oauth_token.'"><img src="'.$imgSrc.'" alt="Twitter button" /></a>';                
            }

            if ($helper->getButtonStyle() === 'button') {
                return '<a href="'.$helper->getTwitterOauthSiteUrl().'/authorize?oauth_token='.$oauth_token.'"><img src="'.$this->getSkinUrl('images/inchoo/twitterconnect/sign-in-with-twitter-gray.png').'" alt="Twitter button" /></a>';
            }
            
            if ($helper->getButtonStyle() === 'link') {
                return '<a href="'.$helper->getTwitterOauthSiteUrl().'/authorize?oauth_token='.$oauth_token.'"><img src="'.$this->getSkinUrl('images/inchoo/twitterconnect/sign-in-with-twitter-link.png').'" alt="Twitter button" /></a>';
            }
        } catch(Exception $e) {
            Mage::logException($e);
            return '';
        }
        
        return '';
    }
    
    /**
     * Used for All Files /app/code/core/Mage/Page/Block/Template/Links.php -> addLinkBlock()
     * @return int
     */
    public function getPosition()
    {
        return $this->helper('inchoo_twitterconnect')->getButtonPosition();
    }
}