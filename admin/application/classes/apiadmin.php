<?php
defined('SYSPATH') or die('No direct script access.');

class Apiadmin
{
    public static function createall($emails = array())
    {
        foreach ($emails as $key => $customer_email) 
        {
            $message = '';
            $customer_id = DB::select('id')
                ->from('customers')
                ->where('email', '=', $customer_email)
                ->execute('slave')
                ->get('id');
            if (!$customer_id)
            {
                $message .= 'email:'.$customer_email.'对应的客户不存在<br />';
            }

            $is_backorder = Arr::get($_POST, 'is_backorder', FALSE);
            $customer = new Customer($customer_id);
            $customer_address = DB::select()
                ->from('addresses')
                ->where('customer_id', '=', $customer_id)
                ->order_by('id', 'desc')
                ->execute('slave')
                ->current();

            $carrier = Arr::get($_POST, 'carrier', '');
            $order_from = Arr::get($_POST, 'order_from', 'activity');//订单来源

            $payment_method = Arr::get($_POST, 'payment_method', 'PP');
            $order_id = Order::init();
            $order = new Order($order_id);
            $order_data = array(
                'customer_id' => $customer_id,
                'email' => $customer_email,
                'payment_status' => 'verify_pass',
                'currency' => 'USD',
                'parent_id' => $is_backorder ? $ref_orderid : NULL,
                'shipping_method' => $carrier,
                'payment_method' => $payment_method,
                'verify_date' => time(),
                'order_from'=>$order_from,//订单来源
            );

            //add remark
            $remark['site_id'] = 1;
            $remark['order_id'] = $order_id;
            $remark['remark'] = '9610项目,发WXEUB';          
            $order->add_remark($remark);

            if ($customer_address)
            {
                $order_data += array(
                    'shipping_firstname' => $customer_address['firstname'],
                    'shipping_lastname' => $customer_address['lastname'],
                    'shipping_country' => $customer_address['country'],
                    'shipping_state' => $customer_address['state'],
                    'shipping_city' => $customer_address['city'],
                    'shipping_address' => $customer_address['address'],
                    'shipping_zip' => $customer_address['zip'],
                    'shipping_phone' => $customer_address['phone'],
                    'shipping_mobile' => $customer_address['other_phone'],
                    'billing_firstname' => $customer_address['firstname'],
                    'billing_lastname' => $customer_address['lastname'],
                    'billing_country' => $customer_address['country'],
                    'billing_state' => $customer_address['state'],
                    'billing_city' => $customer_address['city'],
                    'billing_address' => $customer_address['address'],
                    'billing_zip' => $customer_address['zip'],
                    'billing_phone' => $customer_address['phone'],
                    'billing_mobile' => $customer_address['other_phone'],
                );
            }

            $order->set($order_data);

            #增加产品
            Apiadmin::addproduct($order_id,$message);

        }
    }


    public static function addproduct($order_id,$message)
    {
        $proinfo = Kohana::config('api.proinfo');
        $product = DB::select()
            ->from('products')
            ->where('sku', '=', $proinfo['sku'])
            ->execute('slave')
            ->current();
        if (!$product)
        {
            die('Product not found');
        }
        $order = Order::instance($order_id, 0);
        $has_customize = FALSE;
        $customize = Arr::get($_POST, 'customize', null);
        $attr['Size'] = 'one size';
        $attributes = '';
        foreach ($attr as $name => $attribute)
        {
            $eur = strpos($attribute, 'EUR');
            if ($eur !== false)
            {
                $attribute = substr($attribute, $eur + 3, 2);
            }
            $attributes .= ucfirst($name) . ':' . trim($attribute) . ';';
        }

        $price = Arr::get($_POST, 'price', '0');

        $item = array(
            'item_id' => $product['id'],
            'product_id' => $product['id'],
            'price' => $price != '' ? $price : Product::instance($product['id'])->price($proinfo['qty']),
            'quantity' => $proinfo['qty'] == 0 ? 1 : $proinfo['qty'],
            'customize_type' => Arr::get($_POST, 'customize_type', 'none'),
            'customize' => ($has_customize ? serialize($customize) : NULL),
            'attributes' => $attributes,
        );

        $ret = $order->add_item($item);

        $amount = $order->get('amount');
        $amount += $item['price'] * $item['quantity'];
        $update = array(
            'amount' => $amount,
            'amount_order' => $amount,
            'amount_products' => $amount,
        );
        $order->update_basic($update);

        return $message;

    }


}
