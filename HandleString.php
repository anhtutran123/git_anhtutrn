<?php

class HandleString
{
    public $check1;
    public $check2;

    public function setCheck1($check)
    {
        $this->check1 = $check;
    }

    public function setCheck2($check)
    {
        $this->check2 = $check;
    }

    /**
     * read file from path
     *
     * @param string //file path
     * @return  string //contents file
     */
    public function readFile($filename)
    {
        $fp = fopen($filename, "r");

        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            // Đọc file và trả về nội dung
            $data = fread($fp, filesize($filename));
        }

        fclose($fp);
        return $data;
    }

    /**
     * check valid string
     *
     * @param string
     * @return  bool
     */
    public function checkValidString($string)
    {
        //Tạo keyword dể check chuỗi
        $a = 'after';
        $b = 'before';

        //Kiểm tra xem chuỗi có null, hơn 30 kí tự và không chứa 'before' hoặc chuỗi không rỗng không chưa 'before' và chứa 'after'
        if (is_null($string) || strlen($string) > 30 && strpos($string, $b) === false || strlen($string) > 0 && strpos($string, $b) === false && strpos($string, $a) !== false) {
            return true;
        }

        return false;
    }

    /**
     * write to an existed file
     *
     * @param string //file path
     * @return
     */
    public function writeFile($filename)
    {
        //Kiểm tra 2 giá trị check1,check2
        if ($this->check1 === true) {
            $x = 'hợp lệ';
        } else {
            $x = 'không hợp lệ';
        }

        if ($this->check2 === true) {
            $y = 'hợp lệ';
        } else {
            $y = 'không hợp lệ';
        }

        //Tạo chuỗi kết quả dựa vào 2 giá trị check1,check2
        $txt1 = "check1 là chuỗi $x.".PHP_EOL;
        $txt2 = "check2 là chuỗi $y.".PHP_EOL;

        //Mở file với mode xóa nội dung cũ và ghi mới
        $fp = fopen($filename, "w");
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            //Ghi vào file kết quả kiểm tra 2 chuỗi
            fwrite($fp, $txt1);
            fwrite($fp, $txt2);
        }

        fclose($fp);
    }
}

//Khởi tạo đối tượng
$object1 = new HandleString();

//Đọc từng file và trả kết quả về check1, check2
$c1 = $object1->readFile('file1.txt');
$c2 = $object1->checkValidString($c1);
$object1->setCheck1($c2);

$c3 = $object1->readFile('file2.txt');
$c4 = $object1->checkValidString($c3);
$object1->setCheck2($c4);

//Ghi kết quả vào file result_file.txt
$object1->writeFile('result_file.txt');

?>
