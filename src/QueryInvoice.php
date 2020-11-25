<?php
namespace TsaiYiHua\ECPay;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class QueryInvoice
{
    use ECPayTrait;

    protected $apiUrl;
    protected $postData;
    protected $merchantId;
    protected $hashKey;
    protected $hashIv;
    protected $encryptType='md5';

    protected $client;

    public function __construct($merchantId, $hashKey, $hashIv)
    {
        if (config('app.env') == 'production') {
            $this->apiUrl = 'https://einvoice.ecpay.com.tw/Query/Issue';
        } else {
            $this->apiUrl = 'https://einvoice-stage.ecpay.com.tw/Query/Issue';
        }
        $this->postData = new Collection();

        $this->merchantId = $merchantId;
        $this->hashKey = $hashKey;
        $this->hashIv = $hashIv;
    }

    public function getData($orderId)
    {
        $this->postData->put('TimeStamp', Carbon::now()->timestamp);
        $this->postData->put('MerchantID', $this->merchantId);
        $this->postData->put('RelateNumber', $orderId);
        return $this;
    }
}