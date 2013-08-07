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




// public function fetchCalls($date = array()) {
// 	set_time_limit('120');
// 	$callsDir = Configure::read('CallsPath');


// 	App::import('Vendor', 'Zend/Loader/StandardAutoloader');
// 	$autoLoader = new Zend\Loader\StandardAutoloader(array('autoregister_zf' => true));;
// 	$autoLoader->register(); 

// 		//App::import('Vendor', 'Imap', true, false, 'Zend/Mail/Storage/Imap.php');
// 		//$zend = new Imap();
// 	$mail = new Zend\Mail\Storage\Imap(array(
// 		'host'     => 'smtp.gmail.com',
// 		'user'     => 'esscitcentras@gmail.com',
// 		'password' => '2002Akibtele',
// 		'ssl'      => 'SSL'));
// 	// $new = $mail->seek(array('NEW'));
// 	$allMsg = $mail->countMessages();

// 	for ($i = $allMsg; $i >= 1; $i--)
// 	{
// 		$message = $mail->getMessage($i);
// 		 // pr($message->getHeaders());
//     //new message found!
// 		if (!$message->hasFlag(Zend\Mail\Storage::FLAG_SEEN) && $message->isMultipart()) {
// 			$part = $message->getPart(2);
// 			$number = $message->getHeader('xcallingtelephonenumber','string');
// 			if ($part->getHeaderField('Content-Type') == 'audio/wav') {

// 				$date = $message->getHeader('date','string');
// 				$file_name = date('Ymd_His_',strtotime($date)).$part->getHeaderField('Content-Type','name');
				
// 				$file = new File($callsDir.$file_name);
				
// 				$data = array(
// 					'created' => date('Y-m-d H:i:s',strtotime($date)),
// 					'duration' => $message->getHeader('xvoicemessageduration','string'),
// 					'number' => $message->getHeader('xcallingtelephonenumber','string'),
// 					'file' => $file_name,
// 					'user_id' => 1
// 					);
// 				if(!$file->exists()) {
// 					$this->create();
// 					$this->save($data);

// 					$file_content = base64_decode($part);
// 					$file->create();
// 				// $file = new File($callsDir.$file_name, true, 0644);
// 					$file->write($file_content);

// 					$file->close();
// 				}

// 			}
			
// 		}

// 	}
// 	return true;

// }

public function importCalls() {
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