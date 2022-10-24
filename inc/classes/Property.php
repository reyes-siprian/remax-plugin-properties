<?php

class Property {
    public function __construct()
    {
        $this->_token = get_option('remax_properties_token');

        if(get_option('remax_properties_api_status') == 'yes') {
            $this->_api = 'https://api-stage.remaxrd.com/v1-agent/';
        } else {
            $this->_api = 'https://api.remaxrd.com/v1-agent/';
        }

        if(get_option('remax_properties_agency_properties') == true) {
            $this->_agency_properties = '&my_agency=true';
        } else {
            $this->_agency_properties = '';
        }

        $this->_featured = get_option('remax_properties_featured');
        $this->_page = isset($_GET['pag']) && $_GET['pag'] != '' ? "&page={$_GET['pag']}" : '';
        $this->_province = isset($_GET['province']) && $_GET['province'] != '' ? $_GET['province'] : '';
        $this->_minPrice = isset($_GET['min-price']) && $_GET['min-price'] != '' ? $_GET['min-price'] : '';
        $this->_maxPrice = isset($_GET['max-price']) && $_GET['max-price'] != '' ? $_GET['max-price'] : '';
        $this->_exclusive = isset($_GET['exclusive']) && $_GET['exclusive'] != '' ? $_GET['exclusive'] : '';
        $this->_featuredProperties = isset($_GET['property-id']) && $_GET['property-id'] != '' ? "&featured_properties[]={$_GET['property-id']}" : '';

        if(!isset($_GET['property-status']) || $_GET['property-status'] == 'all') {
            $this->_propertyStatus = "";
        } elseif(isset($_GET['property-status']) && $_GET['property-status'] == 'sell') {
            $this->_propertyStatus = "&is_for_sell=1";
        } elseif(isset($_GET['property-status']) && $_GET['property-status'] == 'rent'){
            $this->_propertyStatus = "&is_for_rent=1";
        }

    }

    /**
     * 
     */
    public function getPropertiesData($type, $code = '') {
        switch ($type) {
            case 'properties':
                $api = $this->_api . $type . "/?pp=10&province_id={$this->_province}&min_price={$this->_minPrice}&max_price={$this->_maxPrice}&is_exclusive={$this->_exclusive}{$this->_propertyStatus}{$this->_featuredProperties}{$this->_page}{$this->_agency_properties}";
                break;
            case 'property':
                $api = $this->_api . "properties/{$code}";
                break;
            case 'profile':
                $api = $this->_api . $type;
                break;
            case 'featured':
                $api = $this->_api . "properties/?";

                foreach($this->_featured as $property_id) {
                    $api .= "featured_properties[]={$property_id}&";
                }
                
                break;
            default:
                return 'invalid option';
                break;
        }

        $curl = curl_init($api);
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer {$this->_token}",
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        $response = json_decode($response);

        return $response ? $response : $error;
    }

    public function getAgentProvices() {
        $api = $this->_api . 'provinces';

        $curl = curl_init($api);
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer {$this->_token}",
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        $response = json_decode($response);

        return $response ? $response : $error;
    }
}