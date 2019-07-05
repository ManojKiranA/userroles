<?php

namespace App\Services\Web\WhoIs;

use App\Services\Web\Exceptions\NicServerNotFound;
use App\Services\Web\Exceptions\ConnectionFailedOnNicServer;
use App\Services\Web\Classes\BaseParser;

class WhoIsLookUp extends BaseParser
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
     * Array Holding the NameServers
     *
     * @return string
     **/
    protected $nameServers;

    /**
     * Property for Holding the Whois data
     *
     * @return string
     **/
    public $whoIsLookedUpData;

    /**
     * Sets the Url to Processing
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $webSiteUrl
     * @return $this
     * @version      1.0
     **/
    public function lookUpFor($webSiteUrl)
    {

        $this->urlToLookup = $webSiteUrl;

        $this->domainOfUrl = $this->getDomainName($this->urlToLookup);

        $this->isValidDomain = $this->isValidDomain($this->domainOfUrl);

        $this->nameServers = ((new NameServers())->nameServersList());

        $this->whoIsLookedUpData = $this-> lookForWhoIs();        

        return $this;
    }

    /**
     * Returns  Who is detais of the domain
     *
     * @return string|null
     * @throws conditon
     **/
    protected function lookForWhoIs()
    {
        $finalDomainName = $this->domainOfUrl;
        
        $splitTld = explode('.', $finalDomainName);
        $splitLsd = count($splitTld) - 1;
        $nameServerExtension = $splitTld[$splitLsd];

        $nameServers = $this->nameServers;

        if (!isset($nameServers[$nameServerExtension])) {            
            throw new NicServerNotFound( "No matching nic server found!");
        }
        $nicServer = $nameServers[$nameServerExtension];

        $whoIsDetails = '';
        // connecting to whois server:
        if ($connection = fsockopen($nicServer, 43)) {
            fputs($connection, $finalDomainName . "\r\n");
            while (!feof($connection)) {
                $whoIsDetails .= fgets($connection, 128);
            }
            fclose($connection);
        } else {
            throw new ConnectionFailedOnNicServer("Could Not Connect To $nicServer !");
        }
        return $whoIsDetails;
    }
}