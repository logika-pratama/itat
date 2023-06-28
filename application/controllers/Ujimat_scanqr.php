<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujimat_scanqr extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('tgl_indo');
		$this->load->helper('login');
		$this->load->library('user_agent');
		$this->load->helper('form');
		$this->load->library('form_validation');

		if(empty($this->session->userdata('token'))){
			redirect('login');
		}
	}

	public function index() {
		$data = array(
			'title' => 'Uji Mat (QR Code)',
		
		);
		$this->load->view('main',$data);
	}

	public function getKontrak() {
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// CURLOPT_URL => 'http://10.230.200.158:8081/api/kontrak',
		// CURLOPT_RETURNTRANSFER => true,
		// CURLOPT_ENCODING => '',
		// CURLOPT_MAXREDIRS => 10,
		// CURLOPT_TIMEOUT => 0,
		// CURLOPT_FOLLOWLOCATION => true,
		// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// CURLOPT_CUSTOMREQUEST => 'GET',
		// CURLOPT_HTTPHEADER => array(
		// 	'apikey: $pbkdf2-sha512$6000$P4cQYmzN.X8v5bw3xhijtA$PzGUd4dnuuvvEDgwhUsvDafEKu4W4Z5McvDO5nchfAlllfNsbCXBeB5XE/KrbtFEqfM4ymR2IMzGsKWT0vXKFA'
		// ),
		// ));

		// $response = curl_exec($curl);

		// curl_close($curl);
		// $rss = json_decode($response,true);
		// echo json_encode($rss['data']);

		// BYPASS master kontrak
		$rss = array(
			"meta" => array(
				"code" => 200,
				"status" => "success",
				"message" => "success"
			),
			"data" => array(
				array(
					"id" => 111,
					"description" => "Pengadaan Perangkat Hyper Converged Infrastruktur Private Cloud untuk Virtual Developer Worksapce Pada Private Cloud T.A. 2023"
				),
				array(
					"id" => 112,
					"description" => "Pengadaan Smart Link Coverage program APBN T.A 2017"
				),
				array(
					"id" => 113,
					"description" => "PEMBANGUNAN COMMAND CENTER POLDA SULBAR T.A. 2020"
				),
			),
			"total_data" => null
		);

		echo json_encode($rss['data']);
	}

	public function getUjiMaterial() {
		$kontrakId = $this->input->get('kontrakId');
		$assetId = $this->input->get('assetId');

		$isAvailable = $this->getDetailGateRFID($kontrakId, $assetId);

		$rss = array();
		if (!$isAvailable) {
			$rss = array(
				"meta" => array(
					"code" => 404,
					"status" => "failed",
					"message" => "data not found"
				),
				"data" => array(
					"isAvailable" => false,
				),
			);
		} else {
			$rss = array(
				"meta" => array(
					"code" => 200,
					"status" => "success",
					"message" => "data found"
				),
	
				"data" => array(
					"isAvailable" => true,

					"asset" => array(
						"namaAset" => "Aset 1"
					),
	
					"history" => array(
						array(
							"tahun" => "2022"
						),
						array(
							"tahun" => "2023"
						),
					)
				)
			);
		}


		echo json_encode($rss['data']);


	}

	private function getDetailGateRFID($kontrakId, $assetId) {
		// $data = array(
		// 	"data" => array(
		// 		array(
		// 			"rfid_code" => $assetId,
		// 		)
		// 	),
		// );

		// $data = json_encode($data);

		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// CURLOPT_URL => 'http://10.230.200.158:8081/api/asset/detail_gate_rfid?id_kontrak='.$kontrakId,
		// CURLOPT_RETURNTRANSFER => true,
		// CURLOPT_ENCODING => '',
		// CURLOPT_MAXREDIRS => 10,
		// CURLOPT_TIMEOUT => 0,
		// CURLOPT_FOLLOWLOCATION => true,
		// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// CURLOPT_CUSTOMREQUEST => 'GET',
		// CURLOPT_POSTFIELDS => $data,
		// CURLOPT_HTTPHEADER => array(
		// 		'apikey: $pbkdf2-sha512$6000$P4cQYmzN.X8v5bw3xhijtA$PzGUd4dnuuvvEDgwhUsvDafEKu4W4Z5McvDO5nchfAlllfNsbCXBeB5XE/KrbtFEqfM4ymR2IMzGsKWT0vXKFA'
		// 	),
		// ));

		// $response = curl_exec($curl);

		// curl_close($curl);
		// $rss = json_decode($response);

		// return $rss->data->data.length > 0;

		// BYPASS get detail gate RFID
		$rss = array(
			"data" => array(
				"data" => array()
				// "data" => array(1)
			)
		);


		return sizeof($rss["data"]["data"]) > 0;
	}

}
