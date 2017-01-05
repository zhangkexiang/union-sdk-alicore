<?php
require __DIR__ . '/../vendor/autoload.php';

use Union\Sdk\AliCore\Profile\DefaultProfile;
use Union\Sdk\AliCore\DefaultAcsClient;
use Union\Sdk\AliCore\Exception\ClientException;
use Union\Sdk\AliCore\Exception\ServerException;
use Union\Sdk\AliCore\RpcAcsRequest;
use \Union\Sdk\AliCore\CoreEntrance;

class SingleSendSmsRequest extends RpcAcsRequest
{
    function  __construct()
    {
        parent::__construct("Sms", "2016-09-27", "SingleSendSms");
    }

    private  $ownerId;

    private  $resourceOwnerAccount;

    private  $resourceOwnerId;

    private  $signName;

    private  $templateCode;

    private  $recNum;

    private  $paramString;

    public function getOwnerId() {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId) {
        $this->ownerId = $ownerId;
        $this->queryParameters["OwnerId"]=$ownerId;
    }

    public function getResourceOwnerAccount() {
        return $this->resourceOwnerAccount;
    }

    public function setResourceOwnerAccount($resourceOwnerAccount) {
        $this->resourceOwnerAccount = $resourceOwnerAccount;
        $this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
    }

    public function getResourceOwnerId() {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId) {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
    }

    public function getSignName() {
        return $this->signName;
    }

    public function setSignName($signName) {
        $this->signName = $signName;
        $this->queryParameters["SignName"]=$signName;
    }

    public function getTemplateCode() {
        return $this->templateCode;
    }

    public function setTemplateCode($templateCode) {
        $this->templateCode = $templateCode;
        $this->queryParameters["TemplateCode"]=$templateCode;
    }

    public function getRecNum() {
        return $this->recNum;
    }

    public function setRecNum($recNum) {
        $this->recNum = $recNum;
        $this->queryParameters["RecNum"]=$recNum;
    }

    public function getParamString() {
        return $this->paramString;
    }

    public function setParamString($paramString) {
        $this->paramString = $paramString;
        $this->queryParameters["ParamString"]=$paramString;
    }

}

class SmsEntrance
{

    public static function send($RecNum,$paramString)
    {
        CoreEntrance::init();
        $conf = [//验证码短信相关配置
            'regionId'=>'cn-qingdao',
            'accessKeyId'=>'--------',
            'accessSecret'=>'--------',
            'signname'=>'--------',
            'templatecode'=>'--------'
        ];
        $iClientProfile = DefaultProfile::getProfile($conf['regionId'], $conf['accessKeyId'], $conf['accessSecret']);
        $client = new DefaultAcsClient($iClientProfile);
        $request = new SingleSendSmsRequest();
        $request->setSignName($conf['signname']);/*签名名称*/
        $request->setTemplateCode($conf['templatecode']);/*模板code*/
        $request->setRecNum($RecNum);/*目标手机号*/
        $request->setParamString($paramString);/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            return true;
        }
        catch (ClientException  $e) {
            throw new \Exception($e->getErrorCode().' '.$e->getErrorMessage());
        }
        catch (ServerException  $e) {
            throw new \Exception($e->getErrorCode().' '.$e->getErrorMessage());
        }
    }
}

SmsEntrance::send("11111111","{\"ma\":\"111111\"}");
