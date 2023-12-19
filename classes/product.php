<?php
class product
{
    private $reference;
    private $etiquette;
    private $descpt;
    private $codeBarres;
    private $img;
    private $prixAchat;
    private $prixFinal;
    private $prixOffre;
    private $qntMin;
    private $qntStock;
    private $catg;
    private $isHide;

    


    public function __construct($reference, $etiquette, $descpt, $codeBarres, $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg, $isHide)
    {
        $this->reference = $reference;
        $this->etiquette = $etiquette;
        $this->descpt = $descpt;
        $this->codeBarres = $codeBarres;
        $this->img = $img;
        $this->prixAchat = $prixAchat;
        $this->prixFinal = $prixFinal;
        $this->prixOffre = $prixOffre;
        $this->qntMin = $qntMin;
        $this->qntStock = $qntStock;
        $this->catg = $catg;
        $this->isHide = $isHide;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getEtiquette()
    {
        return $this->etiquette;
    }

    public function getDescpt()
    {
        return $this->descpt;
    }

    public function getCodeBarres()
    {
        return $this->codeBarres;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    public function getPrixFinal()
    {
        return $this->prixFinal;
    }

    public function getPrixOffre()
    {
        return $this->prixOffre;
    }

    public function getQntMin()
    {
        return $this->qntMin;
    }

    public function getQntStock()
    {
        return $this->qntStock;
    }

    public function getCatg()
    {
        return $this->catg;
    }

    public function getIsHide()
    {
        return $this->isHide;
    }
}
