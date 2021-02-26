<?php
include('session.php'); // Includes Login Script
require_once 'vendor/bootstrap.php';
function getData($result_voice)
{
// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
$section->addText($result_voice);

/*
 * Note: it's possible to customize font style of the Text element you add in three ways:
 * - inline;
 * - using named font style (new font style object will be implicitly created);
 * - using explicitly created font style object.
 */

// Adding Text element with font customized inline...

 array('name' => 'arial', 'size' => 10);
$filename = uniqid(rand(), true) . '.docx';

// Adding Text element with font customized using named font style...
// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);
$file=urlencode($filename);

    $dir = '';
    $dirNew = "output/word";
	rename($dir.''.$filename,$dirNew.'/'.$filename);		

	$file_loc="output/word/".$filename;
	require_once 'sql.php';
$file_loc = mysqli_real_escape_string($con, $file_loc);
$file_name = mysqli_real_escape_string($con, $filename);
mysqli_query($con,"INSERT INTO File_Output(file_name,location,created_by) VALUES ('$file_name','$file_loc','$login_session')");
mysqli_close($con);
	header("Refresh:5;url=download.php");
return;
}
?>