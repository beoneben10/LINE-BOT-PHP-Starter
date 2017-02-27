<?php  
class msg{
	public function showMSG($replyToken,$userId,$text){
		//$this->conDB($replyToken,$userId,$text);
		switch ($text) {
			case 'as':
				$this->replyMSG($replyToken,"ณัฐพล คำป่าแลว");
				break;
			case 'bn':
				$this->replyMSG($replyToken,"beoneben10");
				break;
			case 'cv':
				$this->replyMSG($replyToken,"ntkacml");
				break;
			case 'แจ้งปัญหา':
				$this->replyMSG($replyToken,"กรุณาแจ้งข้อมูลให้ชัดเจน");
				$this->pushMSG($userId,"รับทราบข้อมูล \n เมื่อแก้ไขเสร็จเรียบร้อยจะแจ้งให้ทราบภายหลัง");
				sleep(1);
				$this->pushMSG($userId,'แก้ไขปัญหาเรียบร้อยแล้ว');
				break;
			default:
				$this->replyMSG($replyToken,"เราไม่เข้าใจในสิ้งที่คุณกรอกข้อมูลเข้ามา");
				$this->pushMSG($userId,"กรุณาเลือกเมนูที่ท่านต้องการ\n1.as\n2.bn\n3.cv\n4.แจ้งปัญหา\n\nขอบคุณครับ ");
				break;
		}	
	}
	/*
	public function conDB($replyToken,$userId,$text){
		$mysqli = new mysqli('mysql.hostinger.in.th','u412868043_line','line00--','u412868043_line');
		mysqli_set_charset($mysqli,"utf8");
		$query = "INSERT INTO test26 (token,userID,txt,status) VALUES ('".$replyToken."','".$userId."','".$text."','0')";
		$mysqli->query($query);
		$mysqli->close();
		$this->replyMSG($userId);
	
	
	$host = 'mysql.hostinger.in.th';
   	$port = '3306';
    	$server = $host . ':' . $port;
   	$user = 'u412868043_line';
    	$password = 'line00--';
	$database = 'u412868043_line';
	$conn = mysql_connect($server,$user,$password) or die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
	mysql_select_db($database);
	$sql = "INSERT INTO test26(token,userID,txt,status)VALUES('$token','$userID','$txt','0')";
	$result =mysql_query($sql);
	mysql_close($conn);
	$this->replyMSG($userID);
	*/
	}
	public function pushMSG($userId,$text){
			$messages =[
				[
					'type' => 'text',
					'text' => $text
				],
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/push';
			$data = [
				'to' => $userId,
				'messages' => $messages,
			];
			$this->sendMSG($url,$data);
	}
	public function replyMSG($replyToken,$ms){
			// Get replyToken
			$replyToken = $replyToken;

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
