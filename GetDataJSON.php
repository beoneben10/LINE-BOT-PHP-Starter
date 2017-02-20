<?php 
/*
Author : Wuttinan
*/

class GetData
{
        public static function getIndexProvince($provinceTHName)
        {

                $province = "สำนักงาน ฝ่ายบริหาร";
                $ex_province = explode(" ", $province);

                foreach ($ex_province as $key => $value) {
                       if($provinceTHName == $value){
                        return $key;
                        }
                }
        }
        public static function getDevision($province)
        {
                //header ('Content-type: text/html; charset=utf-8');

                $ch = curl_init(); 
                // set url สำหรับดึงข้อมูล 
                curl_setopt($ch, CURLOPT_URL, "https://www.namo.xyz/lineben/v1.php"); 
                //return the transfer as a string 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                // ตัวแปร $output เก็บข้อมูลทั้งหมดที่ดึงมา 
                $output = curl_exec($ch); 
                // ปิดการเชื่อต่อ
                curl_close($ch);    
                // output ออกไปครับ
                $obj = json_decode($output);
		foreach ($obj as $row){
			echo $row['Buil'];
			echo $row['ID'];
			echo $row['room'];
			echo $row['Devision'];
			echo $row['tel'];	
		}
                $index = self::getIndexProvince($province);
                if(isset($index)){
			
                      
                        $data_Buil = $row['Buil']->[$index];
                        $data_ID = $row['ID']->[$index];
                        $data_room = $row['room']->[$index];
                        $data_Devision = $row['Devision']->[$index];
                        $data_tel = $row['tel']->[$index];
                       

                        $data_array = array(
                        
                        "Build" => "{$data_Buil}",
                        "IDnum" => "{$data_ID}",
                        "roomdes" => "{$data_room}",
                        "Devisiondes" => "{$data_Devison}",
                        "telephone" => "{$data_tel}",
                        
                        "KEY" => "{$index}",
                        );
			
                        return $data_array;

                }else {
                        return "Province_NULL";
                }

        }

}
?>
