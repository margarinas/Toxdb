<?php
App::uses('AppModel', 'Model');
/**
 * Call Model
 *
 * @property Event $Event
 */
class Call extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
public $belongsTo = array(
	'Event' => array(
		'className' => 'Event',
		'foreignKey' => 'event_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		)
	);




public function importCalls() {
	set_time_limit('120');
	App::uses('Folder', 'Utility');
	$dir = new Folder(WWW_ROOT.'files'.DS.'new_calls');

	$files = $dir->find('.*\.wav');
	foreach ($files as $key => $file) {

		$file = new File($dir->pwd() . DS . $file);

		$file_info = explode('-', $file->name());
		$date = strtotime($file_info[1]);

		// Get call duration
		$file->open();
		$file->offset(20);
		$rawheader = $file->read(16);
		$header = unpack('vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits',$rawheader);
		$sec = ceil($file->size()/$header['bytespersec']);
		$file->close();

		

		$data = array(
					'created' => date('Y-m-d H:i:s',$date),
					'duration' => $sec,
					'number' => $file_info[0],
					'file' => $file->name,
					'user_id' => 1
					);

		$destDir = Configure::read('CallsPath');

		if($file->copy($destDir.$file->name,false)) {
			$this->create();
			if($this->save($data)) {
				$file->delete();
			}
			
		}


		
		
	}
	return true;
}

public function beforeDelete($cascade=true)
{
	$dir = Configure::read('CallsPath');
	$file_name = $this->field('file');

	$file = new File($dir.$file_name);

	if($file->exists())
		$file->delete();

	return true;
}
}