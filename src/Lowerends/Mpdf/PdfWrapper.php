<?php
namespace Lowerends\Mpdf;

/**
 * A Laravel wrapper for mPDF
 *
 * @package l4-mpdf
 * @author Lowe Rends
 */
class PdfWrapper{

    /** @var \Mpdf  */
    protected $mpdf;
    protected $rendered = false;
    protected $options;

    public function __construct($mpdf){
     $this->mpdf = $mpdf;
     $this->options = array();
 }

    /**
     * Load a HTML string
     *
     * @param string $string
     * @return static
     */
    public function loadHTML($string){
        $this->html = (string) $string;
        $this->file = null;
        return $this;
    }

    /**
     * Load a HTML file
     *
     * @param string $file
     * @return static
     */
    public function loadFile($file){
        $this->html = null;
        $this->file = $file;
        return $this;
    }

    /**
     * Load a View and convert to HTML
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return static
     */
    public function loadView($view, $data = array(), $mergeData = array()){
        $this->html = \View::make($view, $data, $mergeData)->render();
        $this->file = null;
        return $this;
    }



    /**
     * Output the PDF as a string.
     *
     * @return string The rendered PDF as string
     */
    public function output(){

        if($this->html)
        {
            $mpdf->WriteHTML($this->html);
        } 
        elseif($this->file)
        {
            $mpdf->WriteHTML($this->file);
        }

        return $mpdf->Output('', 'S');
    }

    /**
     * Save the PDF to a file
     *
     * @param $filename
     * @return static
     */
    public function save($filename){

        if($this->html)
        {
            $mpdf->WriteHTML($this->html);
        } 
        elseif($this->file)
        {
            $mpdf->WriteHTML($this->file);
        }

        return $mpdf->Output($filename, 'F');
    }

    /**
     * Make the PDF downloadable by the user
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download($filename = 'document.pdf' ){

        if($this->html)
        {
            $mpdf->WriteHTML($this->html);
        } 
        elseif($this->file)
        {
            $mpdf->WriteHTML($this->file);
        }

        return $mpdf->Output($filename, 'D');
    }

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stream($filename = 'document.pdf' ){
        if($this->html)
        {
            $mpdf->WriteHTML($this->html);
        } 
        elseif($this->file)
        {
            $mpdf->WriteHTML($this->file);
        }

        return $mpdf->Output($filename, 'I');
    }

    public function __call($name, $arguments){
        return call_user_func_array (array( $this->mpdf, $name), $arguments);
    }

}
