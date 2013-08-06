<?php
require_once dirname(__FILE__).'/view/skeleton/ViewPageSkeleton.class.php';
require_once dirname(__FILE__).'/view/sidebar/ViewShowList.class.php';
require_once dirname(__FILE__).'/view/sidebar/ViewShowItemList.class.php';
require_once dirname(__FILE__).'/view/editor/ViewEditor.class.php';
require_once dirname(__FILE__).'/view/editor/ViewPictureEditor.class.php';
require_once dirname(__FILE__).'/view/editor/ViewMovieEditor.class.php';
require_once dirname(__FILE__).'/view/filepicker/ViewFilePicker.class.php';
require_once dirname(__FILE__).'/view/filepicker/ViewPictureFilePicker.class.php';
require_once dirname(__FILE__).'/view/filepicker/ViewMovieFilePicker.class.php';
require_once dirname(__FILE__).'/jsonmodel/JsonModelRoot.class.php';

$viewRegistration = array();
$viewRegistration[] = new ViewPageSkeleton($model);
$viewRegistration[] = new ViewShowList($model);
$viewRegistration[] = new ViewShowItemList($model);
$viewRegistration[] = new ViewEditor($model);
$viewRegistration[] = new ViewPictureEditor($model);
$viewRegistration[] = new ViewMovieEditor($model);
$viewRegistration[] = new ViewFilePicker($model);
$viewRegistration[] = new ViewPictureFilePicker($model);
$viewRegistration[] = new ViewMovieFilePicker($model);
