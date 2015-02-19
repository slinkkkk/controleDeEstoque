<?php
/**
 * Created by PhpStorm.
 * User: MAURÍCIO
 * Date: 11/12/2014
 * Time: 16:07
 */
    class UploadHelper {
        protected $path = '/public/uploads/' , $file , $fileName , $fileTmpName;


        public function setPath( $path )
        {
            $this->path = $path.'/';
        }

        public function setFile ( $file )
        {
            $this->file = $file;
            if($this->fileName == ""){$this->setFileName();}
            $this->setFileTmpName();
        }

        public  function setFileName( $name = null ){

            $this->fileName = ($name != "" ) ? $name : $this->file['name'];
        }

        protected function setFileTmpName(){
            $this->fileTmpName = $this->file['tmp_name'];
        }

        public function upload()
        {

            $resizeHelper = new ResizeHelper($this->file);
            $resizeHelper->resizeTo(250, 250);
            $resizeHelper->saveImage($this->file);

            if($this->fileTmpName != null ) {
                if (move_uploaded_file($this->fileTmpName, $_SERVER["DOCUMENT_ROOT"] . $this->path . $this->fileName)) {
                    return true;
                } else {
                    return false;
                }
            }else {
                return false;
            }
        }

    }