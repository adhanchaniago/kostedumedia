<?php
	require_once('generic_dao.php');

	class myfleet_history_dao extends Generic_dao  {
		public function table_name(){
			return 'myfleet_history';
		}

		public function field_map() {
			return array (	
				'mfh_mmsi' => 'mfh_mmsi',
				'mfh_name' => 'mfh_name',
				'mfh_imo' => 'mfh_imo',
				'mfh_callsign' => 'mfh_callsign',
				'mfh_flag' => 'mfh_flag',
				'mfh_photos' => 'mfh_photos',
				'mfh_publicurl' => 'mfh_publicurl',
				'mfh_type' => 'mfh_type',
				'mfh_lat' => 'mfh_lat',
				'mfh_lon' => 'mfh_lon',
				'mfh_hdg' => 'mfh_hdg',
				'mfh_course' => 'mfh_course',
				'mfh_speed' => 'mfh_speed',
				'mfh_draught' => 'mfh_draught',
				'mfh_nav_status' => 'mfh_nav_status',
				'mfh_location' => 'mfh_location',
				'mfh_destination' => 'mfh_destination',
				'mfh_etatime' => 'mfh_etatime',
				'mfh_positionreceived' => 'mfh_positionreceived',
				'mfh_lastevent_event' => 'mfh_lastevent_event',
				'mfh_lastevent_eventtime' => 'mfh_lastevent_eventtime',
				'mfh_lastport_arrival' => 'mfh_lastport_arrival',
				'mfh_lastport_departure' => 'mfh_lastport_departure',
				'mfh_lastport_locode' => 'mfh_lastport_locode',
				'mfh_lastport_name' => 'mfh_lastport_name',
				'mfh_nextport_country' => 'mfh_nextport_country',
				'mfh_nextport_countryiso2' => 'mfh_nextport_countryiso2',
				'mfh_nextport_locode' => 'mfh_nextport_locode',
				'mfh_nextport_name' => 'mfh_nextport_name',
				'mfh_last_reload' => 'mfh_last_reload'
			);
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
