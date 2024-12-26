<?php
namespace Config;

class PayPal
{
    public $clientID = 'AXxVYA5ilyzn1Ksi_57crvNAE_DW3jX-kTUhGqA3xJPm2IlY9IDIlEnGu10M_qg4wXVPz_4L2JRA0i9z'; 
    public $clientSecret = 'EGUBwfO-I-ex0vlTQn9ArtUlAXPMjsS0RGYFYTvhUJQz3v-hX7iA8nubz7vuOFg0Ay6RJmpzToi2gCmm';
    public $sandbox = true;

    public function getApiContext()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($this->clientID, $this->clientSecret)
        );

        $apiContext->setConfig([
            'mode' => $this->sandbox ? 'sandbox' : 'live',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log', 
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        ]);

        return $apiContext;
    }
}

