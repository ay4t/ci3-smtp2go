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
			"product_name" 		=> 'Nama Perusahaan',
			"login_url" 		=> 'https://domain_anda.com',
			"guide_url" 		=> 'https://domain_anda.com',
			"support_email" 	=> 'support@domain.com',
			"sender_name" 		=> 'Nama Perusahaan',
		];

		$email 	= new Smtp2GO();
		$email->setTo('kawoel@gmail.com', 'Ayatulloh Ahad R');
		$email->setSender('sender@example.com', 'Nama Pengirim');
		$email->setTemplateID('6799681');
		$email->setTemplateData($template_data);
		$result 	= $email->sendWithTemplate();

		var_dump($result);
