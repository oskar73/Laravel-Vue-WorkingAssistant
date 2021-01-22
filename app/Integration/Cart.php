<?php

namespace App\Integration;

class Cart
{
    public $items;

    public $totalQty = 0;

    public $onetimeQty = 0;

    public $subQty = 0;

    public $totalPrice = 0;

    public $onetimeTotalPrice = 0;

    public $subTotalPrice = 0;

    public $status = 1;

    public function __construct($oldCart = null)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->onetimeQty = $oldCart->onetimeQty;
            $this->subQty = $oldCart->subQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->onetimeTotalPrice = $oldCart->onetimeTotalPrice;
            $this->subTotalPrice = $oldCart->subTotalPrice;
            $this->status = $oldCart->status;
        }
    }

    public function totalQty($type = null)
    {
        $totalQty = 0;
        $onetimeQty = 0;
        $subQty = 0;
        if (count($this->items) !== 0) {
            foreach ($this->items as $item) {
                $totalQty += $item['quantity'];
                if ($item['recurrent'] == 0) {
                    $onetimeQty += $item['quantity'];
                } else {
                    $subQty += $item['quantity'];
                }
            }
        }

        if ($type == 'onetime') {
            return $onetimeQty;
        } elseif ($type == 'sub') {
            return $subQty;
        } else {
            return $totalQty;
        }
    }

    public function totalPrice()
    {
        $totalPrice = 0;
        if (count($this->items) !== 0) {
            foreach ($this->items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
        }

        return formatNumber($totalPrice);
    }

    public function onetimeTotalPrice()
    {
        $onetimeTotalPrice = 0;
        if (count($this->items) != 0) {
            foreach ($this->items as $item) {
                if ($item['recurrent'] === 0) {
                    $onetimeTotalPrice += $item['price'] * $item['quantity'];
                }
            }
        }

        return formatNumber($onetimeTotalPrice);
    }

    public function subTotalPrice()
    {
        $subTotalPrice = 0;
        if (count($this->items) != 0) {
            foreach ($this->items as $item) {
                if ($item['recurrent'] === 1) {
                    $subTotalPrice += $item['price'] * $item['quantity'];
                }
            }
        }

        return formatNumber($subTotalPrice);
    }

    public function add($item, $url, $quantity, $price, $type, $image, $recurrent, $front, $parameter = null)
    {
        if ($this->status == 1) {
            $flag = 0;
            if (isset($this->items)) {
                foreach ($this->items as $key => $oldItem) {
                    if (in_array($type, ['blogAds', 'siteAds', 'directoryAds'])) {
                        if (in_array($oldItem['type'], ['blogAds', 'siteAds', 'directoryAds']) && $oldItem['item']['id'] == $item->id) {
                            if ($item->price->type == 'period' && $oldItem['item']['price']['type'] == 'period') {
                                unset($this->items[$key]);
                            }
                            if ($item->price->type == 'impression' && $oldItem['item']['price']['type'] == 'impression' && $item->price->id == $oldItem['item']['price']['id']) {
                                $this->items[$key]['quantity'] += $quantity;
                                $flag = 1;
                            }
                        }
                    } elseif ($type === 'ecommerce') {
                        if ($type == $oldItem['type']
                            && $recurrent == $oldItem['recurrent']
                            && $item->id == $oldItem['item']['id']
                            && $price == $oldItem['price']
                            && $parameter['color_id'] == $oldItem['parameter']['color_id']
                            && $parameter['size_id'] == $oldItem['parameter']['size_id']
                            && $parameter['custom_id'] == $oldItem['parameter']['custom_id']
                        ) {
                            $this->items[$key]['quantity'] += $quantity;
                            $flag = 1;
                        }
                    } else {
                        if ($recurrent == 0 && $type == $oldItem['type'] && $recurrent == $oldItem['recurrent'] && $item->id == $oldItem['item']['id'] && $price == $oldItem['price']) {
                            $this->items[$key]['quantity'] += $quantity;
                            $flag = 1;
                        }
                    }
                }
            }
            if ($flag == 0) {
                if ($recurrent == 0) {
                    $id = guid();
                    $row['item'] = $item;
                    $row['url'] = $url;
                    $row['quantity'] = $quantity;
                    $row['price'] = formatNumber($price);
                    $row['front'] = $front;
                    $row['type'] = $type;
                    $row['image'] = $image;
                    $row['recurrent'] = $recurrent;
                    $row['parameter'] = $parameter;
                    $this->items[$id] = $row;
                } else {
                    for ($i = 0; $i < $quantity; $i++) {
                        $id = guid();
                        $row['item'] = $item;
                        $row['url'] = $url;
                        $row['quantity'] = 1;
                        $row['price'] = formatNumber($price);
                        $row['front'] = $front;
                        $row['type'] = $type;
                        $row['image'] = $image;
                        $row['recurrent'] = $recurrent;
                        $row['parameter'] = $parameter;
                        $this->items[$id] = $row;
                    }
                }
            }

            $this->totalQty = $this->totalQty();
            $this->onetimeQty = $this->totalQty('onetime');
            $this->subQty = $this->totalQty('sub');
            $this->totalPrice = $this->totalPrice();
            $this->onetimeTotalPrice = $this->onetimeTotalPrice();
            $this->subTotalPrice = $this->subTotalPrice();
        }
    }

    public function updateCart($items)
    {
        if ($this->status == 1) {
            foreach ($items as $key => $item) {
                if (in_array($this->items[$key]['type'], ['blogAds', 'siteAds', 'directoryAds']) && $this->items[$key]['item']['price']['type'] == 'period') {
                    $this->items[$key]['quantity'] = $item;
                } else {
                    if ($this->items[$key]['recurrent'] == 0) {
                        $this->items[$key]['quantity'] = $item;
                    } else {
                        for ($i = 1; $i < $item; $i++) {
                            $id = guid();
                            $row['item'] = $this->items[$key]['item'];
                            $row['url'] = $this->items[$key]['url'];
                            $row['quantity'] = 1;
                            $row['price'] = $this->items[$key]['price'];
                            $row['front'] = $this->items[$key]['front'];
                            $row['type'] = $this->items[$key]['type'];
                            $row['image'] = $this->items[$key]['image'];
                            $row['recurrent'] = $this->items[$key]['recurrent'];
                            $row['parameter'] = $this->items[$key]['parameter'];
                            $this->items[$id] = $row;
                        }
                    }
                }
            }
            $this->totalQty = $this->totalQty();
            $this->onetimeQty = $this->totalQty('onetime');
            $this->subQty = $this->totalQty('sub');
            $this->totalPrice = $this->totalPrice();
            $this->onetimeTotalPrice = $this->onetimeTotalPrice();
            $this->subTotalPrice = $this->subTotalPrice();
        }
    }

    public function removeOne($id)
    {
        unset($this->items[$id]);
        $this->totalQty = $this->totalQty();
        $this->onetimeQty = $this->totalQty('onetime');
        $this->subQty = $this->totalQty('sub');
        $this->totalPrice = $this->totalPrice();
        $this->onetimeTotalPrice = $this->onetimeTotalPrice();
        $this->subTotalPrice = $this->subTotalPrice();
    }

    public function applyCoupon($coupon)
    {
        $this->status = 0;
    }

    public function disable()
    {
        $this->status = 0;
    }

    public function enable()
    {
        $this->status = 1;
    }
}
