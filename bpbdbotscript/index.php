<?php
	require_once 'vendor/autoload.php'; //koneksi bot engine telegram ke php
	$bot = new PHPTelebot('1167185320:AAEpswmETV0XF1egPH24dCKrCwnnWaFDRlw', '@bpbdsemarang_6php1bot'); //('Token bot diambil dari @botfather','akun bot yang telah dibuat di @botfather')
	require 'menuButton.php';

	//Command sederhana
	$bot->cmd('/ping', 'PONG!!');

	//Command tampilkan waktu sekarang (WIB)
	$bot->cmd('/time', function ($text) {
		$text	= 'Waktu Sekarang, pukul ' . date('H:i:s') . ' WIB. Tanggal,' . date('d M Y');
		return Bot::sendMessage($text);
	});

	#Menu Start
	//Tombol-tombol menu utama jika pengguna menginputkan /start
	$bot->cmd('/start|Home', function() {
		$text		= "👋🏻 Hai, Silakan pilih menu disini.. \n"; //inisiasi

		//tombol menu utama
		$keyboard[]	= ['Kabar Terbaru', 'Website'];
		$keyboard[]	= ['Sosial Media', 'Contact'];

		//plugin framework
		$option		= [
			'reply_markup' => ['keyboard'=> $keyboard,
			'resize_keyboard'=> true
			]
		];

		return Bot::sendMessage($text, $option);
	});

	//event bot
	$bot->on('new_chat_member', function() {
		//ketika ada respon pengguna di grup
		$msg	= Bot::message(); //ambil dari respon bot
		$nama	= $msg['new_chat_member']['first_name']; //ambil dari array respon dari event di grup(json)

		//sapaan pakai nama belakang sekalian jika ada
		if ( isset($msg['new_chat_member']['last_name']) ) {
			$nama	.= ' '. $msg['new_chat_member']['last_name'];
		}

		//sapaan jika ada member baru dalam grup
		$greet 	= 'Halo Selamat Bergabung, <b>' . $nama . '</b>!';
		$greet	.= "Kalo mau coba, silakan bisa cobain perintah ini: \n";
		$greet	.= "/start = inisialisasi bot \n";
		$greet	.= "/ping = tes response user ke bot \n";
		$greet	.= "/time = untuk lihat waktu sekarang \n\n";
		$greet	.= "Silahkan dicoba, <b>" . $nama . "</b>";

		//text bold untuk username yg baru gabung
		$option = [
			'parse_mode' => 'html'
		];

		//send greetings
		Bot::sendMessage($greet, $option);
	});





	//baris paling bawah

	//run run run!!
	$bot->run();

?>

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//menuButton.php

<?php 
    //berisi syntax untuk submenu button di index
    
    #Sub-Menu: Kabar Terbaru
	//isi dari menu button Kabar
	$bot->cmd('Kabar Terbaru', function() {
		//inisialisasi
		$text		= "Kabar Terbaru Untuk: \n";

		//menu button
		$keyboard[]	= ['Bencana', 'Cuaca'];
		$keyboard[] = ['Home'];

		//telebot plugin
		$option		= [
			'reply_markup' => ['keyboard'=> $keyboard,
			'resize_keyboard'=> true
			]
		];

		return Bot::sendMessage( $text, $option );
	});
		#Item-Menu: Bencana
		$bot->cmd('Bencana', function() {
			$url	= "Akses channel berita terbaru \n http://t.me/BPBD_Semarang/";
			return Bot::sendMessage( $url );
		});
		
		#Item-Menu: Cuaca
		$bot->cmd('Cuaca', function() {
			$link	= "https://www.bmkg.go.id/cuaca/prakiraan-cuaca.bmkg?Kota=Semarang&AreaID=501262&Prov=35";
			$url	= "Informasi Cuaca terbaru di Kota Semarang, \nSumber: bmkg \n" .$link;
			
			return Bot::sendMessage( $url );
		});



	#Sub-Menu: Website
	$bot->cmd('Website', function() {
		//redirect telegram ke web bpbd srg
		$keyboard[] = [
			['text' => '🌐 Web BPBD Semarang', 'url' => 'https://bpbd.semarangkota.go.id'],
		];
		$option		= [
			'reply_markup'	=> ['inline_keyboard' => $keyboard],
		];
		return Bot::sendMessage('Silakan akses link dibawah', $option);
		
	});

	#Sub-Menu: Sosial Media
	$bot->cmd('Sosial Media', function() {
		//redirect telegram ke web bpbd srg
		$keyboard[] = [
			['text' => '🟡Instagram', 'url' => 'https://www.instagram.com/bpbd_semarang/'],
			['text' => '🟢 Twitter', 'url' => 'https://twitter.com/BPBD_Semarang'],
		];
		$keyboard[] = [
			['text' => '🔵 Facebook', 'url' => 'https://www.facebook.com/bpbd.semarang'],
			['text' => '🔴 Youtube', 'url' => 'https://www.youtube.com/channel/UCx3mUCT3iKzFQ2T0oHrZQUQ/'],
		];
		$option		= [
			'reply_markup'	=> ['inline_keyboard' => $keyboard],
		];
		return Bot::sendMessage('Silakan akses link sosial media official dibawah', $option);
		
	});

	#Sub-Menu: Contact
	//send to email
	$bot->cmd('Contact', function() {
		
		$contact	= '[Silakan kirim email anda kesini](mailto:bpbdsemarangkota@gmail.com)';
		$option		= [
			'parse_mode' => 'Markdown',
		];
		return Bot::sendMessage($contact, $option);
		
	});
?>