<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Payment PPEC
 * @category	Payment
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_Ppectest extends Payment
{

    protected $_config;
    private $_ec_config;

    public function __construct($config)
    {

        $this->_config = $config;
        $this->_ec_config = array(
//			'VERSION' => Site::instance()->get('pp_api_version'),
            'VERSION' => '65.1', //Show items detail
            'USER' => 'makecollections-facilitator_api1.choies.com',
            'PWD' => 'VCNDTUH48L8JNUZJ',
            'SIGNATURE' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AozgzEROvQSYZhTzU5eeozJpKRFk',
            'SUBMITURL' => 'https://api-3t.sandbox.paypal.com/nvp',
            'JUMPURL' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
            'RETURNURL' => 'http://' . Site::instance()->get('domain') . '/payment/ppec_response_test',
            'CANCELURL' => Site::instance()->get('pp_cancel_return_url'),
            'NOTIFYURL' => 'http://' . Site::instance()->get('domain') . '/payment/ppec_notify_test',
            'HDRIMG' => Site::instance()->get('pp_logo_url'),
        );
    }

    /**
     *  SetExpressCheckout
     */
    public function set($shipping, $currency, $products)
    {
        /* The servername and serverport tells PayPal where the buyer
          should be directed back to after authorizing payment.
          In this case, its the local webserver that is running this script
          Using the servername and serverport, the return URL is the first
          portion of the URL that buyers will return to after authorizing payment
         */
        $serverName = $_SERVER['SERVER_NAME'];
        $serverPort = $_SERVER['SERVER_PORT'];
        $url = dirname('http://' . $serverName . ':' . $serverPort . $_SERVER['REQUEST_URI']);


        // $currencyCodeType = $_REQUEST['currencyCodeType'];
        // $paymentType = $_REQUEST['paymentType'];

        $key = 0;
        $itemamt = 0;
        
        $currency = Site::instance()->currencies($currency);
        $nvpstr = '';
        foreach ($products as $product)
        {
            $nvpstr .= '&L_NAME' . $key . '=' . Product::instance($product['id'])->get('name');
            $nvpstr .= '&L_NUMBER' . $key . '=' . Product::instance($product['id'])->get('sku');
            $nvpstr .= '&L_AMT' . $key . '=' . Site::instance()->price($product['price'], NULL, NULL, $currency);
            $nvpstr .= '&L_QTY' . $key . '=' . $product['quantity'];
            $attributes = '';
            foreach ($product['attributes'] as $attr => $val)
            {
                $attributes .= $attr . ':' . $val . ';';
            }
            $nvpstr .= '&L_DESC' . $key . '=' . $attributes;
            $key++;
            $itemamt += Site::instance()->price($product['price'], NULL, NULL, $currency) * $product['quantity'];
        }

        $shipping = Site::instance()->price($shipping, NULL, NULL, $currency);
        $amt = $itemamt + $shipping;
        $maxamt = $amt + 25.00;

        $nvpstr .= '&MAXAMT=' . $maxamt . '&AMT=' . $amt . '&ITEMAMT=' . $itemamt . '&SHIPPINGAMT=' . $shipping . '&LOCALECODE=US&Landingpage=Login';

        $nvpstr .= "&METHOD=SetExpressCheckout&ReturnUrl=http://" . Site::instance()->get('domain') . '/payment/ppec_confirm' . "&CANCELURL=" . $this->_ec_config['CANCELURL'] . "&CURRENCYCODE=" . $currency['name'] . "&PAYMENTACTION=sale";
        $resArray = $this->hash_call("SetExpressCheckout", $nvpstr);
        return $resArray;
    }

    public function set1($orders, $others = array())
    {
        /* The servername and serverport tells PayPal where the buyer
          should be directed back to after authorizing payment.
          In this case, its the local webserver that is running this script
          Using the servername and serverport, the return URL is the first
          portion of the URL that buyers will return to after authorizing payment
         */
        $serverName = $_SERVER['SERVER_NAME'];
        $serverPort = $_SERVER['SERVER_PORT'];
        $url = dirname('http://' . $serverName . ':' . $serverPort . $_SERVER['REQUEST_URI']);

        $currencyCodeType = $orders['currency'];

        $personName = $orders['shipping_firstname'] . ' ' . $orders['shipping_lastname'];
        $SHIPTOSTREET = $orders['shipping_address'];
        $SHIPTOCITY = $orders['shipping_city'];
        $SHIPTOSTATE = $orders['shipping_state'];
        $SHIPTOCOUNTRYCODE = $orders['shipping_country'];
        $SHIPTOZIP = $orders['shipping_zip'];


        /*
         * Setting up the Shipping address details
         */
        $shiptoAddress = "&SHIPTONAME=$personName&SHIPTOSTREET=$SHIPTOSTREET&SHIPTOCITY=$SHIPTOCITY&SHIPTOSTATE=$SHIPTOSTATE&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE&SHIPTOZIP=$SHIPTOZIP";

        $key = 0;
        $itemamt = 0;
        
        $nvpstr = '&INVNUM=' . $orders['ordernum'];
        $currency = $orders['currency'];
        $currency = Site::instance()->currencies($currency);
        if(trim($orders['products']))
        {
            $products = unserialize($orders['products']);
            foreach ($products as $product)
            {
                $nvpstr .= '&L_NAME' . $key . '=' . Product::instance($product['id'])->get('name');
                $nvpstr .= '&L_NUMBER' . $key . '=' . Product::instance($product['id'])->get('sku');
                $nvpstr .= '&L_AMT' . $key . '=' . Site::instance()->price($product['price'], NULL, NULL, $currency);
                $nvpstr .= '&L_QTY' . $key . '=' . $product['quantity'];
                $attributes = '';
                foreach ($product['attributes'] as $attr => $val)
                {
                    $attributes .= $attr . ':' . $val . ';';
                }
                $nvpstr .= '&L_DESC' . $key . '=' . $attributes;
                $key++;
                $itemamt += Site::instance()->price($product['price'], NULL, NULL, $currency) * $product['quantity'];
            }
        }
        else
        {
            $products = Order::instance($orders['id'])->products();
            foreach ($products as $product)
            {
                $nvpstr .= '&L_NAME' . $key . '=' . Product::instance($product['product_id'])->get('name');
                $nvpstr .= '&L_NUMBER' . $key . '=' . Product::instance($product['product_id'])->get('sku');
                $nvpstr .= '&L_AMT' . $key . '=' . Site::instance()->price($product['price'], NULL, NULL, $currency);
                $nvpstr .= '&L_QTY' . $key . '=' . $product['quantity'];
                $nvpstr .= '&L_DESC' . $key . '=' . $product['attributes'];
                $key++;
                $itemamt += Site::instance()->price($product['price'], NULL, NULL, $currency) * $product['quantity'];
            }
        }

        $shipping = round($orders['amount_shipping'], 2);
        $amt = round($orders['amount'], 2);
        $discount = $amt - $itemamt - $shipping;
        $discount = round($discount, 2);
        $maxamt = $amt + 25.00;

        $nvpstr .= '&MAXAMT=' . $maxamt . '&AMT=' . $amt . '&ITEMAMT=' . $itemamt . '&SHIPPINGAMT=' . $shipping . '&SHIPDISCAMT=' . $discount . '&LOCALECODE=US&Landingpage=Login';

        $nvpstr .= "&METHOD=SetExpressCheckout&ReturnUrl=" . $this->_ec_config['RETURNURL'] . "&CANCELURL=" . $this->_ec_config['CANCELURL'] . "&CURRENCYCODE=" . $currency['name'] . "&PAYMENTACTION=sale";

        if(isset($others['message']))
        {
            $nvpstr .= "&NOTETOBUYER=" . $others['message'];
        }
        //set shipping address
        $nvpstr .= $shiptoAddress;
        // kohana_log::instance()->add('PPECSET1', $nvpstr);
        // echo $nvpstr;exit;

        /* Make the call to PayPal to set the Express Checkout token
          If the API call succeded, then redirect the buyer to PayPal
          to begin to authorize payment.  If an error occured, show the
          resulting errors
         */
//      $nvpstr = '&L_NAME1=Path To Nirvana&L_AMT0=9.00&L_AMT1=39.00&L_QTY0=2&L_QTY1=2&MAXAMT=129&AMT=104&ITEMAMT=96&CALLBACKTIMEOUT=4&L_SHIPPINGOPTIONAMOUNT1=8.00&L_SHIPPINGOPTIONlABEL1=UPS Next Day Air&L_SHIPPINGOPTIONNAME1=UPS Air&L_SHIPPINGOPTIONISDEFAULT1=true&L_SHIPPINGOPTIONAMOUNT0=3.00&L_SHIPPINGOPTIONLABEL0=UPS Ground 7 Days&L_SHIPPINGOPTIONNAME0=Ground&L_SHIPPINGOPTIONISDEFAULT0=false&INSURANCEAMT=1.00&INSURANCEOPTIONOFFERED=true&CALLBACK=https://www.ppcallback.com/callback.pl&SHIPPINGAMT=8.00&SHIPDISCAMT=-3.00&TAXAMT=2.00&L_NUMBER0=1000&L_DESC0=Size: 8.8-oz&L_NUMBER1=10001&L_DESC1=Size: Two 24-piece boxes&L_ITEMWEIGHTVALUE1=0.5&L_ITEMWEIGHTUNIT1=lbs&ReturnUrl=http%3A%2F%2Flocalhost%3A80%2Fphp_nvp_samples%2FReviewOrder.php%3FcurrencyCodeType%3DUSD%26paymentType%3DSale&CANCELURL=http%3A%2F%2Flocalhost%3A80%2Fphp_nvp_samples%2FSetExpressCheckout.php%3FpaymentType%3DSale&CURRENCYCODE=USD&PAYMENTACTION=Sale';
        $resArray = $this->hash_call("SetExpressCheckout", $nvpstr);
        return $resArray;
    }

    /**
     * GetExpressCheckoutDetails
     */
    public function get($token)
    {
        $nvpstr = "&METHOD=GetExpressCheckoutDetails" .
                "&VERSION=" . $this->_ec_config['VERSION'] .
                "&USER=" . $this->_ec_config['USER'] .
                "&SIGNATURE=" . $this->_ec_config['SIGNATURE'] .
                "&PWD=" . $this->_ec_config['PWD'] .
                "&TOKEN=" . $token;
        parse_str(Toolkit::curl_pay($this->_ec_config['SUBMITURL'], $nvpstr), $result);
        return $result;
    }

    /**
     * DoExpressCheckoutPayment
     */
    public function go($order, $payerid, $token, $type = 0)
    {
        $notifyurl = $this->_ec_config['NOTIFYURL'];
        $nvpstr = "&METHOD=DoExpressCheckoutPayment" .
                "&VERSION=" . $this->_ec_config['VERSION'] .
                "&USER=" . $this->_ec_config['USER'] .
                "&SIGNATURE=" . $this->_ec_config['SIGNATURE'] .
                "&PWD=" . $this->_ec_config['PWD'] .
                "&PAYMENTACTION=sale" .
                "&PAYERID=" . $payerid .
                "&AMT=" . round($order['amount'], 2) .
                "&CURRENCYCODE=" . $order['currency'] .
                "&INVNUM=" . $order['ordernum'] .
                "&NOTIFYURL=" . $notifyurl .
                "&TOKEN=" . $token;

        parse_str(Toolkit::curl_pay($this->_ec_config['SUBMITURL'], $nvpstr), $result);
        return $result;
    }

    /**
     * Paypal payment
     * @param array $order	Order detail
     * @param array $data		Paypal return
     * @return stirng		SUCCESS
     */
    public function pay($order, $data = NULL)
    {
        //avoid duplication
        if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
        {
            return 'SUCCESS';
        }

        $payment_log_status = "";

        $data['address_street'] = str_replace("\n", ' ', $data['address_street']);
        $payment_method = $order['payment_method'] == 'PP' ? 'PP' : 'PPEC';
        $order_update = array(
            'payment_method' => $payment_method,
            'amount_payment' => $order['amount'],
            'currency_payment' => $order['currency'],
            'transaction_id' => $data['txn_id'],
            'payment_date' => time(),
            'updated' => time(),
            // 'shipping_firstname' => $data['first_name'],
            // 'shipping_lastname' => $data['last_name'],
            // 'shipping_address' => $data['address_street'],
            // 'shipping_zip' => $data['address_zip'],
            // 'shipping_city' => $data['address_city'],
            // 'shipping_state' => $data['address_state'],
            // 'shipping_country' => $data['address_country_code'],
            // 'shipping_phone' => $data['contact_phone'],
            'billing_firstname' => $data['first_name'],
            'billing_lastname' => $data['last_name'],
            'billing_address' => $data['address_street'],
            'billing_zip' => $data['address_zip'],
            'billing_city' => $data['address_city'],
            'billing_state' => $data['address_state'],
            'billing_country' => $data['address_country'],
            'billing_phone' => $data['contact_phone'],
        );

        switch ($data['payment_status'])
        {
            case 'Completed':
                //payment platform sync
                $post_var = "order_num=" . $order['ordernum']
                        . "&order_amount=" . $order['amount']
                        . "&order_currency=" . $order['currency']
                        . "&card_num=" . $order['cc_num']
                        . "&card_type=" . $order['cc_type']
                        . "&card_cvv=" . $order['cc_cvv']
                        . "&card_exp_month=" . $order['cc_exp_month']
                        . "&card_exp_year=" . $order['cc_exp_year']
                        . "&card_inssue=" . $order['cc_issue']
                        . "&card_valid_month=" . $order['cc_valid_month']
                        . "&card_valid_year=" . $order['cc_valid_year']
                        . "&billing_firstname=" . $data['first_name']
                        . "&billing_lastname=" . $data['last_name']
                        . "&billing_address=" . $data['address_street']
                        . "&billing_zip=" . $data['address_zip']
                        . "&billing_city=" . $data['address_city']
                        . "&billing_state=" . $data['address_state']
                        . "&billing_country=" . $data['address_country']
                        . "&billing_telephone=" . ''
                        . "&billing_ip_address=" . long2ip($order['ip'])
                        . "&billing_email=" . $order['email']
                        . "&shipping_firstname=" . $data['first_name']
                        . "&shipping_lastname=" . $data['last_name']
                        . "&shipping_address=" . $data['address_street']
                        . "&shipping_zip=" . $data['address_zip']
                        . "&shipping_city=" . $data['address_city']
                        . "&shipping_state=" . $data['address_state']
                        . "&shipping_country=" . $data['address_country']
                        . "&shipping_telephone=" . ''
                        . '&trans_id=' . $data['txn_id']
                        . '&payer_email=' . $data['payer_email']
                        . '&receiver_email=' . $data['receiver_email']
                        . "&site_id=" . Site::instance()->get('cc_payment_id')
                        . "&secure_code=" . Site::instance()->get('cc_secure_code');

                $result = unserialize(stripcslashes(Toolkit::curl_pay(Site::instance()->get('pp_sync_url'), $post_var)));

                if (is_array($result))
                {
                    $result['status_id'] = isset($result['status_id']) ? $result['status_id'] : '';
                    $result['status'] = isset($result['status']) ? $result['status'] : '';
                    $result['trans_id'] = isset($result['trans_id']) ? $result['trans_id'] : '';
                    $result['message'] = isset($result['message']) ? $result['message'] : '';
                    $result['api'] = isset($result['api']) ? $result['api'] : '';
                    $result['avs'] = isset($result['avs']) ? $result['avs'] : '';
                }

                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'success';
                $payment_log_status = 'success';
                $mail_params['order_view_link'] = '<a href="http://' . Site::instance()->get('domain') . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                $mail_params['order_num'] = $order['ordernum'];
                $mail_params['email'] = $order['email'];
                $mail_params['firstname'] = $data['first_name'];
                $products = $order['products'] ? unserialize($order['products']) : array();
                foreach ($products as $p)
                {
                    $product = Product::instance($p['id']);
                    $hits = $product->get('hits');
                    $product->set(array('hits' => $hits + $p['quantity']));
                }
                $mail_params['order_product'] =
                        '<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
                                            <tbody>
                                                <tr align="left">
                                                    <td colspan="5"><strong>Product Details</strong></td>
                                                </tr>';
                $customer_id = $order['customer_id'];
                $celebrity_id = Customer::instance($customer_id)->is_celebrity();
                $order_products = Order::instance($order['id'])->products();
                $currency = Site::instance()->currencies($order['currency']);
                foreach ($order_products as $rs)
                {
                    $mail_params['order_product'] .= '<tr align="left">
                                                                <td>' . Product::instance($rs['item_id'], $order['lang'])->get('name') . '</td>
                                                                <td>QTY:' . $rs['quantity'] . '</td>
                                                                <td>' . $rs['attributes'] . '</td>
                                                                <td>' . $currency['code'] . round($rs['price'] * $order['rate'], 2) . '</td>
                                                        </tr>';
                }
                $mail_params['order_product'] .= '</tbody></table>';

                $mail_params['currency'] = $order['currency'];
                $mail_params['amount'] = round($order['amount'],2);
                $mail_params['pay_num'] = round($order['amount'],2);
                $mail_params['pay_currency'] = $order['currency'];
                $mail_params['shipping_firstname'] = $order['shipping_firstname'];
                $mail_params['shipping_lastname'] = $order['shipping_lastname'];
                $mail_params['address'] = $order['shipping_address'];
                $mail_params['city'] = $order['shipping_city'];
                $mail_params['state'] = $order['shipping_state'];
                $mail_params['country'] = $order['shipping_country'];
                $mail_params['zip'] = $order['shipping_zip'];
                $mail_params['phone'] = $order['shipping_phone'];
                $mail_params['shipping_fee'] = round($order['amount_shipping'],2);
                $mail_params['payname'] = '';
                $mail_params['created'] = date('Y-m-d H:i', $order['created']);
                $mail_params['points'] = floor($order['amount']);
                if ($celebrity_id)
                {
                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                    Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                }
                else
                {
                    $vip_level = Customer::instance($customer_id)->get('vip_level');
                    $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');
                    $rate = $order['rate'] ? $order['rate'] : 1;
                    $points = ($order['amount'] / $rate) * $vip_return;
                    $mail_params['order_points'] = $points;
                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                    Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                }
                break;
            case 'Pending':
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'pending';
                $payment_log_status = 'pending';
                break;
            case 'Refunded':
                $order_update['refund_status'] = 'refund';
                $payment_log_status = 'refund';
                $mail_params['order_num'] = $order['ordernum'];
                $mail_params['currency'] = $order['currency'];
                $mail_params['amount'] = round($order['amount'],2);
                $mail_params['email'] = $data['email'];
                $mail_params['firstname'] = $data['first_name'];
                $mail_params['billingname'] = $data['first_name'] . ' ' . $data['last_name'];
                Order::instance($order['id'])->set($order_update);
                Kohana_Log::instance()->add('REFUND', 'PAYSUCCESS');
                Mail::SendTemplateMail('REFUND', $mail_params['email'], $mail_params);
                break;
            case 'Failed':
                $order_update['payment_status'] = 'failed';
                $payment_log_status = 'failed';
                $mail_params['order_view_link'] = '<a href="http://' . Site::instance()->get('domain') . '/order/view/' . $ordernum . '">View your order</a>';
                $mail_params['created'] = date('Y-m-d H:i', $order['created']);
                $mail_params['order_num'] = $order['ordernum'];
                $mail_params['currency'] = $order['currency'];
                $mail_params['amount'] = round($order['amount'],2);
                $mail_params['email'] = $order['email'];
                $mail_params['firstname'] = $data['first_name'];
                Order::instance($order['id'])->set($order_update);
                Kohana_Log::instance()->add('FAILED_MAIL', 'PAYSUCCESS');
                Mail::SendTemplateMail('FAILED_MAIL', $mail_params['email'], $mail_params);
                break;
        }

        Order::instance($order['id'])->set($order_update);

        $payment_log = array(
            'site_id' => Site::instance()->get('id'),
            'order_id' => $order['id'],
            'customer_id' => $order['customer_id'],
            'payment_method' => $this->_config['name'],
            'trans_id' => $data['txn_id'],
            'amount' => $data['mc_gross'],
            'currency' => $data['mc_currency'],
            'comment' => $data['payment_status'],
            'cache' => serialize($data),
            'payment_status' => $payment_log_status,
            'ip' => ip2long(Request::$client_ip),
            'created' => time(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['payer_email'],
            'address' => $data['address_street'],
            'zip' => $data['address_zip'],
            'city' => $data['address_city'],
            'state' => $data['address_state'],
            'country' => $data['address_country'],
            'phone' => '',
        );
        $this->log($payment_log);

        return 'SUCCESS';
    }

    /**
     * hash_call: Function to perform the API call to PayPal using API signature
     * @methodName is name of API  method.
     * @nvpStr is nvp string.
     * returns an associtive array containing the response from the server.
     */
    function hash_call($methodName, $nvpStr)
    {
        //declaring of global variables
        global $nvp_Header, $subject, $AUTH_token, $AUTH_signature, $AUTH_timestamp;
        // form header string
        $nvpheader = $this->nvpHeader();
        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_ec_config['SUBMITURL']);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //in case of permission APIs send headers as HTTPheders
        if (!empty($AUTH_token) && !empty($AUTH_signature) && !empty($AUTH_timestamp))
        {
            $headers_array[] = "X-PP-AUTHORIZATION: " . $nvpheader;

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
            curl_setopt($ch, CURLOPT_HEADER, false);
        }
        else
        {
            $nvpStr = $nvpheader . $nvpStr;
        }

        //check if version is included in $nvpStr else include the version.
        if (strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr))
        {
            $nvpStr = "&VERSION=" . urlencode($this->_ec_config['VERSION']) . $nvpStr;
        }

        $nvpreq = "METHOD=" . urlencode($methodName) . $nvpStr;

        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        //getting response from server
        $response = curl_exec($ch);

        //convrting NVPResponse to an Associative Array
        $nvpResArray = $this->deformatNVP($response);
        $nvpReqArray = $this->deformatNVP($nvpreq);
        $_SESSION['nvpReqArray'] = $nvpReqArray;

        if (curl_errno($ch))
        {
            // moving to display page to display curl errors
            $_SESSION['curl_error_no'] = curl_errno($ch);
            $_SESSION['curl_error_msg'] = curl_error($ch);
            var_dump(curl_error($ch));exit;
            // echo View::factory('ppec/error')->render();
        }
        else
        {
            //closing the curl
            curl_close($ch);
        }

        return $nvpResArray;
    }

    function nvpHeader()
    {
        global $nvp_Header, $subject, $AUTH_token, $AUTH_signature, $AUTH_timestamp;
        $nvpHeaderStr = "";

        if (defined('AUTH_MODE'))
        {
            //$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
            //$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
            //$AuthMode = "THIRDPARTY";Partner's API Credential and Merchant Email as Subject are required.
            $AuthMode = "AUTH_MODE";
        }
        else
        {

            if ((!empty($this->_ec_config['USER'])) && (!empty($this->_ec_config['PWD'])) && (!empty($this->_ec_config['SIGNATURE'])) && (!empty($subject)))
            {
                $AuthMode = "THIRDPARTY";
            }
            else if ((!empty($this->_ec_config['USER'])) && (!empty($this->_ec_config['PWD'])) && (!empty($this->_ec_config['SIGNATURE'])))
            {
                $AuthMode = "3TOKEN";
            }
            elseif (!empty($AUTH_token) && !empty($AUTH_signature) && !empty($AUTH_timestamp))
            {
                $AuthMode = "PERMISSION";
            }
            elseif (!empty($subject))
            {
                $AuthMode = "FIRSTPARTY";
            }
        }
        switch ($AuthMode)
        {

            case "3TOKEN" :
                $nvpHeaderStr = "&PWD=" . urlencode($this->_ec_config['PWD']) . "&USER=" . urlencode($this->_ec_config['USER']) . "&SIGNATURE=" . urlencode($this->_ec_config['SIGNATURE']);
                break;
            case "FIRSTPARTY" :
                $nvpHeaderStr = "&SUBJECT=" . urlencode($subject);
                break;
            case "THIRDPARTY" :
                $nvpHeaderStr = "&PWD=" . urlencode($this->_ec_config['PWD']) . "&USER=" . urlencode($this->_ec_config['USER']) . "&SIGNATURE=" . urlencode($this->_ec_config['SIGNATURE']) . "&SUBJECT=" . urlencode($subject);
                break;
            case "PERMISSION" :
                $nvpHeaderStr = formAutorization($AUTH_token, $AUTH_signature, $AUTH_timestamp);
                break;
        }
        return $nvpHeaderStr;
    }

    /** This function will take NVPString and convert it to an Associative Array and it will decode the response.
     * It is usefull to search for a particular key and displaying arrays.
     * @nvpstr is NVPString.
     * @nvpArray is Associative Array.
     */
    function deformatNVP($nvpstr)
    {

        $intial = 0;
        $nvpArray = array();


        while (strlen($nvpstr))
        {
            //postion of Key
            $keypos = strpos($nvpstr, '=');
            //position of value
            $valuepos = strpos($nvpstr, '&') ? strpos($nvpstr, '&') : strlen($nvpstr);

            /* getting the Key and Value values and storing in a Associative Array */
            $keyval = substr($nvpstr, $intial, $keypos);
            $valval = substr($nvpstr, $keypos + 1, $valuepos - $keypos - 1);
            //decoding the respose
            $nvpArray[urldecode($keyval)] = urldecode($valval);
            $nvpstr = substr($nvpstr, $valuepos + 1, strlen($nvpstr));
        }
        return $nvpArray;
    }

    function formAutorization($auth_token, $auth_signature, $auth_timestamp)
    {
        $authString = "token=" . $auth_token . ",signature=" . $auth_signature . ",timestamp=" . $auth_timestamp;
        return $authString;
    }

}
