<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * File: Smtp2GO.php
 * Project: libraries
 * Created Date: Mo Dec 2021
 * Author: Ayatulloh Ahad R
 * Email: ayatulloh@indiega.net
 * Phone: 085791555506
 * -----
 * Last Modified: Tue Dec 14 2021
 * Modified By: Ayatulloh Ahad R
 * -----
 * Copyright (c) 2021 Indiega Network
 * -----
 * HISTORY:
 * Date      	By	Comments
 * ----------	---	---------------------------------------------------------
 * 
 * SMTP2GO PHP Library untuk Codeigniter 3
 * developtment by Indiega Network
 * ----------	---	---------------------------------------------------------
 * 
 * Fitur:
 * Emails:
 * - mengirim email tanpa template (progress)
 * - Mengirim Email dengan Template yg sudah di desain di dashboard SMTP2GO (OK)
 * - melihat ringkasan (summary) dari aktivitas email (OK)
 * 
 * Sender Domains:
 * Manage sender domains for your account to allow emails to be properly authenticated and improve delivery rates.
 * Only add domains that you own, as you will be required to update your DNS records.
 * Note: it can take up to 24-48 hours for some providers to make DNS changes live.
 * Subtopics : POST /domain/add, POST /domain/remove, POST /domain/returnpath, POST /domain/tracking, POST /domain/verify, POST /domain/view
 */


class Smtp2GO
{

    private $ci;

    /**
     * API code
     *
     * API code is required for All SMTP2GO activity
     * 
     * @var string
     */
    private $api_code;

    /**
     * URL to the SMTP2GO API
     * 
     * Usually it's https://api.smtp2go.com/v3/
     *
     * @var string
     */
    private $base_url       = 'https://api.smtp2go.com/v3/';

    private $to             = [];
    private $sender;
    private $templateID;
    private $templateData   = [];

    public function __construct($api_code = null)
    {
        $this->ci   = &get_instance();
        /**
         * get API Code from Config
         */
        $this->ci->config->load('smtp2go', true);
        $configApiCode     = $this->ci->config->item('smtp2go_api_code', 'smtp2go');

        //set Api Code From Config
        $this->setApi_code($configApiCode);
    }


    /**
     * sendWithTemplate
     * mengirim email dengan template yang sudah di desain di dashboard SMTP2GO
     *
     * @return mixed
     */
    public function sendWithTemplate()
    {
        // Execute
        $parameters     = [
            'api_key'       => $this->getApi_code(),
            'to'            => $this->getTo(),
            'sender'        => $this->getSender(),
            'template_id'       => $this->getTemplateID(),
            'template_data'     => $this->getTemplateData(),

        ];

        $parameters['custom_headers'] = [
            [
                'header'    => 'Reply-To',
                'value'    => 'Support One Rich Vision <onerichvision@gmail.com>'
            ]
        ];

        return $this->_exec('/email/send', $parameters);
    }

    /**
     * emailSummary
     * menampilkan data ringkasan dari aktivitas email dari SMTP2GO
     *
     * @return mixed
     */
    public function emailSummary()
    {
        $parameters     = [
            'api_key'       => $this->getApi_code()
        ];
        return $this->_exec('/stats/email_summary', $parameters);
    }

    /**
     * Get you can get one here: 
     *
     * @return  string
     */
    private function getApi_code()
    {
        return $this->api_code;
    }

    /**
     * Set you can get one here: 
     *
     * @param  string  $api_code  You can get one here: 
     *
     * @return  self
     */
    private function setApi_code(string $api_code)
    {
        $this->api_code = $api_code;
        return $this;
    }

    /**
     * Get the value of from
     */
    private function getTo()
    {
        return $this->to;
    }

    /**
     * Set the value of from
     *
     * @return  self
     */
    public function setTo($email = null, $fullname = null)
    {
        $destination    = [];
        $destination[]    = $fullname . ' ' . "<$email>";

        $this->to = $destination;
        return $this;
    }

    /**
     * Get the value of sender
     */
    private function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the value of sender
     *
     * @return  self
     */
    public function setSender($senderEmail = null, $senderName = null)
    {
        $str    = $senderName . ' ' . "<$senderEmail>";
        $this->sender = $str;
        return $this;
    }

    /**
     * Get the value of templateID
     */
    private function getTemplateID()
    {
        return $this->templateID;
    }

    /**
     * Set the value of templateID
     *
     * @return  self
     */
    public function setTemplateID($templateID)
    {
        $this->templateID = $templateID;
        return $this;
    }

    /**
     * Get the value of templateData
     */
    private function getTemplateData()
    {
        return $this->templateData;
    }

    /**
     * Set the value of templateData
     *
     * @return  self
     */
    public function setTemplateData($templateData = [])
    {
        $this->templateData = $templateData;
        return $this;
    }

    /**
     * Execute an API request
     *
     * @param string $endpoint	 API's endpoint (the part after the base_url)
     * @param array  $parameters Array of GET parameters 'parameter'=>'value'
     * 
     * @return array API's decoded response
     */
    private function _exec($endpoint, $parameters = NULL)
    {

        // Start building URL
        $url = $this->base_url;

        // Add endpint
        $url .= trim($endpoint, '/');

        // setup curl POST FIELD
        $post_field     = json_encode($parameters);

        // Get CURL resource
        $curl = curl_init();

        // Set options
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_field);

        // set header
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Send the request & save response
        $response = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // log_message('debug', 'Blockchain: URL executed ' . $url);

        // Return the decoded response as an associative array
        return json_decode($response, TRUE);
    }
}
