<?php
/**
 * Plugin Name: Aliyun SDK Wrapper
 * Description: 提供阿里云接口常用方法的简单封装
 * Version: 0.1.0
 * Author: Uice Lu
 * Author URI: https://cecilia.uice.lu
 * License: GPLv2 or later
 * Text Domain: aliyun-sdk-wrapper
 */

require __DIR__ . '/openapi-sdk-php-client/vendor/autoload.php';
use AlibabaCloud\Client\AlibabaCloud;

function aliyun_send_mobile_code($mobile, $code) {
	AlibabaCloud::accessKeyClient(ALIYUN_ACCESS_KEY, ALIYUN_ACCESS_SECRET)
		->regionId('cn-hangzhou')
		->asGlobalClient();
	try {
		$result = AlibabaCloud::rpcRequest()
			->product('Dysmsapi')
			->version('2017-05-25')
			->action('SendSms')
			->method('POST')
			->options([
				'query' => [
					'PhoneNumbers' => $mobile,
					'SignName' => ALIYUN_SMS_SIGNATURE,
					'TemplateCode' => ALIYUN_SMS_CODE_VERIFY_MOBILE,
					'TemplateParam' => json_encode(array('code' => (string)$code))
				],
			])
			->request();

		return $result;

	} catch(Exception $exception) {
		error_log($exception->getMessage());
	}
}

function aliyun_send_sms($mobile, $template, $params) {
	AlibabaCloud::accessKeyClient(ALIYUN_ACCESS_KEY, ALIYUN_ACCESS_SECRET)
		->regionId('cn-hangzhou')
		->asGlobalClient();
	try {
		$result = AlibabaCloud::rpcRequest()
			->product('Dysmsapi')
			->version('2017-05-25')
			->action('SendSms')
			->method('POST')
			->options([
				'query' => [
					'PhoneNumbers' => $mobile,
					'SignName' => ALIYUN_SMS_SIGNATURE,
					'TemplateCode' => $template,
					'TemplateParam' => json_encode($params, JSON_UNESCAPED_UNICODE)
				],
			])
			->request();

		return $result;

	} catch(Exception $exception) {
		error_log($exception->getMessage());
	}
}
