<?php
class Encryption {
    
	function encode($string){ 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'shc';
		$secret_iv = 'Sm@rthe@ltH';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output; 
    }
	
	function decode($string){ 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'shc';
		$secret_iv = 'Sm@rthe@ltH';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output; 
    }
	function encode_file($string){ 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'file';
		$secret_iv = 'Sm@rthe@ltH';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output; 
    }
	
	function decode_file($string){ 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'file';
		$secret_iv = 'Sm@rthe@ltH';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output; 
    }
	
	
}
