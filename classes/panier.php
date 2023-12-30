<?php

class panier {
    private $client_username;
    private $product_ref;
    private $qnt;

    public function __construct($client_username, $product_ref, $qnt = 1) {
        $this->client_username = $client_username;
        $this->product_ref = $product_ref;
        $this->qnt = $qnt;
    }
 
    public function getClient_username()
    {
        return $this->client_username;
    } 
    public function getProduct_ref()
    {
        return $this->product_ref;
    } 
    public function getQnt()
    {
        return $this->qnt;
    }
}


?>