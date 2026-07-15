<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;

class ProductFeedController extends Controller
{
    public function index()
    {

        $products = Product::with('brand:id,name', 'category:id,name', 'getSingleImage:id,product_id,file_path')
            ->where('status', 'active')
            ->get();

        $xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?>
            <rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"></rss>'
        );

        $channel = $xml->addChild('channel');
        $url = 'https://plummylookbd.com';
        $channel->addChild('title', 'Plummy Look BD Product Feed');
        $channel->addChild('link', url($url));
        $channel->addChild('description', 'Product feed for Google Merchant');

        foreach ($products as $product) {

            $item = $channel->addChild('item');
            $ns = 'http://base.google.com/ns/1.0';

            $item->addChild('g:id', htmlspecialchars((string) $product->id), $ns);

            // TITLE (CDATA)
            $title = $item->addChild('g:title', null, $ns);
            $this->addCDATA($title, $product->name);

            // DESCRIPTION (CDATA) — max 5000 chars per Google spec
            $desc = $item->addChild('g:description', null, $ns);
            $this->addCDATA($desc, mb_substr(strip_tags($product->details), 0, 5000));

            $item->addChild(
                'g:link',
                htmlspecialchars($url.'/details/'.$product->slug),
                $ns
            );

            $item->addChild(
                'g:image_link',
                htmlspecialchars($url.'/'.$product->getSingleImage->file_path),
                $ns
            );

            // Add exact local category Name to product_type
            $item->addChild('g:product_type', htmlspecialchars((string) $product->category->name ?? ''), $ns);

            $item->addChild('g:condition', 'new', $ns);

            $item->addChild(
                'g:availability',
                $product->stock > 0 ? 'in stock' : 'out of stock',
                $ns
            );

            $price = $product->new_price ?? $product->price;

            $item->addChild(
                'g:price',
                htmlspecialchars($price.' BDT'),
                $ns
            );
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addCDATA($node, $cdata_text): void
    {
        $node_dom = dom_import_simplexml($node);
        $node_owner = $node_dom->ownerDocument;
        $node_dom->appendChild($node_owner->createCDATASection($cdata_text));
    }
}
