<?php

/**
 * check valid string
 *
 * @param string
 * @return  bool
 */
function readFileText(string $filename)
{
    $fp = fopen($filename, "r");

// Kiểm tra file mở thành công không
    if (!$fp) {
        echo 'Mở file không thành công';
    } else {
        // Đọc file và trả về nội dung
        $data = fread($fp, filesize($filename));
        echo $data;
        echo "\n";
    }

    fclose($fp);
    return $data;
}

/**
 * read file from path
 *
 * @param string //file path
 * @return  string //contents file
 */
function checkValidString($string)
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

//Đọc từng file và ghi vào check1, check2
$check1 = readFileText("file1.txt");
$check2 = readFileText("file2.txt");

//Kiểm tra chuỗi text1
if (checkValidString($check1) == true) {
    echo "Chuỗi text1 hợp lệ";
    echo "\n";
} else {
    echo "Chuỗi text1 không hợp lệ";
}

//Kiểm tra chuỗi text2
if (checkValidString($check2) == true) {
    echo "Chuỗi text2 hợp lệ";
    echo "\n";
} else {
    echo "Chuỗi text2 không hợp lệ";
}
?>
