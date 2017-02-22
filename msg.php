<?php  
class msg{
	public function showMSG($token,$userID,$txt){
		$this->insertMSG($token,$userID,$txt);
		switch ($txt) {
			case 'เบน':
				$this->replyMSG($token,"ณัฐพล คำป่าแลว");
				break;
			case 'id':
				$this->replyMSG($token,"beoneben10");
				break;
			case 'fb':
				$this->replyMSG($token,"ntkacml");
				break;
			case 'แจ้งปัญหา':
				$this->replyMSG($token,"กรุณาแจ้งข้อมูลในรูปแบบ \n แจ้งปัญหา:Internet มีปัญหาที่อาคารภูมิ:นพดล");
				$this->pushMSG($userID,"รับทราบข้อมูล \n เมื่อแก้ไขเสร็จเรียบร้อยจะแจ้งให้ทราบภายหลัง");
				sleep(20);
				$this->pushMSG($userID,'แก้ไขปัญหาเรียบร้อยแล้ว');
				break;
			default:
				$this->replyMSG($token,"เราไม่เข้าใจในสิ้งที่คุณกรอกข้อมูลเข้ามา");
				$this->pushMSG($userID,"กรุณาเลือกเมนูที่ท่านต้องการ\n1.เบน\n2.เบน1\n3.เบน2\n4.แจ้งปัญหา\n\nขอบคุณครับ ");
				break;
		}	
	}
	public function insertMSG($token,$userID,$txt){
    	$arr = array(
    						'token' => $token,
    						'userID' =>$userID,
    						'txt' =>$txt,
    						'status' => 0
    						 );
    	$this->db->insert('test26',$arr);
	
	public function pushMSG($userID,$text){
			$messages =[
				[
					'type' => 'text',
					'text' => $text
				],
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
		$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';
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
?>
