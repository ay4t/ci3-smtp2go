# codeigniter3-smtp2go
SMTP2GO PHP Library for Codeigniter 3

#Example to use:

     /**
		 * Mengirim Email dengan SMTP2GO Service.
		 * fungsi ini untuk mengirim email dengan layanan SMTP2GO melalui jalur API 
		 * 
		 * Contoh penggunakan kirim email dengan template yang sudah di buat di user dashboard SMTP2GO
		 */

		$this->load->library('Smtp2GO');

		/**
		 * template data bersifat dinamis dan menyesuaikan apa yang Anda buat di bagian email template SMTP2GO dashboard
		 */
		$template_data 	= [
			"username" 			=> 'aahadr',
			"password" 			=> '123456',
			"product_name" 		=> 'One RIch Vision',
			"login_url" 		=> 'https://onerichvision.com',
			"guide_url" 		=> 'https://onerichvision.com',
			"support_email" 	=> 'onerichvision@gmail.com',
			"sender_name" 		=> 'One Rich Vision',
		];

		$email 	= new Smtp2GO();
		// $email->setApi_code('api-A4996FC05C0611ECA34BF23C91C88F4E');
		// $email->setTo('kawoel@gmail.com', 'Ayatulloh Ahad R');
		$email->setTo('support@onerichvision.com', 'Support One Rich');
		$email->setSender('system@onerichvision.com', 'One Rich Vision');
		$email->setTemplateID('6799681');
		$email->setTemplateData($template_data);
		$result 	= $email->sendWithTemplate();

		var_dump($result);
