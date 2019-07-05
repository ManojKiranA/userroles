<?php

namespace App\Services\Web\MxTools;

use App\Services\Web\Classes\BaseParser;

class MxLookUp extends BaseParser
{
    /**
     * URL Which the user is passing
     *
     * @return string
     **/
    protected $urlToLookup;

    /**
     * Domain from the Url
     *
     * @return string
     **/
    protected $domainOfUrl;

    /**
     * Check if the Domain is Valid
     *
     * @return string
     **/
    protected $isValidDomain;

    /**
     * Ip of the Domain
     *
     * @return string
     **/
    protected $ipOfDomain;

    /**
     * Reverse lookup based on the ip
     *
     * @return string
     **/
    public $reverse;

    /**
     * A  of the Current Domain
     *
     * @return array
     **/
    public $a;

    /**
     * AAAA  of the Current Domain
     *
     * @return array
     **/
    public $aaaa;

    /**
     * MX  of the Current Domain
     *
     * @return array
     **/
    public $mx;

    /**
     * SPF  of the Current Domain
     *
     * @return array
     **/
    public $spf;

    /**
     * C  of the Current Domain
     *
     * @return array
     **/
    public $cName;

    /**
     * HINFO  of the Current Domain
     *
     * @return array
     **/
    public $hInfo;

    /**
     * HINFO  of the Current Domain
     *
     * @return array
     **/
    public $ns;

    /**
     * PTR  of the Current Domain
     *
     * @return array
     **/
    public $ptr;

    /**
     * 
     * SOA  of the Current Domain
     *
     * @return array
     **/
    public $soa;

    /**
     * 
     * SRV  of the Current Domain
     *
     * @return array
     **/
    public $srv;

    /**
     * 
     * NAPTR  of the Current Domain
     *
     * @return array
     **/
    public $naptr;

    /**
     * 
     * DNS A6  of the Current Domain
     *
     * @return array
     **/
    public $dnsA6;
    

    /**
     * Sets the Url to Processing
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $webSiteUrl
     * @return $this
     **/
    public function lookUpFor( $webSiteUrl)
    {
        $this->urlToLookup = $webSiteUrl;

        $this->domainOfUrl = $this-> getDomainName( $this->urlToLookup);

        $this->isValidDomain = $this-> isValidDomain( $this->domainOfUrl);

        $this->ipOfDomain = $this-> lookForIpAddress();

        $this->reverse = $this-> reverseIpLookup();

        

        $this->a = $this->asNewCollection($this-> lookForA());

        $this->aaaa = $this->asNewCollection($this->lookForAAAA());

        $this->mx = $this->asNewCollection($this-> lookForMX());

        $this->spf = $this->asNewCollection($this-> lookForSPF());

        $this->cName = $this->asNewCollection($this-> lookForCname());

        $this->hInfo = $this->asNewCollection($this-> lookForHinfo());

        $this->ns = $this->asNewCollection($this-> lookForNs());

        $this->ptr = $this->asNewCollection($this-> lookForPtr());

        $this->soa = $this->asNewCollection($this-> lookForSoa());

        $this->srv = $this->asNewCollection($this-> lookForSrv());

        $this->naptr = $this->asNewCollection($this-> lookForNaptr());

        $this->dnsA6 = $this->asNewCollection($this-> lookForSPFA6());

        return $this;
    }

    /**
     * Gets the A  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForA()
    {
        return  dns_get_record($this->domainOfUrl, DNS_A);
    }

    /**
     * Gets the AAA  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForAAAA()
    {
        return  dns_get_record($this->domainOfUrl, DNS_AAAA);
    }

    /**
     * Gets the MX  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForMX()
    {
        return  dns_get_record($this->domainOfUrl, DNS_MX);
    }
    

    /**
     * Gets the DNS  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForSPF()
    {
        return  dns_get_record($this->domainOfUrl, DNS_TXT);
    }

    /**
     * Gets the CNAME  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForCname()
    {
        return  dns_get_record($this->domainOfUrl, DNS_CNAME);
    }

    /**
     * Gets the HINFO  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForHinfo()
    {
        return  dns_get_record($this->domainOfUrl, DNS_HINFO);
    }

    /**
     * Gets the NS  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForNs()
    {
        return  dns_get_record($this->domainOfUrl, DNS_NS);
    }

    /**
     * Gets the PTR  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForPtr()
    {
        return  dns_get_record($this->domainOfUrl, DNS_PTR);
    }

    /**
     * Gets the SOA  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForSoa()
    {
        return  dns_get_record($this->domainOfUrl, DNS_SOA);
    }

    /**
     * Gets the SRV  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForSrv()
    {
        return  dns_get_record($this->domainOfUrl, DNS_SRV);
    }

    /**
     * Gets the NAPTR  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForNaptr()
    {
        return  dns_get_record($this->domainOfUrl, DNS_NAPTR);
    }

    /**
     * Gets the DNSA6  if the Domain
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array|null
     **/
    protected function lookForSPFA6()
    {
        return  dns_get_record($this->domainOfUrl, DNS_A6);
    }
    /**
     * Gets the IP Address of the Domain
     * 
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function lookForIpAddress()
    {
        return gethostbyname($this->domainOfUrl);
    }
    /**
     * Reverse Lookup for the Domain basesed on the IP
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return string
     **/
    public function reverseIpLookup()
    {
        if ((bool) ip2long( $this->ipOfDomain)) {
            return gethostbyaddr($this->ipOfDomain);
        }
    }
}