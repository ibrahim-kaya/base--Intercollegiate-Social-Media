<?php
	$ENCRYPTION_KEY = '!!tkn<3xp15042019nku59!!';
	$ENCRYPTION_ALGORITHM = 'AES-256-CBC';

	function EncryptThis($ClearTextData) {
		// This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
		// The initialization vector (IV) is appended to the cipher data with 
		// the use of two colons serve to delimited between the two.
		global $ENCRYPTION_KEY;
		global $ENCRYPTION_ALGORITHM;
		$EncryptionKey = base64_decode($ENCRYPTION_KEY);
		$InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));
		$EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
		return base64_encode($EncryptedText . '::' . $InitializationVector);
	}

	function DecryptThis($CipherData) {
		// This function decrypts the cipher data (with the IV embedded within) passed into it 
		// and returns the clear text (unencrypted) data.
		// The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
		// There are two colons that serve to delimited between the cipher data and the IV.
		global $ENCRYPTION_KEY;
		global $ENCRYPTION_ALGORITHM;
		$EncryptionKey = base64_decode($ENCRYPTION_KEY);
		list($Encrypted_Data, $InitializationVector ) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
		return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
	}
?>