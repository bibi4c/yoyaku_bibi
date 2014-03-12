<?php
class Appointment extends AppModel {
	var $useTable = 'appointments';
	public $primaryKey = 'appointment_id';
  const FLAG_APPOINMENT_ORDERED = 1;
  const FLAG_APPOINMENT_UNORDERED = 0;
}