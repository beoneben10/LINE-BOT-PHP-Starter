<?php
$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';
 
class msg{
	public function showMSG($token,$userID,$txt){
		$this->conDB($token,$userID,$txt);
		switch ($txt) {
			case 'ฟิล':
				$this->replyMSG($token,"นายชลัช แย้มชื่น \n นักวิชาการคอมพิวเตอร์");
				break;
			case 'ต้า':
				$this->replyMSG($token,"นายนพดล ทองชื่นตระกูล \n\n ตำแหน่ง นวก.คอมพิวเตอร์");
				break;
			case 'มิ้น':
				$this->replyMSG($token,"น.ส.พณิชยาพร นวลคำ \n นักวิชาการคอมพิวเตอร์");
				break;
			case 'แจ้งปัญหา':
				$this->replyMSG($token,"กรุณาแจ้งข้อมูลในรูปแบบ \n แจ้งปัญหา:Internet มีปัญหาที่อาคารภูมิ:นพดล");
				$this->pushMSG($userID,"รับทราบข้อมูล \n เมื่อแก้ไขเสร็จเรียบร้อยจะแจ้งให้ทราบภายหลัง");
				sleep(20);
				$this->pushMSG($userID,'แก้ไขปัญหาเรียบร้อยแล้ว');
				break;
			default:
				$this->replyMSG($token,"เราไม่เข้าใจในสิ้งที่คุณกรอกข้อมูลเข้ามา");
				$this->pushMSG($userID,"กรุณาเลือกเมนูที่ท่านต้องการ\n1.ฟิล\n2.ต้า\n3.มิ้น\n4.แจ้งปัญหา\n\nขอบคุณครับ ");
				break;
		}	
	}
	public function conDB($token,$userID,$txt){
		$mysqli = new mysqli("mysql.hostinger.in.th", "u412868043_line", "line00--", "u412868043_line");
		mysqli_set_charset($mysqli,"utf8");
		$query = "INSERT INTO test26 (token,userID,txt,status) VALUES ('".$token."','".$userID."','".$txt."','0')";
		$mysqli->query($query);
		$mysqli->close();
		$this->replyMSG($userID);
	}
	public function pushMSG($userID,$text){
			$messages =[
				[
					'type' => 'text',
					'text' => $text
				],
				[
					'type'=>'sticker',
				    'packageId' => '1',
				    'stickerId' => '3'
				]
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = [
				'to' => $userID,
				'messages' => $messages,
			];
			$this->sendMSG($url,$data);
	}
	public function replyMSG($token,$ms){
			// Get replyToken
			$replyToken = $token;

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $ms
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$this->sendMSG($url,$data);
	}
	public function sendMSG($url,$data){
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result . "\r\n";
	}
}
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			//$text = $event['message']['text'];
			$this->showMSG($event['replyToken'],$event['source']['userId'],$event['message']['text']);
		}
	}
}
echo "OK";

