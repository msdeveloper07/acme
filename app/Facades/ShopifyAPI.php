<?php

namespace App\Facades;


class ShopifyAPI
{
  public static function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {

	// Build URL
        $api_key       = env('SHOPIFY_API_KEY',"6d18d180382e69a7a285c26ed321f09f");
		$url   = 'https://'.$api_key.':'.$token.'@'. $shop . ".myshopify.com" . $api_endpoint;
        //echo $url;
		$token = null;

	if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);

	// Configure cURL
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, TRUE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
	// curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

	// Setup headers
	$request_headers[] = "";
	if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

	if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
		if (is_array($query)) $query = http_build_query($query);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
	}

	// Send request to Shopify and capture any errors
	$response       = curl_exec($curl);
	$error_number   = curl_errno($curl);
	$error_message  = curl_error($curl);

	// Close cURL to be nice
	curl_close($curl);

	// Return an error is cURL has a problem
	if ($error_number) {
		return $error_message;
	} else {

		// No error, return Shopify's response by parsing out the body and the headers
		$response          = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

		// Convert headers into an array
		$headers           = array();
		$header_data       = explode("\n",$response[0]);
		$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
		array_shift($header_data); // Remove status, we've already set it above
		foreach($header_data as $part) {
			$h = explode(":", $part);
			$headers[trim($h[0])] = trim($h[1]);
		}

		// Return headers and Shopify's response
		return array('headers' => $headers, 'response' => $response[1]);

	}

  }


    public static function _flushMapping(MapURL $map_url){

	    $tag_groups    = self::_getTags($map_url->client_id, $map_url->id);
	   	$api_call_info = [];

	    $website_theme_asset = [];
		foreach($tag_groups as $tag_group_id=>$tag_group){
			$tag_group_it   = $tag_group;
			$meta_field_ids = [];
			foreach($tag_group as $tag){
				if(!isset($api_call_info[$tag['website_id']])){
					try{
						$website   = WebgWebsite::findOrFail($tag['website_id']);
						$api_call_info[$tag['website_id']]['access_token'] = $website->access_token;
						$api_call_info[$tag['website_id']]['shopname']     = $website->shopname;

					}catch(\Exception $e){

					}
				}


				if(isset($api_call_info[$tag['website_id']])){
					//product meta fields

					$token              = $api_call_info[$tag['website_id']]['access_token'];
					$shop               = $api_call_info[$tag['website_id']]['shopname'];

					$resource_type      = $tag['page_type'];

					if($tag['page_type'] == 'categories'){
						$resource_type  = 'collections';
					}

					//prepare tags data
					$meta_field_tags_info = [];
					$tag_group_itr        = $tag_group_it;
					foreach($tag_group_itr as $tag_data){


						$meta_field_tag['url']    = urlencode($tag_data['url']);
						$meta_field_tag['lang']   = $tag_data['lang'];
						$meta_field_tag['region'] = $tag_data['region'];


						array_push($meta_field_tags_info, $meta_field_tag );
					}

					$meta_field_data = [
							'metafield' => [
								'namespace'  => 'global',
								'value_type' => 'json_string',
								'value'      => json_encode($meta_field_tags_info),
								'key'        => 'hreflang_tags'
							],
						];


					$meta_field_post_api      = ShopifyAPI::shopify_call($token,$shop,"/admin/".$resource_type."/".$tag['shopify_object_id']."/metafields.json", $meta_field_data, 'POST');
					$post_metafield_response  = json_decode($meta_field_post_api['response'], true);

					if(isset($post_metafield_response['metafield'])){

						$meta_field_info['meta_field_id'] = $post_metafield_response['metafield']['id'];
						$meta_field_info['website_id']    = $tag['website_id'];
						$meta_field_info['token']         = $token;
						$meta_field_info['shop'] 		  = $shop;
						$meta_field_info['resource_type'] = $resource_type;
						$meta_field_info['shopify_object_id'] = $tag['shopify_object_id'];

						array_push($meta_field_ids, $meta_field_info );
					}


					if(!isset( $website_theme_asset[$tag['website_id']] )) {
						$asset_status  = self::_checkWebsiteThemeAssets($token, $shop);

						if(isset($asset_status['snippets_status']) && $asset_status['snippets_status'] == 'exist') {
							$website_theme_asset[$tag['website_id']] = true;
						}
					}

				}


			}

			if(!empty($meta_field_ids)){
				try{
					$map_url                  =  MapURL::findOrFail($tag_group_id);
					$map_url->meta_field_ids  =  serialize($meta_field_ids);
					$map_url->save();

					return $map_url;

				}catch(\Exception $e){

				}

			}
		}

	    return true;

	   //working

   }


  	/**
     * Function to get all mapped URLs & tags for the group.
     * @params $client_id ( Group ), optional $map_url_id
     * @return array
     */

	public static function _getTags($client_id, $map_url_id = null){

		$mapped_url_qbuilder =  MapURL::where('client_id', $client_id );
		if($map_url_id){
			$mapped_url_qbuilder->where('id', $map_url_id);
		}
		$mapped_urls         = $mapped_url_qbuilder->get();

		$tags        = [];

		foreach($mapped_urls as $mapped_url){
			foreach( explode(',',$mapped_url->urls) as $web_url_id ){

				try{
					$web_url = WebsiteURL::with('website')->findOrFail($web_url_id);

					if(isset($web_url->website->Href_region_code) && !empty($web_url->website->Href_region_code) && $web_url->website->client_id == $client_id ){
						foreach( explode(',', $web_url->website->Href_region_code) as $href_region_code ){

							$url                        = str_replace('https://'.$web_url->website->shopname.'.myshopify.com', $web_url->website->domain_name, $web_url->url );

							$tag['id']    		        = $web_url->id;
							$tag['region'] 				= $href_region_code;
							$tag['lang']   				= $web_url->website->Href_lang_code;
							$tag['url']    				= $url;
							$tag['shopify_object_id']   = $web_url->shopify_object_id;
							$tag['page_type']    		= $web_url->page_type;
							$tag['website_id']    		= $web_url->website_id;
							$tag['link']    		    = '<link rel="alternate" href="'.$url.'" hreflang="'.$web_url->website->Href_lang_code.'-'.$href_region_code.'" >';


							if(!isset($tags[$mapped_url->id])){
								$tags[$mapped_url->id] = [];
							}
							array_push($tags[$mapped_url->id], $tag);

						}
					}
				}catch(\Exception $e){


				}

			}

		}

		return $tags;

	}

		/**
     * Function to check hreflang-tags snippet in a website active theme.
     * @params  $token , $store_name
     * @return array status
     */
	public static function _checkWebsiteThemeAssets($token, $shop){

		 $main_theme_id              = self::_getThemes($token, $shop);
		 $search_snippets            = ['asset[key]' => 'snippets/hreflang-tags.liquid'];
		 $theme_assets_api_response  = ShopifyAPI::shopify_call($token,$shop,"/admin/themes/".$main_theme_id."/assets.json", $search_snippets, 'GET');
		 $theme_assets_response      = json_decode($theme_assets_api_response['response'], true);

		 if(isset($theme_assets_response['asset'])){

			 self::_includeHREFLANGAsset($main_theme_id, $token, $shop );
			 return ['status' => 'success', 'snippets_status' => 'exist','theme_assets_response' => $theme_assets_response ];
		 }else{


			 /************* DON'T FORMAT THIS CODE ***************************/
			 $create_asset_data = [
					'asset' => [
						'key'   => 'snippets/hreflang-tags.liquid',
						'value' => '<!-- /snippets/hreflang-tags.liquid -->
{%- if product.metafields.global.hreflang_tags != blank -%}
  {% assign product_hreflang_tags = product.metafields.global.hreflang_tags %}
  {% for hreflang_tag in product_hreflang_tags %}
   <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
  {% endfor %}
{%- endif -%}

{%- if collection.metafields.global.hreflang_tags != blank -%}
  {% assign collection_hreflang_tags = collection.metafields.global.hreflang_tags %}
  {% for hreflang_tag in collection_hreflang_tags %}
   <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
  {% endfor %}
{%- endif -%}

{%- if page.metafields.global.hreflang_tags != blank -%}
  {% assign page_hreflang_tags = page.metafields.global.hreflang_tags %}
  {% for hreflang_tag in page_hreflang_tags %}
   <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
  {% endfor %}
{%- endif -%}

{%- if blog.metafields.global.hreflang_tags != blank -%}
  {% assign blog_hreflang_tags = blog.metafields.global.hreflang_tags %}
  {% for hreflang_tag in blog_hreflang_tags %}
   <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
  {% endfor %}
{%- endif -%}

{%- if article.metafields.global.hreflang_tags != blank -%}
  {% assign article_hreflang_tags = article.metafields.global.hreflang_tags %}
  {% for hreflang_tag in article_hreflang_tags %}
   <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
  {% endfor %}
{%- endif -%}

{%- if template == "index" -%}
  {%- if shop.metafields.global.hreflang_tags != blank -%}
    {% assign shop_hreflang_tags = shop.metafields.global.hreflang_tags %}
    {% for hreflang_tag in shop_hreflang_tags %}
    <link rel="alternate" href="{{ hreflang_tag.url | url_decode }}" hreflang="{{ hreflang_tag.lang }}-{{ hreflang_tag.region }}">
    {% endfor %}
  {%- endif -%}
{%- endif -%}'
					]
			    ];

			 $create_theme_assets_api_response  = ShopifyAPI::shopify_call($token,$shop,"/admin/themes/".$main_theme_id."/assets.json", $create_asset_data, 'PUT');
		     $create_theme_assets_response      = json_decode($create_theme_assets_api_response['response'], true);

		     if(isset($create_theme_assets_response['asset'])){
				self::_includeHREFLANGAsset($main_theme_id, $token, $shop );
				return ['status' => 'success', 'snippets_status' => 'exist'];
			 }

			 return ['status' => 'success', 'snippets_status' => 'not_exist'];

		 }

	}

	/**
     * Function to include hreflang-tags.liquid to active theme.
     * @params $theme_id, $token , $store_name
     * @return boolean
     */

	public static function _includeHREFLANGAsset($main_theme_id, $token, $shop){

		 $search_liquid              = ['asset[key]' => 'layout/theme.liquid'];
		 $layout_asset_api_response  = ShopifyAPI::shopify_call($token,$shop,"/admin/themes/".$main_theme_id."/assets.json", $search_liquid, 'GET');
		 $layout_asset_response      = json_decode($layout_asset_api_response['response'], true);

		 if(isset($layout_asset_response['asset'])){
			 if(strpos($layout_asset_response['asset']['value'], "{% include 'hreflang-tags' %}") === false ){

				 $str     = $layout_asset_response['asset']['value'];
				 if(strpos($str, "{% include 'social-meta-tags' %}") === false){
					 $layout_template = substr_replace($str, "{% include 'hreflang-tags' %} \n\n", strpos($str, "<script>") , 0);
				 }else{
					 $layout_template = substr_replace($str, "{% include 'hreflang-tags' %} \n\n", strpos($str, "{% include 'social-meta-tags' %}") , 0);
				 }

				 $update_layout_asset_data = [
						'asset' => [
							'key'   => 'layout/theme.liquid',
							'value' => $layout_template
						]
					];

				 $update_layout_asset_api_response  = ShopifyAPI::shopify_call($token,$shop,"/admin/themes/".$main_theme_id."/assets.json", $update_layout_asset_data, 'PUT');
				 $update_layout_asset_response      = json_decode($update_layout_asset_api_response['response'], true);


			 }

		 }

		 return true;
	}

	/**
     * Function to get active theme on the website for a group.
     * @params $token ( website acess_token ), store name ( website store name )
     * @return $theme_id
     */

	public static function _getThemes($token, $shop){

		$themes_api_response      = ShopifyAPI::shopify_call($token,$shop,"/admin/themes.json", array(), 'GET');
		$themes_response          = json_decode($themes_api_response['response'], true);


		$main_theme_id = 0;
		if(isset($themes_response['themes'])){
			foreach($themes_response['themes'] as $theme){
				if($theme['role'] == 'main'){
					$main_theme_id = $theme['id'];
					break;
				}
			}
		}


		return $main_theme_id;

	}

}
